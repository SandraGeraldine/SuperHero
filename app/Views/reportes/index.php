<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Seleccionar Publisher</title>
</head>
<body>
  <form action="<?= base_url('reportes/reporte4') ?>" method="post">
    <?= csrf_field() ?>
    <label for="publisher">Selecciona un publisher:</label>
    <select id="publisher" name="publisher_id" required>
      <option value="">-- Selecciona --</option>
      <?php foreach($publishers as $pub): ?>
        <option value="<?= esc($pub['id']) ?>"><?= esc($pub['publisher_name']) ?></option>
      <?php endforeach; ?>
    </select>
    <button type="submit">Generar Reporte</button>
  </form>
</body>
</html>

