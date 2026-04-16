<?php use App\Core\Auth; use App\Core\Session; $user = Auth::user(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>AI Sales Agent</title>
    <link rel="stylesheet" href="/public/assets/css/app.css">
</head>
<body>
<div class="layout">
    <aside>
        <h2>AI Sales Agent</h2>
        <?php if ($user): ?>
            <p><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['role']) ?>)</p>
            <nav>
                <a href="/dashboard">Dashboard</a>
                <a href="/customers">Customers</a>
                <a href="/calls">Calls</a>
                <a href="/knowledge-base">Knowledge Base</a>
                <?php if ($user['role'] === 'admin'): ?><a href="/settings">Settings</a><?php endif; ?>
                <a href="/logout">Logout</a>
            </nav>
        <?php endif; ?>
    </aside>
    <main>
        <?php if ($msg = Session::flash('success')): ?><div class="alert"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
