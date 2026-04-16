<?php
namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $basePath = __DIR__ . '/../../views/';
        include $basePath . 'partials/header.php';
        include $basePath . $view . '.php';
        include $basePath . 'partials/footer.php';
    }

    public static function renderAuth(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        include __DIR__ . '/../../views/' . $view . '.php';
    }
}
