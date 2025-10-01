<?= $estilos ?>

<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm">
    <page_header>
        <div style="text-align: center; border-bottom: 2px solid #667eea; padding-bottom: 10px; margin-bottom: 20px;">
            <h1 style="color: #667eea; margin: 0; font-size: 24px;"><?= esc($titulo) ?></h1>
            <p style="margin: 5px 0 0 0; color: #666; font-size: 12px;">
                Reporte generado el <?= date('d/m/Y H:i:s') ?>
            </p>
        </div>
    </page_header>
    
    <page_footer>
        <div style="text-align: center; border-top: 1px solid #ddd; padding-top: 10px; font-size: 10px; color: #666;">
            Página [[page_cu]] de [[page_nb]] - Sistema de Reportes de Superhéroes
        </div>
    </page_footer>

    <!-- Información del reporte -->
    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #667eea;">
        <h3 style="margin: 0 0 10px 0; color: #333; font-size: 16px;">📊 Información del Reporte</h3>
        <table style="width: 100%; font-size: 12px;">
            <tr>
                <td style="padding: 3px 0; width: 30%; font-weight: bold;">Géneros seleccionados:</td>
                <td style="padding: 3px 0;">
                    <?php 
                    $generos_texto = [];
                    if (is_array($genero_seleccionado)) {
                        foreach ($genero_seleccionado as $genero) {
                            switch($genero) {
                                case 'masculino':
                                    $generos_texto[] = '♂️ Masculino';
                                    break;
                                case 'femenino':
                                    $generos_texto[] = '♀️ Femenino';
                                    break;
                                case 'na':
                                    $generos_texto[] = '❓ N/A';
                                    break;
                            }
                        }
                    }
                    echo implode(', ', $generos_texto);
                    ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 3px 0; font-weight: bold;">Límite solicitado:</td>
                <td style="padding: 3px 0;"><?= esc($limite) ?> superhéroes</td>
            </tr>
            <tr>
                <td style="padding: 3px 0; font-weight: bold;">Total encontrados:</td>
                <td style="padding: 3px 0; color: #667eea; font-weight: bold;"><?= esc($total_encontrados) ?> superhéroes</td>
            </tr>
        </table>
    </div>

    <?php if (empty($superheroes)): ?>
        <div style="text-align: center; padding: 40px; background: #fff3cd; border-radius: 8px; border: 1px solid #ffeaa7;">
            <h3 style="color: #856404; margin: 0 0 10px 0;">⚠️ Sin Resultados</h3>
            <p style="color: #856404; margin: 0;">No se encontraron superhéroes que coincidan con los criterios seleccionados.</p>
        </div>
    <?php else: ?>
        <!-- Tabla de superhéroes -->
        <h3 style="color: #333; margin: 20px 0 15px 0; font-size: 18px;">🦸‍♂️ Lista de Superhéroes</h3>
        
        <table style="width: 100%; border-collapse: collapse; font-size: 11px;">
            <thead>
                <tr style="background: #667eea; color: white;">
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; width: 5%;">#</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; width: 25%;">Nombre del Superhéroe</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; width: 25%;">Nombre Real</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; width: 15%;">Editorial</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; width: 12%;">Alineación</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left; width: 10%;">Género</th>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: center; width: 8%;">Altura</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($superheroes as $index => $hero): ?>
                    <tr style="<?= ($index % 2 == 0) ? 'background: #f8f9fa;' : 'background: white;' ?>">
                        <td style="border: 1px solid #ddd; padding: 6px; text-align: center; font-weight: bold; color: #667eea;">
                            <?= $index + 1 ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 6px; font-weight: bold;">
                            <?= esc($hero['superhero_name'] ?? 'N/A') ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 6px;">
                            <?= esc($hero['full_name'] ?? 'N/A') ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 6px;">
                            <?= esc($hero['publisher_name'] ?? 'Sin editorial') ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 6px;">
                            <?php 
                            $alignment = $hero['alignment'] ?? 'N/A';
                            $alignment_color = '#666';
                            switch(strtolower($alignment)) {
                                case 'good':
                                    $alignment_color = '#28a745';
                                    $alignment = '✅ Bueno';
                                    break;
                                case 'bad':
                                    $alignment_color = '#dc3545';
                                    $alignment = '❌ Malo';
                                    break;
                                case 'neutral':
                                    $alignment_color = '#ffc107';
                                    $alignment = '⚖️ Neutral';
                                    break;
                                default:
                                    $alignment = '❓ N/A';
                            }
                            ?>
                            <span style="color: <?= $alignment_color ?>; font-weight: bold;">
                                <?= $alignment ?>
                            </span>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 6px;">
                            <?php 
                            $gender = $hero['gender_name'] ?? 'N/A';
                            switch(strtolower($gender)) {
                                case 'male':
                                    echo '♂️ M';
                                    break;
                                case 'female':
                                    echo '♀️ F';
                                    break;
                                default:
                                    echo '❓ N/A';
                            }
                            ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 6px; text-align: center;">
                            <?= $hero['height_cm'] ? esc($hero['height_cm']) . ' cm' : 'N/A' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Estadísticas resumidas -->
        <div style="margin-top: 30px; background: #e9ecef; padding: 15px; border-radius: 8px;">
            <h4 style="margin: 0 0 15px 0; color: #333; font-size: 14px;">📈 Estadísticas del Reporte</h4>
            
            <?php
            // Calcular estadísticas
            $stats_genero = [];
            $stats_alignment = [];
            $stats_publisher = [];
            
            foreach ($superheroes as $hero) {
                // Género
                $gender = $hero['gender_name'] ?? 'N/A';
                $stats_genero[$gender] = ($stats_genero[$gender] ?? 0) + 1;
                
                // Alineación
                $alignment = $hero['alignment'] ?? 'N/A';
                $stats_alignment[$alignment] = ($stats_alignment[$alignment] ?? 0) + 1;
                
                // Editorial
                $publisher = $hero['publisher_name'] ?? 'Sin editorial';
                $stats_publisher[$publisher] = ($stats_publisher[$publisher] ?? 0) + 1;
            }
            ?>
            
            <table style="width: 100%; font-size: 10px;">
                <tr>
                    <td style="width: 33%; vertical-align: top; padding-right: 10px;">
                        <strong>Por Género:</strong><br>
                        <?php foreach ($stats_genero as $genero => $count): ?>
                            <?php 
                            $icon = '❓';
                            switch(strtolower($genero)) {
                                case 'male': $icon = '♂️'; break;
                                case 'female': $icon = '♀️'; break;
                            }
                            ?>
                            <?= $icon ?> <?= esc($genero) ?>: <?= $count ?><br>
                        <?php endforeach; ?>
                    </td>
                    <td style="width: 33%; vertical-align: top; padding-right: 10px;">
                        <strong>Por Alineación:</strong><br>
                        <?php foreach ($stats_alignment as $align => $count): ?>
                            <?php 
                            $icon = '❓';
                            switch(strtolower($align)) {
                                case 'good': $icon = '✅'; break;
                                case 'bad': $icon = '❌'; break;
                                case 'neutral': $icon = '⚖️'; break;
                            }
                            ?>
                            <?= $icon ?> <?= esc($align) ?>: <?= $count ?><br>
                        <?php endforeach; ?>
                    </td>
                    <td style="width: 34%; vertical-align: top;">
                        <strong>Principales Editoriales:</strong><br>
                        <?php 
                        arsort($stats_publisher);
                        $top_publishers = array_slice($stats_publisher, 0, 5, true);
                        foreach ($top_publishers as $pub => $count): 
                        ?>
                            📚 <?= esc($pub) ?>: <?= $count ?><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
    
    <!-- Nota final -->
    <div style="margin-top: 20px; padding: 10px; background: #d1ecf1; border-radius: 5px; border-left: 4px solid #bee5eb;">
        <p style="margin: 0; font-size: 10px; color: #0c5460;">
            <strong>Nota:</strong> Este reporte fue generado automáticamente basado en los criterios seleccionados. 
            Los datos mostrados corresponden a la información disponible en la base de datos al momento de la generación.
        </p>
    </div>
</page>
