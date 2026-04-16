<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Models\Customer;

class DashboardController
{
    public function index(): void
    {
        Auth::requireLogin();
        $user = Auth::user();
        $stats = Customer::dashboardStats((int)$user['id']);
        View::render('dashboard/index', ['stats' => $stats]);
    }
}
