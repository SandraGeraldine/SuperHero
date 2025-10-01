<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Personalizado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }
        
        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #007bff;
            outline: none;
        }
        
        .checkbox-group {
            display: flex;
            gap: 15px;
            margin-top: 8px;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .checkbox-item input[type="checkbox"] {
            margin: 0;
        }
        
        .help-text {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        
        .btn-submit:hover {
            background-color: #0056b3;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reporte de Superhéroes</h1>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <form action="<?= base_url('reportes/reporte6-pdf') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="titulo">Título del reporte:</label>
                <input type="text" id="titulo" name="titulo" required 
                       placeholder="Ingrese el título del reporte"
                       value="<?= old('titulo') ?>">
            </div>
            
            <div class="form-group">
                <label>Género:</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="masculino" name="genero[]" value="masculino" 
                               <?= (old('genero') && in_array('masculino', old('genero'))) ? 'checked' : '' ?>>
                        <label for="masculino">Masculino</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="femenino" name="genero[]" value="femenino"
                               <?= (old('genero') && in_array('femenino', old('genero'))) ? 'checked' : '' ?>>
                        <label for="femenino">Femenino</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" id="na" name="genero[]" value="na"
                               <?= (old('genero') && in_array('na', old('genero'))) ? 'checked' : '' ?>>
                        <label for="na">N/A</label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="limite">Límite de superhéroes:</label>
                <input type="number" id="limite" name="limite" min="10" max="20" required
                       value="<?= old('limite', '15') ?>">
                <div class="help-text">Entre 10 y 20 superhéroes</div>
            </div>
            
            <button type="submit" class="btn-submit">Generar PDF</button>
        </form>
    </div>
    
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="genero[]"]:checked');
            const limite = document.getElementById('limite').value;
            
            if (checkboxes.length === 0) {
                e.preventDefault();
                alert('Debe seleccionar al menos un género.');
                return;
            }
            
            if (limite < 10 || limite > 20) {
                e.preventDefault();
                alert('El límite debe estar entre 10 y 20.');
                return;
            }
        });
    </script>
</body>
</html>
