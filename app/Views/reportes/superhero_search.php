<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte 5 - Búsqueda de Superhéroes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        .search-section {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 20px 20px 0 0;
            color: white;
        }
        .result-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }
        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        .superhero-name {
            color: #2c3e50;
            font-weight: bold;
        }
        .publisher-badge {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border-radius: 20px;
        }
        .alignment-badge {
            border-radius: 20px;
        }
        .btn-pdf {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            border: none;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-pdf:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(255,107,107,0.4);
        }
        .btn-search {
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            border: none;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-search:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(78,205,196,0.4);
        }
        .loading {
            display: none;
        }
        .hero-stats {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
        }
        .stat-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .stat-label {
            font-weight: 600;
            color: #6c757d;
        }
        .stat-value {
            color: #2c3e50;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="main-card">
                    <!-- Header Section -->
                    <div class="search-section p-4">
                        <div class="text-center mb-4">
                            <i class="fas fa-mask fa-3x mb-3"></i>
                            <h2 class="mb-2">Reporte 5 - Búsqueda de Superhéroes</h2>
                            <p class="mb-0">Encuentra información detallada sobre tus superhéroes favoritos</p>
                        </div>
                        
                        <!-- Search Form -->
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control form-control-lg" 
                                           placeholder="Escribe el nombre del superhéroe..." 
                                           style="border-radius: 25px 0 0 25px;">
                                    <button class="btn btn-search btn-lg px-4" id="searchBtn" onclick="searchSuperhero()">
                                        <i class="fas fa-search me-2"></i>Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results Section -->
                    <div class="p-4">
                        <!-- Loading -->
                        <div id="loading" class="loading text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-2 text-muted">Buscando superhéroes...</p>
                        </div>

                        <!-- No Results -->
                        <div id="noResults" class="text-center py-5" style="display: none;">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No se encontraron resultados</h4>
                            <p class="text-muted">Intenta con otro nombre de superhéroe</p>
                        </div>

                        <!-- Results Container -->
                        <div id="results" class="row"></div>

                        <!-- Instructions -->
                        <div id="instructions" class="text-center py-5">
                            <i class="fas fa-info-circle fa-3x text-info mb-3"></i>
                            <h4 class="text-info">¿Cómo usar?</h4>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="fas fa-edit fa-2x text-primary mb-3"></i>
                                        <h6>1. Escribe el nombre</h6>
                                        <p class="text-muted small">Ingresa el nombre del superhéroe que deseas buscar</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="fas fa-search fa-2x text-success mb-3"></i>
                                        <h6>2. Haz clic en Buscar</h6>
                                        <p class="text-muted small">Presiona el botón de búsqueda para encontrar coincidencias</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="fas fa-file-pdf fa-2x text-danger mb-3"></i>
                                        <h6>3. Genera PDF</h6>
                                        <p class="text-muted small">Descarga la información en formato PDF</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PDF Form (Hidden) -->
    <form id="pdfForm" action="<?= base_url('reportes/Report5PDF') ?>" method="post" style="display: none;">
        <input type="hidden" id="pdfSuperheroId" name="superhero_id">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Allow search on Enter key press
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchSuperhero();
            }
        });

        function searchSuperhero() {
            const searchTerm = document.getElementById('searchInput').value.trim();
            
            if (!searchTerm) {
                alert('Por favor ingresa un nombre para buscar');
                return;
            }

            // Show loading
            document.getElementById('loading').style.display = 'block';
            document.getElementById('results').innerHTML = '';
            document.getElementById('noResults').style.display = 'none';
            document.getElementById('instructions').style.display = 'none';

            // Create form data
            const formData = new FormData();
            formData.append('search_term', searchTerm);

            //Envia peticion al Ajax
            fetch('<?= base_url('reportes/SuperheroReport5') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loading').style.display = 'none';
                
                if (data.success) {
                    displayResults(data.data);
                } else {
                    document.getElementById('noResults').style.display = 'block';
                }
            })
            .catch(error => {
                document.getElementById('loading').style.display = 'none';
                console.error('Error:', error);
                alert('Error al realizar la búsqueda');
            });
        }

        function displayResults(superheroes) {
            const resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = '';

            superheroes.forEach(hero => {
                const heroCard = createHeroCard(hero);
                resultsContainer.appendChild(heroCard);
            });
        }

        //Generacion de Tarjetas
        function createHeroCard(hero) {
            const col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4 mb-4';
            
            const alignmentClass = getAlignmentClass(hero.alignment);
            const heightText = hero.height_cm ? `${hero.height_cm} cm` : 'No disponible';
            const weightText = hero.weight_kg ? `${hero.weight_kg} kg` : 'No disponible';
            
            col.innerHTML = `
                <div class="card result-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="superhero-name mb-0">${hero.superhero_name || 'Sin nombre'}</h5>
                            <span class="badge alignment-badge ${alignmentClass}">${hero.alignment || 'Unknown'}</span>
                        </div>
                        
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-user me-2"></i>${hero.full_name || 'Nombre no disponible'}
                        </h6>
                        
                        <div class="hero-stats">
                            <div class="stat-item">
                                <span class="stat-label"><i class="fas fa-building me-2"></i>Editorial:</span>
                                <span class="stat-value">${hero.publisher_name || 'No disponible'}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label"><i class="fas fa-ruler-vertical me-2"></i>Altura:</span>
                                <span class="stat-value">${heightText}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label"><i class="fas fa-weight me-2"></i>Peso:</span>
                                <span class="stat-value">${weightText}</span>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">
                            <button class="btn btn-pdf btn-sm px-4" onclick="generatePDF(${hero.id})">
                                <i class="fas fa-file-pdf me-2"></i>Generar PDF
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            return col;
        }

        function getAlignmentClass(alignment) {
            switch(alignment) {
                case 'Good': return 'bg-success';
                case 'Bad': return 'bg-danger';
                case 'Neutral': return 'bg-warning';
                default: return 'bg-secondary';
            }
        }

        function generatePDF(superheroId) {
            document.getElementById('pdfSuperheroId').value = superheroId;
            document.getElementById('pdfForm').submit();
        }
    </script>
</body>
</html>