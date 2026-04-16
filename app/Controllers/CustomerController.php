<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Session;
use App\Core\View;
use App\Models\Customer;

class CustomerController
{
    public function index(): void
    {
        Auth::requireLogin();
        $user = Auth::user();
        $customers = Customer::allByUser((int)$user['id']);
        View::render('customers/index', [
            'customers' => $customers,
            'message' => Session::flash('success'),
        ]);
    }

    public function store(): void
    {
        Auth::requireLogin();
        $user = Auth::user();

        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $customFields = $this->parseCustomFields($_POST['custom_fields'] ?? '');

        if (!$name || !$phone) {
            Session::flash('success', 'Name and phone are required');
            header('Location: /customers');
            return;
        }

        Customer::create(['user_id' => (int)$user['id'], 'name' => $name, 'phone' => $phone, 'custom_fields' => $customFields]);
        Session::flash('success', 'Customer added successfully');
        header('Location: /customers');
    }

    public function update(): void
    {
        Auth::requireLogin();
        $user = Auth::user();
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $customFields = $this->parseCustomFields($_POST['custom_fields'] ?? '');

        if ($id && $name && $phone) {
            Customer::update($id, (int)$user['id'], ['name' => $name, 'phone' => $phone, 'custom_fields' => $customFields]);
            Session::flash('success', 'Customer updated');
        }

        header('Location: /customers');
    }

    public function delete(): void
    {
        Auth::requireLogin();
        $user = Auth::user();
        $id = (int)($_POST['id'] ?? 0);
        if ($id) {
            Customer::delete($id, (int)$user['id']);
            Session::flash('success', 'Customer deleted');
        }
        header('Location: /customers');
    }

    public function uploadCsv(): void
    {
        Auth::requireLogin();
        $user = Auth::user();

        if (empty($_FILES['csv']['tmp_name'])) {
            Session::flash('success', 'CSV file required');
            header('Location: /customers');
            return;
        }

        $handle = fopen($_FILES['csv']['tmp_name'], 'r');
        if (!$handle) {
            Session::flash('success', 'Could not open CSV');
            header('Location: /customers');
            return;
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            Session::flash('success', 'Invalid CSV format');
            header('Location: /customers');
            return;
        }

        while (($row = fgetcsv($handle)) !== false) {
            $assoc = array_combine($header, $row);
            $name = trim($assoc['name'] ?? '');
            $phone = trim($assoc['phone'] ?? '');
            if (!$name || !$phone) {
                continue;
            }
            unset($assoc['name'], $assoc['phone']);
            Customer::create(['user_id' => (int)$user['id'], 'name' => $name, 'phone' => $phone, 'custom_fields' => $assoc]);
        }

        fclose($handle);
        Session::flash('success', 'CSV uploaded successfully');
        header('Location: /customers');
    }

    private function parseCustomFields(string $input): array
    {
        $result = [];
        $pairs = array_filter(array_map('trim', explode(',', $input)));
        foreach ($pairs as $pair) {
            if (!str_contains($pair, ':')) {
                continue;
            }
            [$k, $v] = array_map('trim', explode(':', $pair, 2));
            if ($k !== '') {
                $result[$k] = $v;
            }
        }
        return $result;
    }
}
