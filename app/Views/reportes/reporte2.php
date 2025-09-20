<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Reporte</title>
  <?= $estilos ?>
</head>
<body>

  <div class="text-center mb-1">
    <h1>Reporte De Productos de ventas</h1>
    <h2>Area <?= htmlspecialchars($area) ?></h2>
  </div>

  <table class="table mb-2">
    <colgroup>
      <col style="width:10%;">
      <col style="width:60%;">
      <col style="width:30%;">
    </colgroup>
    <thead>
      <tr class="bg-primary text-center">
        <th>#</th>
        <th>Productos</th>
        <th>Precio</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($productos as $index => $producto): ?>
        <tr class="text-center">
          <td><?= $index + 1 ?></td>
          <td><?= htmlspecialchars($producto['Descripcion']) ?></td>
          <td><?= htmlspecialchars($producto['Precio']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <strong> Autor : <?= htmlspecialchars($autor) ?></strong>

</body>
</html>
