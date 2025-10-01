<?= $estilos ?>

<page backtop="15mm" backbottom="15mm" backleft="15mm" backright="15mm">
    <page_header>
        <div style="text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px;">
            <h1 style="color: #333; margin: 0; font-size: 20px;"><?= esc($titulo) ?></h1>
            <p style="margin: 5px 0 0 0; color: #666; font-size: 11px;">
                Generado el <?= date('d/m/Y H:i:s') ?>
            </p>
        </div>
    </page_header>
    
    <page_footer>
        <div style="text-align: center; border-top: 1px solid #ddd; padding-top: 8px; font-size: 9px; color: #666;">
            Página [[page_cu]] de [[page_nb]]
        </div>
    </page_footer>

    <div style="background: #f5f5f5; padding: 12px; margin-bottom: 15px; border-left: 3px solid #007bff;">
        <h3 style="margin: 0 0 8px 0; color: #333; font-size: 14px;">Información del Reporte</h3>
        <table style="width: 100%; font-size: 11px;">
            <tr>
                <td style="padding: 2px 0; width: 25%; font-weight: bold;">Géneros:</td>
                <td style="padding: 2px 0;">
                    <?php 
                    $generos_texto = [];
                    if (is_array($genero_seleccionado)) {
                        foreach ($genero_seleccionado as $genero) {
                            switch($genero) {
                                case 'masculino':
                                    $generos_texto[] = 'Masculino';
                                    break;
                                case 'femenino':
                                    $generos_texto[] = 'Femenino';
                                    break;
                                case 'na':
                                    $generos_texto[] = 'N/A';
                                    break;
                            }
                        }
                    }
                    echo implode(', ', $generos_texto);
                    ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 2px 0; font-weight: bold;">Límite:</td>
                <td style="padding: 2px 0;"><?= esc($limite) ?> superhéroes</td>
            </tr>
            <tr>
                <td style="padding: 2px 0; font-weight: bold;">Encontrados:</td>
                <td style="padding: 2px 0; font-weight: bold;"><?= esc($total_encontrados) ?> superhéroes</td>
            </tr>
        </table>
    </div>

    <?php if (empty($superheroes)): ?>
        <div style="text-align: center; padding: 30px; background: #fff3cd; border: 1px solid #ffeaa7;">
            <h3 style="color: #856404; margin: 0 0 8px 0;">Sin Resultados</h3>
            <p style="color: #856404; margin: 0;">No se encontraron superhéroes con los criterios seleccionados.</p>
        </div>
    <?php else: ?>
        <h3 style="color: #333; margin: 15px 0 10px 0; font-size: 16px;">Lista de Superhéroes</h3>
        
        <table style="width: 100%; border-collapse: collapse; font-size: 10px;">
            <thead>
                <tr style="background: #007bff; color: white;">
                    <th style="border: 1px solid #ddd; padding: 6px; text-align: left; width: 5%;">#</th>
                    <th style="border: 1px solid #ddd; padding: 6px; text-align: left; width: 30%;">Superhéroe</th>
                    <th style="border: 1px solid #ddd; padding: 6px; text-align: left; width: 25%;">Nombre Real</th>
                    <th style="border: 1px solid #ddd; padding: 6px; text-align: left; width: 20%;">Editorial</th>
                    <th style="border: 1px solid #ddd; padding: 6px; text-align: left; width: 12%;">Alineación</th>
                    <th style="border: 1px solid #ddd; padding: 6px; text-align: center; width: 8%;">Género</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($superheroes as $index => $hero): ?>
                    <tr style="<?= ($index % 2 == 0) ? 'background: #f9f9f9;' : 'background: white;' ?>">
                        <td style="border: 1px solid #ddd; padding: 4px; text-align: center;">
                            <?= $index + 1 ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 4px; font-weight: bold;">
                            <?= esc($hero['superhero_name'] ?? 'N/A') ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 4px;">
                            <?= esc($hero['full_name'] ?? 'N/A') ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 4px;">
                            <?= esc($hero['publisher_name'] ?? 'Sin editorial') ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 4px;">
                            <?php 
                            $alignment = $hero['alignment'] ?? 'N/A';
                            switch(strtolower($alignment)) {
                                case 'good':
                                    echo 'Bueno';
                                    break;
                                case 'bad':
                                    echo 'Malo';
                                    break;
                                case 'neutral':
                                    echo 'Neutral';
                                    break;
                                default:
                                    echo 'N/A';
                            }
                            ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 4px; text-align: center;">
                            <?php 
                            $gender = $hero['gender_name'] ?? 'N/A';
                            switch(strtolower($gender)) {
                                case 'male':
                                    echo 'M';
                                    break;
                                case 'female':
                                    echo 'F';
                                    break;
                                default:
                                    echo 'N/A';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div style="margin-top: 20px; background: #f0f0f0; padding: 10px;">
            <h4 style="margin: 0 0 10px 0; color: #333; font-size: 12px;">Resumen</h4>
            <?php
            $stats_genero = [];
            $stats_alignment = [];
            
            foreach ($superheroes as $hero) {
                $gender = $hero['gender_name'] ?? 'N/A';
                $stats_genero[$gender] = ($stats_genero[$gender] ?? 0) + 1;
                
                $alignment = $hero['alignment'] ?? 'N/A';
                $stats_alignment[$alignment] = ($stats_alignment[$alignment] ?? 0) + 1;
            }
            ?>
            
            <table style="width: 100%; font-size: 9px;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <strong>Por Género:</strong><br>
                        <?php foreach ($stats_genero as $genero => $count): ?>
                            <?= esc($genero) ?>: <?= $count ?><br>
                        <?php endforeach; ?>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <strong>Por Alineación:</strong><br>
                        <?php foreach ($stats_alignment as $align => $count): ?>
                            <?= esc($align) ?>: <?= $count ?><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>
        </div>
    <?php endif; ?>
</page>
