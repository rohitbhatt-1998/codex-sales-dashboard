<?php
namespace App\Services;

use App\Models\Customer;
use App\Models\Setting;
use App\Models\CallLog;
use App\Models\KnowledgeBase;
use App\Services\CallProviders\TwilioProvider;
use App\Services\CallProviders\ExotelProvider;
use App\Services\AIProviders\OpenRouterProvider;
use App\Services\AIProviders\CohereProvider;

class CallEngine
{
    public function processCalls(int $userId, array $customers): array
    {
        $results = [];
        $settings = Setting::all();

        foreach ($customers as $customer) {
            Customer::markStatus((int)$customer['id'], 'Calling');

            $callOutcome = $this->makeCallWithFallback($customer['phone'], (string)($settings['call_provider'] ?? 'twilio'), $settings);
            if (!$callOutcome['success']) {
                Customer::markStatus((int)$customer['id'], 'Failed');
                $results[] = ['customer' => $customer['name'], 'status' => 'Failed', 'message' => $callOutcome['error']];
                continue;
            }

            $ai = $this->resolveAI((string)($settings['ai_provider'] ?? 'openrouter'), $settings);
            $agentName = $settings['agent_name'] ?? 'Olama';
            $kb = KnowledgeBase::combinedText($userId);
            $aiResult = $ai['provider']->generateConversation($agentName, $customer, $kb);
            $conversationText = json_encode($aiResult['conversation'], JSON_UNESCAPED_UNICODE);

            CallLog::create([
                'user_id' => $userId,
                'customer_id' => $customer['id'],
                'provider_used' => $callOutcome['provider_used'],
                'ai_provider_used' => $ai['name'],
                'conversation' => $conversationText,
                'duration_seconds' => $aiResult['duration'],
                'lead_status' => $aiResult['lead_status'],
            ]);

            Customer::markStatus((int)$customer['id'], 'Completed');
            $results[] = ['customer' => $customer['name'], 'status' => 'Completed', 'message' => 'Call finished'];
        }

        return $results;
    }

    private function makeCallWithFallback(string $phone, string $selected, array $settings): array
    {
        $providers = [
            'twilio' => new TwilioProvider($settings['twilio_sid'] ?? '', $settings['twilio_token'] ?? '', $settings['twilio_from'] ?? ''),
            'exotel' => new ExotelProvider($settings['exotel_sid'] ?? '', $settings['exotel_token'] ?? '', $settings['exotel_from'] ?? ''),
        ];

        $first = $selected === 'exotel' ? 'exotel' : 'twilio';
        $second = $first === 'twilio' ? 'exotel' : 'twilio';

        $r1 = $providers[$first]->makeCall($phone, 'Outbound AI sales call');
        if ($r1['success']) {
            return ['success' => true, 'provider_used' => ucfirst($first), 'call_id' => $r1['call_id']];
        }

        $r2 = $providers[$second]->makeCall($phone, 'Outbound AI sales call');
        if ($r2['success']) {
            return ['success' => true, 'provider_used' => ucfirst($second), 'call_id' => $r2['call_id']];
        }

        return ['success' => false, 'error' => $r1['error'] . '; fallback failed: ' . ($r2['error'] ?? 'unknown')];
    }

    private function resolveAI(string $selected, array $settings): array
    {
        if ($selected === 'cohere') {
            return ['name' => 'Cohere', 'provider' => new CohereProvider($settings['cohere_api_key'] ?? '')];
        }
        return ['name' => 'OpenRouter', 'provider' => new OpenRouterProvider($settings['openrouter_api_key'] ?? '')];
    }
}
