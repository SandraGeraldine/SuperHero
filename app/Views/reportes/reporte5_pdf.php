<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Reporte de Superhéroe</title>
    <?= $estilos ?>
</head>
<body class="pdf-body">
    <!-- Mi plantilla para PDF -->
    <div class="header">
        <h1>MI REPORTE DE SUPERHÉROE </h1>
        <p>Información completa y detallada del personaje</p>
        <small>Generado el <?= date('d/m/Y H:i:s') ?> por Sandra De La Cruz</small>
    </div>

    <div class="hero-card">
        <div class="hero-name">
            <?= $superhero['superhero_name'] ?? 'Sin nombre' ?> 
        </div>
        
        <div class="hero-real-name">
            "<?= $superhero['full_name'] ?? 'Nombre real no disponible' ?>"
        </div>

        <h2 style="color: #2c3e50; text-align: center; margin: 15px 0; font-size: 18px;">
             INFORMACIÓN COMPLETA DEL SUPERHÉROE
        </h2>

        <!-- INFORMACIÓN BÁSICA EN TABLA -->
        <table class="table mb-2">
            <colgroup>
                <col style="width:30%;">
                <col style="width:70%;">
            </colgroup>
            <thead>
                <tr class="bg-primary text-center">
                    <th>Campo</th>
                    <th>Información</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"><strong>Editorial/Compania</strong></td>
                    <td><strong><?= $superhero['publisher_name'] ?? 'No especificada' ?></strong></td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Alineacion Moral</strong></td>
                    <td>
                        <?php
                        $alignment = $superhero['alignment'] ?? 'Unknown';
                        $alignmentClass = 'alignment-unknown';
                        
                        switch($alignment) {
                            case 'Good':
                                $alignmentClass = 'alignment-good';
                                $alignmentText = 'Bueno';
                                break;
                            case 'Bad':
                                $alignmentClass = 'alignment-bad';
                                $alignmentText = 'Malo';
                                break;
                            case 'Neutral':
                                $alignmentClass = 'alignment-neutral';
                                $alignmentText = 'Neutral';
                                break;
                            default:
                                $alignmentText = 'Desconocido';
                        }
                        ?>
                        <span class="alignment-badge <?= $alignmentClass ?>">
                            <?= $alignmentText ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Altura Fisica</strong></td>
                    <td>
                        <?php 
                        if (!empty($superhero['height_cm'])) {
                            echo '<strong>' . $superhero['height_cm'] . ' cm</strong>';
                            $meters = $superhero['height_cm'] / 100;
                            echo ' (' . number_format($meters, 2) . ' metros)';
                            
                            if ($superhero['height_cm'] > 200) {
                                echo ' - Muy alto!';
                            } elseif ($superhero['height_cm'] < 150) {
                                echo ' - Compacto';
                            } else {
                                echo ' - Altura normal';
                            }
                        } else {
                            echo 'No especificada';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><strong>Peso Corporal</strong></td>
                    <td>
                        <?php 
                        if (!empty($superhero['weight_kg'])) {
                            echo '<strong>' . $superhero['weight_kg'] . ' kg</strong>';
                            $pounds = $superhero['weight_kg'] * 2.205;
                            echo ' (' . round($pounds) . ' lbs)';
                            
                            if ($superhero['weight_kg'] > 100) {
                                echo ' - Fuerte!';
                            } else {
                                echo ' - Agil';
                            }
                        } else {
                            echo 'No especificado';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-center"><strong>ID en Base de Datos</strong></td>
                    <td>
                        <strong>#<?= $superhero['id'] ?></strong>
                        <small style="color: #6c757d;"> (identificador único)</small>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- ATRIBUTOS DE PODER EN TABLA -->
        <?php if (!empty($attributes)): ?>
        <h3 style="color: #2c3e50; text-align: center; margin: 15px 0; font-size: 16px;">
            ATRIBUTOS DE PODER
        </h3>
        <table class="table mb-2">
            <colgroup>
                <col style="width:25%;">
                <col style="width:15%;">
                <col style="width:40%;">
                <col style="width:20%;">
            </colgroup>
            <thead>
                <tr class="bg-secondary text-center">
                    <th>Atributo</th>
                    <th>Valor</th>
                    <th>Barra de Progreso</th>
                    <th>Nivel</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attributes as $attr): ?>
                <tr class="text-center">
                    <td>
                        <strong>
                            <?php
                            switch($attr['attribute_name']) {
                                case 'Intelligence': echo 'Intelligence'; break;
                                case 'Strength': echo 'Strength'; break;
                                case 'Speed': echo 'Speed'; break;
                                case 'Durability': echo 'Durability'; break;
                                case 'Power': echo 'Power'; break;
                                case 'Combat': echo 'Combat'; break;
                                default: echo $attr['attribute_name']; break;
                            }
                            ?>
                        </strong>
                    </td>
                    <td><strong><?= $attr['attribute_value'] ?>/100</strong></td>
                    <td>
                        <!-- Barra de progreso -->
                        <div style="background: #e9ecef; border-radius: 8px; width: 100%; height: 12px; overflow: hidden; display: inline-block;">
                            <?php 
                            $value = $attr['attribute_value'];
                            $barColor = '#e74c3c, #c0392b';
                            if ($value >= 80) $barColor = '#27ae60, #2ecc71';
                            elseif ($value >= 60) $barColor = '#f39c12, #e67e22';
                            elseif ($value >= 40) $barColor = '#3498db, #2980b9';
                            ?>
                            <div style="background: linear-gradient(90deg, <?= $barColor ?>); height: 100%; width: <?= $attr['attribute_value'] ?>%; border-radius: 8px;"></div>
                        </div>
                    </td>
                    <td>
                        <small style="color: #6c757d; font-size: 11px;">
                            <?php
                            if ($value >= 90) echo 'Excepcional';
                            elseif ($value >= 80) echo 'Excelente';
                            elseif ($value >= 70) echo 'Muy Bueno';
                            elseif ($value >= 60) echo 'Bueno';
                            elseif ($value >= 50) echo 'Promedio';
                            else echo 'Bajo';
                            ?>
                        </small>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <!-- SUPERPODERES EN TABLA -->
        <?php if (!empty($powers)): ?>
        <h3 style="color: #2c3e50; text-align: center; margin: 15px 0; font-size: 16px;">
            SUPERPODERES
        </h3>
        <table class="table mb-2">
            <colgroup>
                <col style="width:15%;">
                <col style="width:85%;">
            </colgroup>
            <thead>
                <tr class="bg-danger text-center">
                    <th>N°</th>
                    <th>Superpoder</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $powerCount = 0;
                foreach ($powers as $power): 
                    $powerCount++;
                ?>
                <tr>
                    <td class="text-center"><strong><?= $powerCount ?></strong></td>
                    <td><strong><?= $power['power_name'] ?></strong></td>
                </tr>
                <?php endforeach; ?>
                <tr class="bg-secondary">
                    <td class="text-center"><strong>TOTAL</strong></td>
                    <td><strong>Total: <?= count($powers) ?> superpoderes unicos</strong></td>
                </tr>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p><strong>Sistema de Gestion de Superheroes</strong></p>
        <p>Desarrollado por <strong>Sandra De La Cruz</strong> - Proyecto Tarea05</p>
        <p>Este documento fue generado con el fin de poder lograr Practicar y interactuar con la base de datos Superhero</p>
        <p style="margin-top: 15px; font-size: 11px; color: #9ca3af;">
             <em>Gracias por llegar hasta esta parte de mi buscador de superheroes!</em> 
        </p>
    </div>

</body>
</html>