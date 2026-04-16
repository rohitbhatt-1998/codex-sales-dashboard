<h1>Dashboard</h1>
<div class="stats">
  <div class="card"><h3>Total Calls</h3><p><?= (int)$stats['total'] ?></p></div>
  <div class="card"><h3>Completed</h3><p><?= (int)$stats['completed'] ?></p></div>
  <div class="card"><h3>Pending</h3><p><?= (int)$stats['pending'] ?></p></div>
  <div class="card"><h3>Failed</h3><p><?= (int)$stats['failed'] ?></p></div>
</div>
