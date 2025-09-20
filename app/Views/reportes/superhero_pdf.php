<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte 5 - Superhéroe</title>
    <?= $estilos ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f5f5f5;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
        }
        .hero-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .hero-name {
            color: #2c3e50;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
        .hero-real-name {
            color: #7f8c8d;
            font-size: 18px;
            text-align: center;
            margin-bottom: 30px;
            font-style: italic;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-top: 20px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            background-color: #3498db;
            color: white;
            padding: 15px;
            font-weight: bold;
            width: 30%;
            vertical-align: middle;
        }
        .info-value {
            display: table-cell;
            background-color: #ecf0f1;
            padding: 15px;
            border-left: 3px solid #3498db;
            vertical-align: middle;
        }
        .alignment-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        .alignment-good { background-color: #27ae60; }
        .alignment-bad { background-color: #e74c3c; }
        .alignment-neutral { background-color: #f39c12; }
        .alignment-unknown { background-color: #95a5a6; }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
            border-top: 1px solid #bdc3c7;
            padding-top: 20px;
        }
        .icon {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 REPORTE 5 - SUPERHÉROE</h1>
        <p>Información Detallada del Personaje</p>
        <small>Generado el <?= date('d/m/Y H:i:s') ?></small>
    </div>

    <div class="hero-card">
        <div class="hero-name">
            🦸‍♂️ <?= $superhero['superhero_name'] ?? 'Sin nombre' ?>
        </div>
        
        <div class="hero-real-name">
            "<?= $superhero['full_name'] ?? 'Nombre real no disponible' ?>"
        </div>

        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">🏢</span>Editorial
                </div>
                <div class="info-value">
                    <?= $superhero['publisher_name'] ?? 'No disponible' ?>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">⚖️</span>Alineación
                </div>
                <div class="info-value">
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
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">📏</span>Altura
                </div>
                <div class="info-value">
                    <?php 
                    if (!empty($superhero['height_cm'])) {
                        echo $superhero['height_cm'] . ' cm';
                        $meters = $superhero['height_cm'] / 100;
                        echo ' (' . number_format($meters, 2) . ' m)';
                    } else {
                        echo 'No disponible';
                    }
                    ?>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">⚖️</span>Peso
                </div>
                <div class="info-value">
                    <?php 
                    if (!empty($superhero['weight_kg'])) {
                        echo $superhero['weight_kg'] . ' kg';
                    } else {
                        echo 'No disponible';
                    }
                    ?>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">🆔</span>ID del Sistema
                </div>
                <div class="info-value">
                    #<?= $superhero['id'] ?>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>Sistema de Gestión de Superhéroes</strong></p>
        <p>Este documento fue generado automáticamente desde la base de datos</p>
        <p>Fecha de generación: <?= date('d \d\e F \d\e Y \a \l\a\s H:i:s') ?></p>
    </div>
</body>
</html>