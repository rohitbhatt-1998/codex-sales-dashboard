<h1>Call System</h1>
<section class="panel">
<h3>Select Customers</h3>
<form method="post" action="/calls/call-now">
<div class="customer-grid">
<?php foreach ($customers as $c): ?>
<label><input type="checkbox" name="customer_ids[]" value="<?= (int)$c['id'] ?>"> <?= htmlspecialchars($c['name']) ?> (<?= htmlspecialchars($c['phone']) ?>)</label>
<?php endforeach; ?>
</div>
<button type="submit">Call Now</button>
</form>
</section>

<section class="panel">
<h3>Call Logs</h3>
<table>
<thead><tr><th>Customer</th><th>Phone</th><th>Call Provider</th><th>AI Provider</th><th>Duration</th><th>Lead</th><th>Conversation</th><th>Date</th></tr></thead>
<tbody>
<?php foreach ($logs as $log): ?>
<tr>
  <td><?= htmlspecialchars($log['customer_name']) ?></td>
  <td><?= htmlspecialchars($log['phone']) ?></td>
  <td><?= htmlspecialchars($log['provider_used']) ?></td>
  <td><?= htmlspecialchars($log['ai_provider_used']) ?></td>
  <td><?= (int)$log['duration_seconds'] ?>s</td>
  <td><?= htmlspecialchars($log['lead_status']) ?></td>
  <td><pre><?= htmlspecialchars($log['conversation']) ?></pre></td>
  <td><?= htmlspecialchars($log['created_at']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</section>
