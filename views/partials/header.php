<?php use App\Core\Auth; use App\Core\Session; $user = Auth::user(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>AI Sales Agent</title>
    <link rel="stylesheet" href="<?= url('/public/assets/css/app.css') ?>">
</head>
<body>
<div class="layout">
    <aside>
        <h2>AI Sales Agent</h2>
        <?php if ($user): ?>
            <p><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['role']) ?>)</p>
            <nav>
                <a href="<?= url('/dashboard') ?>">Dashboard</a>
                <a href="<?= url('/customers') ?>">Customers</a>
                <a href="<?= url('/calls') ?>">Calls</a>
                <a href="<?= url('/knowledge-base') ?>">Knowledge Base</a>
                <?php if ($user['role'] === 'admin'): ?><a href="<?= url('/settings') ?>">Settings</a><?php endif; ?>
                <a href="<?= url('/logout') ?>">Logout</a>
            </nav>
        <?php endif; ?>
    </aside>
    <main>
        <?php if ($msg = Session::flash('success')): ?><div class="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
