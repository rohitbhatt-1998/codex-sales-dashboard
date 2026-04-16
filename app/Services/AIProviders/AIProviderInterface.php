<?php
namespace App\Services\AIProviders;

interface AIProviderInterface
{
    public function generateConversation(string $agentName, array $customer, string $knowledgeBase): array;
}
