<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Editoriales</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
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
        
        .controls {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }
        
        .checkbox-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
        }
        
        .checkbox-item input[type="checkbox"] {
            margin: 0;
        }
        
        .btn-generate {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
        }
        
        .btn-generate:hover {
            background-color: #0056b3;
        }
        
        .btn-generate:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }
        
        .chart-container {
            background: white;
            padding: 20px;
            border-radius: 6px;
            margin-top: 20px;
            display: none;
        }
        
        .chart-controls {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .chart-type-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 8px 16px;
            margin: 0 5px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .chart-type-btn.active {
            background: #007bff;
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            display: none;
        }
        
        .loading {
            text-align: center;
            padding: 20px;
            display: none;
        }
        
        #chartCanvas {
            max-height: 400px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gráfico de Superhéroes por Editorial</h1>
        
        <div class="controls">
            <div class="form-group">
                <label>Selecciona las editoriales:</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" id="na" value="na">
                        <label for="na">N/A</label>
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
            
            <button type="button" class="btn-generate" onclick="generateChart()">
                Generar Gráfico
            </button>
            
            <div class="error-message" id="errorMessage"></div>
            <div class="loading" id="loading">Cargando datos...</div>
        </div>
        
        <div class="chart-container" id="chartContainer">
            <div class="chart-controls">
                <button class="chart-type-btn active" onclick="changeChartType('bar')">Barras</button>
                <button class="chart-type-btn" onclick="changeChartType('line')">Líneas</button>
                <button class="chart-type-btn" onclick="changeChartType('pie')">Circular</button>
            </div>
            <canvas id="chartCanvas"></canvas>
        </div>
    </div>
    
    <script>
        let currentChart = null;
        let chartData = null;
        let currentChartType = 'bar';
        
        function generateChart() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            const publishers = Array.from(checkboxes).map(cb => cb.value);
            
            if (publishers.length === 0) {
                showError('Debe seleccionar al menos una editorial');
                return;
            }
            
            hideError();
            showLoading();
            
            const formData = new FormData();
            publishers.forEach(publisher => {
                formData.append('publishers[]', publisher);
            });
            
            fetch('<?= base_url('reportes/generate-chart7') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                
                if (data.success) {
                    chartData = data.data;
                    showChart();
                    createChart(currentChartType);
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
        
        function createChart(type) {
            const ctx = document.getElementById('chartCanvas').getContext('2d');
            
            if (currentChart) {
                currentChart.destroy();
            }
            
            const labels = chartData.map(item => item.publisher_name);
            const totals = chartData.map(item => parseInt(item.total_heroes));
            const buenos = chartData.map(item => parseInt(item.heroes_buenos));
            const malos = chartData.map(item => parseInt(item.heroes_malos));
            const neutrales = chartData.map(item => parseInt(item.heroes_neutrales));
            
            let config = {
                type: type,
                data: {
                    labels: labels,
                    datasets: []
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Superhéroes por Editorial y Alineación'
                        },
                        legend: {
                            display: type !== 'pie'
                        }
                    }
                }
            };
            
            if (type === 'pie') {
                config.data.datasets = [{
                    label: 'Total Superhéroes',
                    data: totals,
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0'
                    ]
                }];
            } else {
                config.data.datasets = [
                    {
                        label: 'Total',
                        data: totals,
                        backgroundColor: '#007bff',
                        borderColor: '#007bff',
                        borderWidth: 1
                    },
                    {
                        label: 'Buenos',
                        data: buenos,
                        backgroundColor: '#28a745',
                        borderColor: '#28a745',
                        borderWidth: 1
                    },
                    {
                        label: 'Malos',
                        data: malos,
                        backgroundColor: '#dc3545',
                        borderColor: '#dc3545',
                        borderWidth: 1
                    },
                    {
                        label: 'Neutrales',
                        data: neutrales,
                        backgroundColor: '#ffc107',
                        borderColor: '#ffc107',
                        borderWidth: 1
                    }
                ];
                
                if (type === 'line') {
                    config.data.datasets.forEach(dataset => {
                        dataset.fill = false;
                        dataset.tension = 0.1;
                    });
                }
                
                config.options.scales = {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                };
            }
            
            currentChart = new Chart(ctx, config);
        }
        
        function changeChartType(type) {
            currentChartType = type;
            
            document.querySelectorAll('.chart-type-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            if (chartData) {
                createChart(type);
            }
        }
        
        function showChart() {
            document.getElementById('chartContainer').style.display = 'block';
        }
        
        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }
        
        function hideError() {
            document.getElementById('errorMessage').style.display = 'none';
        }
        
        function showLoading() {
            document.getElementById('loading').style.display = 'block';
        }
        
        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
        }
    </script>
</body>
</html>
