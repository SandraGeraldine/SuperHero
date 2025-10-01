<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Personalizado de Superhéroes</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 2.2em;
            font-weight: 300;
        }
        
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1em;
        }
        
        .form-container {
            padding: 40px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 1.1em;
        }
        
        .form-group input[type="text"],
        .form-group input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }
        
        .form-group input[type="text"]:focus,
        .form-group input[type="number"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .checkbox-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 10px;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }
        
        .checkbox-item:hover {
            border-color: #667eea;
            background: #f0f2ff;
        }
        
        .checkbox-item input[type="checkbox"] {
            margin: 0;
            transform: scale(1.2);
        }
        
        .checkbox-item input[type="checkbox"]:checked + label {
            color: #667eea;
            font-weight: 600;
        }
        
        .checkbox-item.checked {
            border-color: #667eea;
            background: #f0f2ff;
        }
        
        .range-info {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }
        
        .submit-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .error-message {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 10px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 1.8em;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .checkbox-group {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🦸‍♂️ Reporte Personalizado</h1>
            <p>Genera tu reporte de superhéroes con parámetros personalizados</p>
        </div>
        
        <div class="form-container">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="error-message">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            
            <form action="<?= base_url('reportes/reporte6-pdf') ?>" method="post" id="reporteForm">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="titulo">📋 Título del Reporte</label>
                    <input type="text" id="titulo" name="titulo" required 
                           placeholder="Ej: Reporte de Superhéroes por Género"
                           value="<?= old('titulo') ?>">
                </div>
                
                <div class="form-group">
                    <label>👥 Género de Superhéroes</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="masculino" name="genero[]" value="masculino" 
                                   <?= (old('genero') && in_array('masculino', old('genero'))) ? 'checked' : '' ?>>
                            <label for="masculino">♂️ Masculino</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="femenino" name="genero[]" value="femenino"
                                   <?= (old('genero') && in_array('femenino', old('genero'))) ? 'checked' : '' ?>>
                            <label for="femenino">♀️ Femenino</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="na" name="genero[]" value="na"
                                   <?= (old('genero') && in_array('na', old('genero'))) ? 'checked' : '' ?>>
                            <label for="na">❓ N/A</label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="limite">🔢 Límite de Superhéroes</label>
                    <input type="number" id="limite" name="limite" min="10" max="20" required
                           placeholder="Entre 10 y 20" value="<?= old('limite', '15') ?>">
                    <div class="range-info">Mínimo: 10 superhéroes | Máximo: 20 superhéroes</div>
                </div>
                
                <button type="submit" class="submit-btn">
                    📄 Generar PDF
                </button>
            </form>
        </div>
    </div>
    
    <script>
        // Mejorar la experiencia de usuario con los checkboxes
        document.querySelectorAll('.checkbox-item').forEach(item => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            
            item.addEventListener('click', function(e) {
                if (e.target.type !== 'checkbox') {
                    checkbox.checked = !checkbox.checked;
                }
                updateCheckboxStyle();
            });
            
            checkbox.addEventListener('change', updateCheckboxStyle);
        });
        
        function updateCheckboxStyle() {
            document.querySelectorAll('.checkbox-item').forEach(item => {
                const checkbox = item.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    item.classList.add('checked');
                } else {
                    item.classList.remove('checked');
                }
            });
        }
        
        // Inicializar estilos
        updateCheckboxStyle();
        
        // Validación del formulario
        document.getElementById('reporteForm').addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="genero[]"]:checked');
            const limite = document.getElementById('limite').value;
            
            if (checkboxes.length === 0) {
                e.preventDefault();
                alert('Por favor selecciona al menos un género.');
                return;
            }
            
            if (limite < 10 || limite > 20) {
                e.preventDefault();
                alert('El límite debe estar entre 10 y 20 superhéroes.');
                return;
            }
        });
    </script>
</body>
</html>
