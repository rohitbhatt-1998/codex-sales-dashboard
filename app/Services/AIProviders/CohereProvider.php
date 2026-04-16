<?php
namespace App\Services\AIProviders;

class CohereProvider implements AIProviderInterface
{
    public function __construct(private string $apiKey)
    {
    }

    public function generateConversation(string $agentName, array $customer, string $knowledgeBase): array
    {
        $intro = "Hi {$customer['name']}, {$agentName} here calling from AI Sales Agent.";
        $kb = $knowledgeBase ? 'Based on our knowledge base, we can solve onboarding and conversion bottlenecks.' : 'We improve lead conversion with AI calls.';
        $conversation = [
            ['speaker' => $agentName, 'text' => $intro],
            ['speaker' => 'Customer', 'text' => 'What problem do you solve?'],
            ['speaker' => $agentName, 'text' => $kb],
            ['speaker' => 'Customer', 'text' => 'Let me discuss and revert soon.'],
        ];
        $status = ['Warm', 'Cold'][array_rand(['Warm', 'Cold'])];
        return ['conversation' => $conversation, 'duration' => rand(60, 280), 'lead_status' => $status];
    }
}
