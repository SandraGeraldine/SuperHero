<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Reporte de Superhéroe - Sandra De La Cruz</title>
    <?= $estilos ?>
    <style>
        /* Estilos para mi PDF personalizado */
        body {
            font-family: 'Arial', sans-serif; /* Me gusta esta fuente */
            margin: 20px;
            background-color: #f8f9fa;
            line-height: 1.6; /* Para que se lea mejor */
        }
        .header {
            /* Header con los colores que me gustan */
            background: linear-gradient(135deg, #745c77ff 0%, #b88087ff 100%);
            color: white;
            padding: 35px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15); /* Sombra bonita */
        }
        
        .hero-card {
            background: white;
            border-radius: 20px; /* Más redondeado se ve mejor */
            padding: 35px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            border: 1px solid #e9ecef; /* Borde sutil */
        }
        .hero-name {
            color: #2c3e50;
            font-size: 32px; /* Un poco más grande */
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1); /* Sombra sutil */
        }
        
        .hero-real-name {
            color: #6c757d; /* Color más suave */
            font-size: 20px;
            text-align: center;
            margin-bottom: 35px;
            font-style: italic;
            font-weight: 300;
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
            background: linear-gradient(135deg, #9cc9c6ff 0%, #44a08d 100%); /* Mis colores favoritos */
            color: white;
            padding: 18px;
            font-weight: bold;
            width: 35%; /* Un poco más ancho */
            vertical-align: middle;
            text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
        }
        
        .info-value {
            display: table-cell;
            background-color: #f8f9fa; /* Color más suave */
            padding: 18px;
            border-left: 4px solid #9cc9c6ff; /* Borde más grueso y colorido */
            vertical-align: middle;
        }
        .alignment-badge {
            display: inline-block;
            padding: 10px 18px; /* Un poco más grande */
            border-radius: 25px; /* Más redondeado */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.2); /* Sombra bonita */
        }
        
        /* Colores que me gustan para las alineaciones */
        .alignment-good { 
            background: linear-gradient(45deg, #27ae60, #2ecc71); 
        }
        .alignment-bad { 
            background: linear-gradient(45deg, #e74c3c, #c0392b); 
        }
        .alignment-neutral { 
            background: linear-gradient(45deg, #f39c12, #e67e22); 
        }
        .alignment-unknown { 
            background: linear-gradient(45deg, #95a5a6, #7f8c8d); 
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            color: #6c757d; /* Color más suave */
            font-size: 13px;
            border-top: 2px solid #dee2e6; /* Línea más gruesa */
            padding-top: 25px;
            background: linear-gradient(to right, transparent, #f8f9fa, transparent);
            padding: 25px;
            border-radius: 10px;
        }
        
        .icon {
            margin-right: 10px; /* Un poco más de espacio */
            font-size: 16px; /* Iconos más grandes */
        }
        
        /* Efecto hover para cuando se vea en pantalla */
        .info-row:hover .info-label {
            background: linear-gradient(135deg, #44a08d 0%, #9cc9c6ff 100%);
        }
    </style>
</head>
<body>
    <!-- Mi plantilla personalizada para PDF -->
    <div class="header">
        <h1>MI REPORTE DE SUPERHÉROE 🦸‍♀️</h1>
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

        <h2 style="color: #2c3e50; text-align: center; margin: 30px 0; font-size: 22px;">
            📋 INFORMACIÓN COMPLETA DEL SUPERHÉROE
        </h2>

        <div class="info-grid">
            <!-- INFORMACIÓN BÁSICA -->
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">🏢</span>Editorial/Compañía
                </div>
                <div class="info-value">
                    <strong><?= $superhero['publisher_name'] ?? 'No especificada' ?></strong>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">⚖️</span>Alineación Moral
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
                    <span class="icon">📏</span>Altura Física
                </div>
                <div class="info-value">
                    <?php 
                    if (!empty($superhero['height_cm'])) {
                        echo '<strong>' . $superhero['height_cm'] . ' cm</strong>';
                        $meters = $superhero['height_cm'] / 100;
                        echo ' (' . number_format($meters, 2) . ' metros)';
                        
                        if ($superhero['height_cm'] > 200) {
                            echo ' - ¡Muy alto!';
                        } elseif ($superhero['height_cm'] < 150) {
                            echo ' - Compacto';
                        } else {
                            echo ' - Altura normal';
                        }
                    } else {
                        echo 'No especificada';
                    }
                    ?>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">⚖️</span>Peso Corporal
                </div>
                <div class="info-value">
                    <?php 
                    if (!empty($superhero['weight_kg'])) {
                        echo '<strong>' . $superhero['weight_kg'] . ' kg</strong>';
                        $pounds = $superhero['weight_kg'] * 2.205;
                        echo ' (' . round($pounds) . ' lbs)';
                        
                        if ($superhero['weight_kg'] > 100) {
                            echo ' - ¡Fuerte!';
                        } else {
                            echo ' - Ágil';
                        }
                    } else {
                        echo 'No especificado';
                    }
                    ?>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">🔢</span>ID en Base de Datos
                </div>
                <div class="info-value">
                    <strong>#<?= $superhero['id'] ?></strong>
                    <small style="color: #6c757d;"> (identificador único)</small>
                </div>
            </div>

            <!-- SEPARADOR -->
            <div style="height: 20px; background: linear-gradient(90deg, transparent, #dee2e6, transparent); margin: 10px 0;"></div>

            <!-- ATRIBUTOS DE PODER -->
            <?php if (!empty($attributes)): ?>
                <?php foreach ($attributes as $attr): ?>
                <div class="info-row">
                    <div class="info-label">
                        <span class="icon">
                            <?php
                            switch($attr['attribute_name']) {
                                case 'Intelligence': echo '🧠'; break;
                                case 'Strength': echo '💪'; break;
                                case 'Speed': echo '⚡'; break;
                                case 'Durability': echo '🛡️'; break;
                                case 'Power': echo '🔥'; break;
                                case 'Combat': echo '⚔️'; break;
                                default: echo '📊'; break;
                            }
                            ?>
                        </span>
                        <?= $attr['attribute_name'] ?>
                    </div>
                    <div class="info-value">
                        <div style="display: flex; align-items: center;">
                            <strong style="font-size: 16px; margin-right: 15px; min-width: 60px;">
                                <?= $attr['attribute_value'] ?>/100
                            </strong>
                            
                            <!-- Barra de progreso -->
                            <div style="background: #e9ecef; border-radius: 8px; width: 120px; height: 16px; overflow: hidden; margin-right: 10px;">
                                <?php 
                                $value = $attr['attribute_value'];
                                $barColor = '#e74c3c, #c0392b';
                                if ($value >= 80) $barColor = '#27ae60, #2ecc71';
                                elseif ($value >= 60) $barColor = '#f39c12, #e67e22';
                                elseif ($value >= 40) $barColor = '#3498db, #2980b9';
                                ?>
                                <div style="background: linear-gradient(90deg, <?= $barColor ?>); height: 100%; width: <?= $attr['attribute_value'] ?>%; border-radius: 8px;"></div>
                            </div>
                            
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
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- SEPARADOR -->
            <div style="height: 20px; background: linear-gradient(90deg, transparent, #dee2e6, transparent); margin: 10px 0;"></div>

            <!-- SUPERPODERES -->
            <?php if (!empty($powers)): ?>
                <?php 
                $powerCount = 0;
                foreach ($powers as $power): 
                    $powerCount++;
                ?>
                <div class="info-row">
                    <div class="info-label">
                        <span class="icon">⚡</span>Poder #<?= $powerCount ?>
                    </div>
                    <div class="info-value">
                        <strong><?= $power['power_name'] ?></strong>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <!-- Total de poderes -->
                <div class="info-row">
                    <div class="info-label">
                        <span class="icon">🎯</span>Total de Poderes
                    </div>
                    <div class="info-value">
                        <strong style="color: #27ae60; font-size: 16px;">
                            <?= count($powers) ?> superpoderes únicos
                        </strong>
                    </div>
                </div>
            <?php endif; ?>
        </div>
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