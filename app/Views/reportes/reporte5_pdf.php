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

        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">🏢</span>Editorial/Compañía
                </div>
                <div class="info-value">
                    <?= $superhero['publisher_name'] ?? 'No especificada' ?>
                </div>
            </div>
            
            <div class="info-row">
                <div class="info-label">
                    <span class="icon">⚖️</span>Alineación Moral
                </div>
                <div class="info-value">
                    <?php
                    // Lógica para determinar la alineación (me gusta como quedó)
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
                    // Mostrar altura con conversiones (útil!)
                    if (!empty($superhero['height_cm'])) {
                        echo '<strong>' . $superhero['height_cm'] . ' cm</strong>';
                        $meters = $superhero['height_cm'] / 100;
                        echo ' (' . number_format($meters, 2) . ' metros)';
                        
                        // Comparación divertida
                        if ($superhero['height_cm'] > 200) {
                            echo ' - ¡Muy alto!';
                        } elseif ($superhero['height_cm'] < 150) {
                            echo ' - Compacto';
                        } else {
                            echo ' - Altura normal ';
                        }
                    } else {
                        echo 'No especificada ';
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
                        
                        // Conversión a libras (por si acaso)
                        $pounds = $superhero['weight_kg'] * 2.205;
                        echo ' (' . round($pounds) . ' lbs)';
                        
                        // Comentario divertido basado en peso
                        if ($superhero['weight_kg'] > 100) {
                            echo ' - ¡Fuerte! ';
                        } else {
                            echo ' - Ágil ';
                        }
                    } else {
                        echo 'No especificado ';
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
        </div>
    </div>

    <div class="footer">
        <p><strong>Sistema de Gestión de Superhéroes</strong></p>
        <p>Desarrollado por <strong>Sandra De La Cruz</strong> - Proyecto Universitario</p>
        <p>ste documento fue generado automáticamente desde nuestra base de datos</p>
        <p>Fecha y hora de generación: <?= date('d \d\e F \d\e Y \a \l\a\s H:i:s') ?></p>
        <p style="margin-top: 15px; font-size: 11px; color: #9ca3af;">
             <em>¡Gracias por usar mi buscador de superhéroes!</em> 
        </p>
    </div>
    
    <!-- Comentario personal: ¡Me quedó genial este PDF! -->
</body>
</html>