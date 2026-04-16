<?php

if (!function_exists('base_path_url')) {
    function base_path_url(): string
    {
        return defined('BASE_PATH') ? BASE_PATH : '';
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string
    {
        $base = rtrim(base_path_url(), '/');
        $path = '/' . ltrim($path, '/');
        return ($base === '' ? '' : $base) . ($path === '/' ? '' : $path);
    }
}
