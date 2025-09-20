<h1 style="text-align:center;">Reporte de Superhéroes por Publisher</h1>

<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">
  <thead>
    <tr style="background-color: #f2f2f2;">
      <th>ID</th>
      <th>Nombre del Superhéroe</th>
      <th>Nombre Completo</th>
      <th>Publisher</th>
      <th>Alineación</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($rows)): ?>
      <tr>
        <td colspan="5" style="text-align:center;">No hay datos para mostrar</td>
      </tr>
    <?php else: ?>
      <?php foreach ($rows as $row): ?>
        <tr>
          <td><?= esc($row['id']) ?></td>
          <td><?= esc($row['superhero_name']) ?></td>
          <td><?= esc($row['full_name']) ?></td>
          <td><?= esc($row['publisher_name']) ?></td>
          <td><?= esc($row['alignment']) ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
