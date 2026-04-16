<?php
namespace App\Services\CallProviders;

class ExotelProvider implements CallProviderInterface
{
    public function __construct(private string $sid, private string $token, private string $from)
    {
    }

    public function makeCall(string $toNumber, string $message): array
    {
        if (empty($this->sid) || empty($this->token) || empty($this->from)) {
            return ['success' => false, 'error' => 'Exotel credentials missing'];
        }

        return ['success' => true, 'call_id' => 'EX-' . uniqid()];
    }
}
