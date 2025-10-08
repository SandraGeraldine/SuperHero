<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte 8 - Promedio de Peso por Editorial</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Reset y estilos base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            line-height: 1.6;
            color: #333;
        }
        
        /* Contenedor principal */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.2rem;
            margin-bottom: 8px;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        /* Sección de controles */
        .content {
            padding: 30px;
        }
        
        .controls {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #e9ecef;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 15px;
            font-weight: 600;
            color: #495057;
            font-size: 1rem;
        }
        
        /* Grid de checkboxes */
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            background: white;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .checkbox-item:hover {
            border-color: #007bff;
            background-color: #f8f9ff;
        }
        
        .checkbox-item input[type="checkbox"] {
            margin: 0;
        }
        
        .checkbox-item label {
            margin: 0;
            cursor: pointer;
            font-size: 0.9rem;
            color: #495057;
        }
        
        .checkbox-item input[type="checkbox"]:checked + label {
            color: #007bff;
            font-weight: 500;
        }
        
        /* Botón principal */
        .btn-primary {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
        }
        
        .btn-primary:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }
        
        /* Contenedor del gráfico */
        .chart-section {
            margin-top: 30px;
            display: none;
        }
        
        .chart-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .chart-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 8px;
        }
        
        .chart-description {
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        .chart-canvas {
            background: white;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #e9ecef;
        }
        
        /* Mensajes de estado */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-top: 15px;
            display: none;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .loading {
            text-align: center;
            padding: 20px;
            display: none;
            color: #007bff;
        }
        
        .spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #007bff;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 25px;
            display: none;
        }
        
        .stat-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e9ecef;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 600;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Reporte 8 - Promedio de Peso por Editorial</h1>
            <p>Análisis del peso promedio de superhéroes ordenado de menor a mayor</p>
        </div>

        <!-- Contenido principal -->
        <div class="content">
            <!-- Controles de filtrado -->
            <div class="controls">
                <div class="form-group">
                    <label class="form-label">Seleccionar editoriales:</label>
                    <div class="checkbox-grid">
                        <div class="checkbox-item">
                            <input type="checkbox" id="na" value="na">
                            <label for="na">N/A</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="marvel" value="Marvel Comics">
                            <label for="marvel">Marvel Comics</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="dc" value="DC Comics">
                            <label for="dc">DC Comics</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="abc" value="ABC Studios">
                            <label for="abc">ABC Studios</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="dark_horse" value="Dark Horse Comics">
                            <label for="dark_horse">Dark Horse Comics</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="wildstorm" value="Wildstorm">
                            <label for="wildstorm">Wildstorm</label>
                        </div>
                    </div>
                </div>
                
                <button type="button" class="btn-primary" onclick="generateChart()">
                    Generar Gráfico
                </button>
                
                <!-- Mensajes de estado -->
                <div class="alert alert-danger" id="errorMessage"></div>
                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    Cargando datos...
                </div>
            </div>

            <!-- Sección del gráfico -->
            <div class="chart-section" id="chartSection">
                <div class="chart-header">
                    <h3 class="chart-title">Promedio de Peso por Editorial</h3>
                    <p class="chart-description">Ordenado de menor a mayor peso promedio</p>
                </div>
                
                <div class="chart-canvas">
                    <canvas id="chartCanvas"></canvas>
                </div>
                
                <!-- Estadísticas -->
                <div class="stats-grid" id="statsGrid">
                    <div class="stat-card">
                        <div class="stat-value" id="totalPublishers">0</div>
                        <div class="stat-label">Editoriales</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="totalHeroes">0</div>
                        <div class="stat-label">Superhéroes</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="avgWeight">0 kg</div>
                        <div class="stat-label">Peso Promedio</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value" id="weightRange">0 kg</div>
                        <div class="stat-label">Rango de Peso</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Variables globales
        let currentChart = null;
        let chartData = null;
        
        /**
         * Función principal para generar el gráfico de peso
         */
        function generateChart() {
            const selectedPublishers = getSelectedPublishers();
            
            if (selectedPublishers.length === 0) {
                showError('Debe seleccionar al menos una editorial');
                return;
            }
            
            hideError();
            showLoading();
            
            fetchWeightData(selectedPublishers)
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        chartData = data.data;
                        displayChart();
                        updateStatistics();
                    } else {
                        showError(data.message);
                    }
                })
                .catch(error => {
                    hideLoading();
                    showError('Error al cargar los datos');
                    console.error('Error:', error);
                });
        }
        
        /**
         * Obtiene las editoriales seleccionadas
         */
        function getSelectedPublishers() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            return Array.from(checkboxes).map(cb => cb.value);
        }
        
        /**
         * Realiza la petición AJAX para obtener los datos
         */
        function fetchWeightData(publishers) {
            const formData = new FormData();
            publishers.forEach(publisher => {
                formData.append('publishers[]', publisher);
            });
            
            return fetch('<?= base_url('reportes/generate-weight-chart8') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => response.json());
        }
        
        /**
         * Crea y configura el gráfico de línea
         */
        function displayChart() {
            const ctx = document.getElementById('chartCanvas').getContext('2d');
            
            // Destruir gráfico anterior si existe
            if (currentChart) {
                currentChart.destroy();
            }
            
            const labels = chartData.map(item => item.publisher_name);
            const weights = chartData.map(item => parseFloat(item.promedio_peso));
            
            const config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Peso Promedio (kg)',
                        data: weights,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#007bff',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                afterLabel: function(context) {
                                    const item = chartData[context.dataIndex];
                                    return [
                                        `Superhéroes: ${item.total_heroes_con_peso}`,
                                        `Rango: ${item.peso_minimo} - ${item.peso_maximo} kg`
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Editorial'
                            },
                            ticks: {
                                maxRotation: 45
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Peso Promedio (kg)'
                            },
                            beginAtZero: true
                        }
                    }
                }
            };
            
            currentChart = new Chart(ctx, config);
            showChartSection();
        }
        
        /**
         * Actualiza las estadísticas mostradas
         */
        function updateStatistics() {
            const totalPublishers = chartData.length;
            const totalHeroes = chartData.reduce((sum, item) => sum + parseInt(item.total_heroes_con_peso), 0);
            const weights = chartData.map(item => parseFloat(item.promedio_peso));
            const avgWeight = (weights.reduce((sum, weight) => sum + weight, 0) / weights.length).toFixed(1);
            const minWeight = Math.min(...weights);
            const maxWeight = Math.max(...weights);
            const weightRange = (maxWeight - minWeight).toFixed(1);
            
            document.getElementById('totalPublishers').textContent = totalPublishers;
            document.getElementById('totalHeroes').textContent = totalHeroes;
            document.getElementById('avgWeight').textContent = avgWeight + ' kg';
            document.getElementById('weightRange').textContent = weightRange + ' kg';
            
            document.getElementById('statsGrid').style.display = 'grid';
        }
        
        /**
         * Muestra la sección del gráfico
         */
        function showChartSection() {
            document.getElementById('chartSection').style.display = 'block';
        }
        
        /**
         * Muestra un mensaje de error
         */
        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }
        
        /**
         * Oculta el mensaje de error
         */
        function hideError() {
            document.getElementById('errorMessage').style.display = 'none';
        }
        
        /**
         * Muestra el indicador de carga
         */
        function showLoading() {
            document.getElementById('loading').style.display = 'block';
        }
        
        /**
         * Oculta el indicador de carga
         */
        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
        }
        
        /**
         * Inicialización cuando se carga la página
         */
        document.addEventListener('DOMContentLoaded', function() {
            // Hacer clickeable toda el área del checkbox
            document.querySelectorAll('.checkbox-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    if (e.target.type !== 'checkbox') {
                        const checkbox = this.querySelector('input[type="checkbox"]');
                        checkbox.checked = !checkbox.checked;
                    }
                });
            });
        });
    </script>
</body>
</html>
