<h1>Customers</h1>
<section class="panel">
  <h3>Add Customer</h3>
  <form method="post" action="/customers/store" class="grid-form">
    <input name="name" placeholder="Name" required>
    <input name="phone" placeholder="Phone" required>
    <input name="custom_fields" placeholder="Custom fields (key:value,key2:value2)">
    <button type="submit">Add</button>
  </form>
</section>

<section class="panel">
  <h3>Upload CSV</h3>
  <form method="post" action="/customers/upload-csv" enctype="multipart/form-data">
    <input type="file" name="csv" accept=".csv" required>
    <button type="submit">Upload</button>
  </form>
</section>

<table>
<thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Custom Fields</th><th>Status</th><th>Actions</th></tr></thead>
<tbody>
<?php foreach ($customers as $c): ?>
<tr>
  <td><?= (int)$c['id'] ?></td>
  <td><?= htmlspecialchars($c['name']) ?></td>
  <td><?= htmlspecialchars($c['phone']) ?></td>
  <td><code><?= htmlspecialchars($c['custom_fields']) ?></code></td>
  <td><?= htmlspecialchars($c['call_status']) ?></td>
  <td>
    <form method="post" action="/customers/delete" onsubmit="return confirm('Delete customer?')">
      <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
      <button type="submit">Delete</button>
    </form>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
