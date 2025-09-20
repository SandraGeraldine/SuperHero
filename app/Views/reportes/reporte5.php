<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Superhéroes - SENATI</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para los iconos bonitos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos - Desarrollo Web */
        body {
            background: linear-gradient(135deg, #c7cde6ff 0%, #b29cc7ff 100%);
            min-height: 100vh;
            padding: 20px;
            font-family: Arial, sans-serif; /* Fuente simple y funcional */
        }
        
        .main-card {
            background: white;
            border-radius: 20px; /* Me gusta como se ve redondeado */
            box-shadow: 0 20px 40px rgba(31, 30, 30, 0.1);
            overflow: hidden;
        }
        
        .search-section {
            background: linear-gradient(135deg, #745c77ff 0%, #b88087ff 100%);
            border-radius: 20px 20px 0 0;
            color: white;
        }
        
        /* Tarjetas de resultados - practique mucho este estilo */
        .result-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animacion suave */
            margin-bottom: 20px;
        }
        
        .result-card:hover {
            transform: translateY(-5px); /* Efecto hover que me enseñaron */
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
            box-shadow: 0 5px 15px rgba(127, 102, 102, 0.4);
        }
        .btn-search {
            background: linear-gradient(45deg, #9cc9c6ff, #44a08d);
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
        
        /* autocompletado */
        .autocomplete-container {
            position: relative;
        }
        
        .autocomplete-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #ddd;
            border-top: none;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        
        .suggestion-item {
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
        }
        
        .suggestion-item:hover {
            background-color: #f8f9fa;
        }
        
        .suggestion-name {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .suggestion-publisher {
            font-size: 12px;
            color: #6c757d;
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
                            <h2 class="mb-2">Buscador de Superhéroes</h2>
                            <p class="mb-0">Busca información sobre tus superhéroes favoritos</p>
                        </div>
                        
                        <!-- Search Form con Autocompletado -->
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <div class="autocomplete-container">
                                    <div class="input-group">
                                        <input type="text" id="searchInput" class="form-control form-control-lg" 
                                               placeholder="Ej: Superman, Batman, Spider-man..." 
                                               style="border-radius: 25px 0 0 25px; border: 2px solid #ddd;"
                                               autocomplete="off">
                                        <button class="btn btn-search btn-lg px-4" id="searchBtn" onclick="buscarSuperheroe()">
                                            <i class="fas fa-search me-2"></i>Buscar
                                        </button>
                                    </div>
                                    <!-- Contenedor de sugerencias -->
                                    <div id="autocompleteSuggestions" class="autocomplete-suggestions"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results Section -->
                    <div class="p-4">
                        <!-- Cargando... -->
                        <div id="loading" class="loading text-center py-4">
                            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-3 text-muted">🔍 Buscando superhéroes increíbles...</p>
                        </div>

                        <!-- Sin resultados -->
                        <div id="noResults" class="text-center py-5" style="display: none;">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No se encontraron resultados</h4>
                            <p class="text-muted">Intenta con otro nombre</p>
                        </div>

                        <!-- Results Container -->
                        <div id="results" class="row"></div>

                        <!-- Instrucciones -->
                        <div id="instructions" class="text-center py-5">
                            <i class="fas fa-info-circle fa-3x text-info mb-3"></i>
                            <h4 class="text-info">¿Cómo usar?</h4>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="fas fa-edit fa-2x text-primary mb-3"></i>
                                        <h6>1. Escribe</h6>
                                        <p class="text-muted small">Ingresa el nombre del superhéroe</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="fas fa-search fa-2x text-success mb-3"></i>
                                        <h6>2. Busca</h6>
                                        <p class="text-muted small">Haz clic en buscar</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="fas fa-file-pdf fa-2x text-danger mb-3"></i>
                                        <h6>3. Descarga</h6>
                                        <p class="text-muted small">Genera el PDF</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer estudiantil -->
    <div class="container-fluid mt-4">
        <div class="text-center py-3">
            <small class="text-muted">
                💻 Proyecto desarrollado por <strong>Sandra De La Cruz</strong> - SENATI<br>
                📚 Carrera: Desarrollo de Software | Módulo: Programación Web
            </small>
        </div>
    </div>

    <!-- Formulario oculto para generar PDF -->
    <form id="pdfForm" action="<?= base_url('reportes/Report5PDF') ?>" method="post" style="display: none;">
        <input type="hidden" id="pdfSuperheroId" name="superhero_id">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // JavaScript para mi proyecto - Sandra De La Cruz - SENATI
        // Me costo trabajo pero al final funciono!
        
        // Variables que necesito para el buscador (aprendi esto en clase)
        let timeoutId;
        
        const searchInput = document.getElementById('searchInput');
        const suggestionsDiv = document.getElementById('autocompleteSuggestions');
        
        // Funcion para buscar mientras escribes (esto es genial!)
        searchInput.addEventListener('input', function() {
            const texto = this.value;
            
            clearTimeout(timeoutId); // Cancelar busqueda anterior
            
            if (texto.length < 2) {
                suggestionsDiv.style.display = 'none';
                return; // Salir si es muy corto
            }
            
            // Esperar un poco antes de buscar (para no saturar el servidor)
            timeoutId = setTimeout(() => {
                obtenerSugerencias(texto);
            }, 500); // Medio segundo esta bien
        });
        
        // Funcion que busca en la base de datos
        function obtenerSugerencias(texto) {
            const formData = new FormData();
            formData.append('term', texto);
            
            // Usar fetch para enviar datos (moderno)
            fetch('<?= base_url('reportes/autocompleteSuperhero') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mostrarSugerencias(data); // Mostrar resultados
            })
            .catch(error => {
                console.log('Error en la busqueda:', error);
                suggestionsDiv.style.display = 'none';
            });
        }
        
        function mostrarSugerencias(data) {
            if (data.length === 0) {
                suggestionsDiv.style.display = 'none';
                return;
            }
            
            var html = '';
            for (let i = 0; i < data.length; i++) {
                html += '<div class="suggestion-item" onclick="seleccionar(\'' + data[i].value + '\')">';
                html += '<div class="suggestion-name">' + data[i].label + '</div>';
                html += '<div class="suggestion-publisher">' + data[i].publisher + '</div>';
                html += '</div>';
            }
            
            suggestionsDiv.innerHTML = html;
            suggestionsDiv.style.display = 'block';
        }
        
        function seleccionar(nombre) {
            searchInput.value = nombre;
            suggestionsDiv.style.display = 'none';
            buscarSuperheroe();
        }
        
        // Ocultar cuando hagas click afuera
        document.addEventListener('click', function(e) {
            if (e.target !== searchInput) {
                suggestionsDiv.style.display = 'none';
            }
        });
        
        // Enter para buscar
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                suggestionsDiv.style.display = 'none';
                buscarSuperheroe();
            }
        });

        function buscarSuperheroe() {
            const nombre = document.getElementById('searchInput').value.trim();
            
            if (!nombre) {
                alert('Tienes que escribir algo');
                return;
            }

            document.getElementById('loading').style.display = 'block';
            document.getElementById('results').innerHTML = '';
            document.getElementById('noResults').style.display = 'none';
            document.getElementById('instructions').style.display = 'none';

            const formData = new FormData();
            formData.append('search_term', nombre);

            fetch('<?= base_url('reportes/SuperheroReport5') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loading').style.display = 'none';
                
                if (data.success) {
                    mostrarResultados(data.data);
                } else {
                    document.getElementById('noResults').style.display = 'block';
                }
            })
            .catch(error => {
                document.getElementById('loading').style.display = 'none';
                console.log('Error:', error);
                alert('Error al buscar');
            });
        }

        function mostrarResultados(superheroes) {
            const contenedor = document.getElementById('results');
            contenedor.innerHTML = '';

            for (let i = 0; i < superheroes.length; i++) {
                const tarjeta = crearTarjeta(superheroes[i]);
                contenedor.appendChild(tarjeta);
            }
        }

        function crearTarjeta(heroe) {
            const div = document.createElement('div');
            div.className = 'col-md-6 col-lg-4 mb-4';
            
            const claseAlineacion = obtenerClase(heroe.alignment);
            const altura = heroe.height_cm ? heroe.height_cm + ' cm' : 'No disponible';
            const peso = heroe.weight_kg ? heroe.weight_kg + ' kg' : 'No disponible';
            
            div.innerHTML = `
                <div class="card result-card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="superhero-name mb-0">${heroe.superhero_name || 'Sin nombre'}</h5>
                            <span class="badge alignment-badge ${claseAlineacion}">${heroe.alignment || 'Desconocido'}</span>
                        </div>
                        
                        <h6 class="text-muted mb-3">
                            <i class="fas fa-user me-2"></i>${heroe.full_name || 'Nombre no disponible'}
                        </h6>
                        
                        <div class="hero-stats">
                            <div class="stat-item">
                                <span class="stat-label"><i class="fas fa-building me-2"></i>Editorial:</span>
                                <span class="stat-value">${heroe.publisher_name || 'No disponible'}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label"><i class="fas fa-ruler-vertical me-2"></i>Altura:</span>
                                <span class="stat-value">${altura}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label"><i class="fas fa-weight me-2"></i>Peso:</span>
                                <span class="stat-value">${peso}</span>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">
                            <button class="btn btn-pdf btn-sm px-4" onclick="generarPDF(${heroe.id})">
                                <i class="fas fa-file-pdf me-2"></i>Generar PDF
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            return div;
        }

        function obtenerClase(alineacion) {
            if (alineacion == 'Good') {
                return 'bg-success';
            } else if (alineacion == 'Bad') {
                return 'bg-danger';
            } else if (alineacion == 'Neutral') {
                return 'bg-warning';
            } else {
                return 'bg-secondary';
            }
        }

        function generarPDF(id) {
            document.getElementById('pdfSuperheroId').value = id;
            document.getElementById('pdfForm').submit();
        }
    </script>
</body>
</html>