<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte de Superhéroes por Editorial</title>
    <?= $estilos ?>
</head>
<body>

<div class="text-center mb-3">
    <h1>Reporte de Superhéroes por Editorial</h1>
    <h2>Sistema de Gestión - SENATI</h2>
</div>

<table class="table mb-2">
    <colgroup>
        <col style="width:8%;">
        <col style="width:25%;">
        <col style="width:35%;">
        <col style="width:20%;">
        <col style="width:12%;">
    </colgroup>
    <thead>
        <tr class="bg-primary text-center">
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
                <td colspan="5" class="text-center">No hay datos para mostrar</td>
            </tr>
        <?php else: ?>
            <?php foreach ($rows as $row): ?>
                <tr class="text-center">
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

<div class="text-center mt-3">
    <strong>Desarrollado por Sandra De La Cruz - SENATI</strong>
</div>

</body>
</html>
