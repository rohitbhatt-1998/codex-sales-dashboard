<?php
namespace App\Core;

class Auth
{
    public static function user(): ?array
    {
        return Session::get('user');
    }

    public static function check(): bool
    {
        return Session::has('user');
    }

    public static function isAdmin(): bool
    {
        $user = self::user();
        return $user && $user['role'] === 'admin';
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireAdmin(): void
    {
        self::requireLogin();
        if (!self::isAdmin()) {
            http_response_code(403);
            exit('Access denied');
        }
    }
}
