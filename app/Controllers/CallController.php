<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Session;
use App\Core\View;
use App\Models\Customer;
use App\Models\CallLog;
use App\Services\CallEngine;

class CallController
{
    public function index(): void
    {
        Auth::requireLogin();
        $user = Auth::user();
        $customers = Customer::allByUser((int)$user['id']);
        $logs = CallLog::allByUser((int)$user['id']);
        View::render('calls/index', [
            'customers' => $customers,
            'logs' => $logs,
            'message' => Session::flash('success'),
        ]);
    }

    public function callNow(): void
    {
        Auth::requireLogin();
        $user = Auth::user();
        $ids = $_POST['customer_ids'] ?? [];
        $ids = array_map('intval', is_array($ids) ? $ids : [$ids]);
        $customers = Customer::findByIdsForUser($ids, (int)$user['id']);

        if (!$customers) {
            Session::flash('success', 'No customers selected');
            header('Location: /calls');
            return;
        }

        $engine = new CallEngine();
        $results = $engine->processCalls((int)$user['id'], $customers);
        $done = count(array_filter($results, fn($r) => $r['status'] === 'Completed'));
        $failed = count($results) - $done;

        Session::flash('success', "Calling done: {$done} completed, {$failed} failed.");
        header('Location: /calls');
    }
}
