<?php
namespace App\Services\AIProviders;

class OpenRouterProvider implements AIProviderInterface
{
    public function __construct(private string $apiKey)
    {
    }

    public function generateConversation(string $agentName, array $customer, string $knowledgeBase): array
    {
        $intro = "Hello {$customer['name']}, this is {$agentName} from AI Sales Agent.";
        $kbLine = $knowledgeBase ? 'We offer tailored solutions based on your business requirements.' : 'We help teams automate sales outreach.';
        $conversation = [
            ['speaker' => $agentName, 'text' => $intro],
            ['speaker' => 'Customer', 'text' => 'Can you explain your service and pricing?'],
            ['speaker' => $agentName, 'text' => $kbLine . ' Our plans are flexible and scalable.'],
            ['speaker' => 'Customer', 'text' => 'Sounds good, send me details.'],
        ];
        return ['conversation' => $conversation, 'duration' => rand(80, 320), 'lead_status' => 'Hot'];
    }
}
