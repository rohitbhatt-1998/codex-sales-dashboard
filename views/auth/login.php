<!doctype html><html><head><meta charset="UTF-8"><title>Login</title><link rel="stylesheet" href="<?= url('/public/assets/css/app.css') ?>"></head><body>
<div class="auth-card">
<h1>Login</h1>
<?php if (!empty($error)): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" action="<?= url('/login') ?>">
<input name="email" type="email" placeholder="Email" required>
<input name="password" type="password" placeholder="Password" required>
<button type="submit">Login</button>
</form>
<p>No account? <a href="<?= url('/register') ?>">Register</a></p>
</div>
</body></html>
