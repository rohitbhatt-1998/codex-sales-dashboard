<?php
namespace App\Services\CallProviders;

class TwilioProvider implements CallProviderInterface
{
    public function __construct(private string $sid, private string $token, private string $from)
    {
    }

    public function makeCall(string $toNumber, string $message): array
    {
        if (empty($this->sid) || empty($this->token) || empty($this->from)) {
            return ['success' => false, 'error' => 'Twilio credentials missing'];
        }

        $simulateFail = str_ends_with($toNumber, '9');
        if ($simulateFail) {
            return ['success' => false, 'error' => 'Twilio simulated failure'];
        }

        return ['success' => true, 'call_id' => 'TW-' . uniqid()];
    }
}
