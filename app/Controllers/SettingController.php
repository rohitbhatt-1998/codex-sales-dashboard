<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Session;
use App\Core\View;
use App\Models\Setting;

class SettingController
{
    public function index(): void
    {
        Auth::requireAdmin();
        View::render('settings/index', ['settings' => Setting::all(), 'message' => Session::flash('success')]);
    }

    public function save(): void
    {
        Auth::requireAdmin();

        $allowed = [
            'call_provider', 'ai_provider', 'agent_name',
            'twilio_sid', 'twilio_token', 'twilio_from',
            'exotel_sid', 'exotel_token', 'exotel_from',
            'openrouter_api_key', 'cohere_api_key',
        ];

        foreach ($allowed as $key) {
            Setting::set($key, trim((string)($_POST[$key] ?? '')));
        }

        Session::flash('success', 'Settings saved');
        header('Location: /settings');
    }
}
