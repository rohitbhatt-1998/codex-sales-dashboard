<?php
namespace App\Controllers;

use App\Core\Session;
use App\Core\View;
use App\Models\User;

class AuthController
{
    public function showLogin(): void
    {
        View::renderAuth('auth/login', ['error' => Session::flash('error')]);
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            Session::flash('error', 'Invalid credentials');
            header('Location: ' . url('/login'));
            exit;
        }

        unset($user['password']);
        Session::set('user', $user);
        header('Location: ' . url('/dashboard'));
    }

    public function showRegister(): void
    {
        View::renderAuth('auth/register', ['error' => Session::flash('error')]);
    }

    public function register(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$name || !$email || strlen($password) < 6) {
            Session::flash('error', 'Invalid input data');
            header('Location: ' . url('/register'));
            exit;
        }

        if (User::findByEmail($email)) {
            Session::flash('error', 'Email already registered');
            header('Location: ' . url('/register'));
            exit;
        }

        User::create(['name' => $name, 'email' => $email, 'password' => $password, 'role' => 'user']);
        header('Location: ' . url('/login'));
    }

    public function logout(): void
    {
        Session::destroy();
        header('Location: ' . url('/login'));
    }
}
