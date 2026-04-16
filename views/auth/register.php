<!doctype html><html><head><meta charset="UTF-8"><title>Register</title><link rel="stylesheet" href="<?= url('/public/assets/css/app.css') ?>"></head><body>
<div class="auth-card">
<h1>Register</h1>
<?php if (!empty($error)): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" action="<?= url('/register') ?>">
<!doctype html><html><head><meta charset="UTF-8"><title>Register</title><link rel="stylesheet" href="/public/assets/css/app.css"></head><body>
<div class="auth-card">
<h1>Register</h1>
<?php if (!empty($error)): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<form method="post" action="/register">
<input name="name" placeholder="Full Name" required>
<input name="email" type="email" placeholder="Email" required>
<input name="password" type="password" placeholder="Password (min 6 chars)" required>
<button type="submit">Create account</button>
</form>
<p>Already have account? <a href="<?= url('/login') ?>">Login</a></p>
<p>Already have account? <a href="/login">Login</a></p>
</div>
</body></html>
