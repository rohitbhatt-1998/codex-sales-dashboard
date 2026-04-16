<h1>Knowledge Base</h1>
<section class="panel">
<form method="post" action="<?= url('/knowledge-base/upload') ?>" enctype="multipart/form-data">
<form method="post" action="/knowledge-base/upload" enctype="multipart/form-data">
<input type="file" name="doc" accept=".txt,.pdf" required>
<button type="submit">Upload PDF/TXT</button>
</form>
</section>
<table>
<thead><tr><th>File</th><th>Type</th><th>Stored Path</th><th>Added</th></tr></thead>
<tbody>
<?php foreach ($items as $item): ?>
<tr>
  <td><?= htmlspecialchars($item['file_name']) ?></td>
  <td><?= htmlspecialchars($item['file_type']) ?></td>
  <td><?= htmlspecialchars($item['stored_path']) ?></td>
  <td><?= htmlspecialchars($item['created_at']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
