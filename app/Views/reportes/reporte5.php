<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Superhéroes - Sandra De La Cruz</title>
    <!-- Bootstrap y Font Awesome para que se vea bonito -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Mis estilos personalizados - me gusta el morado y azul */
        body {
            /* Fondo degradado que me gusta mucho */
            background: linear-gradient(135deg, #c7cde6ff 0%, #b29cc7ff 100%);
            min-height: 100vh;
            padding: 20px;
            font-family: 'Arial', sans-serif; /* Fuente más legible */
        }
        
        .main-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(31, 30, 30, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden; /* Para que se vea mejor */
        }
        
        .search-section {
            /* Header con colores que combinan */
            background: linear-gradient(135deg, #745c77ff 0%, #b88087ff 100%);
            border-radius: 20px 20px 0 0;
            color: white;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3); /* Sombra al texto */
        }
        .result-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
            background: linear-gradient(145deg, #ffffff, #f0f0f0); /* Efecto sutil */
        }
        
        .result-card:hover {
            /* Animación cuando pasas el mouse - se ve genial! */
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
            cursor: pointer;
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
        
        /* Estilos para el autocompletado */
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
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        
        .suggestion-item {
            padding: 12px 20px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        
        .suggestion-item:hover {
            background-color: #f8f9fa;
        }
        
        .suggestion-item.active {
            background: linear-gradient(45deg, #9cc9c6ff, #44a08d);
            color: white;
        }
        
        .suggestion-item:last-child {
            border-bottom: none;
        }
        
        .suggestion-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 3px;
        }
        
        .suggestion-publisher {
            font-size: 12px;
            color: #6c757d;
        }
        
        .suggestion-item.active .suggestion-name,
        .suggestion-item.active .suggestion-publisher {
            color: white;
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
                            <i class="fas fa-mask fa-3x mb-3" style="color: #ffd700;"></i> <!-- Dorado se ve mejor -->
                            <h2 class="mb-2">Mi Buscador de Superhéroes</h2>
                            <p class="mb-0">Aquí puedes buscar todos tus superhéroes favoritos 🦸‍♂️</p>
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
                                            <i class="fas fa-search me-2"></i>¡Buscar!
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
                            <i class="fas fa-sad-tear fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">¡Ups! No encontré nada</h4>
                            <p class="text-muted">Prueba con otro nombre, tal vez "Superman" o "Batman"</p>
                        </div>

                        <!-- Results Container -->
                        <div id="results" class="row"></div>

                        <!-- Instrucciones de uso -->
                        <div id="instructions" class="text-center py-5">
                            <i class="fas fa-lightbulb fa-3x text-warning mb-3"></i>
                            <h4 class="text-info">¿Cómo funciona esto?</h4>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="fas fa-keyboard fa-2x text-primary mb-3"></i>
                                        <h6>1. Escribe</h6>
                                        <p class="text-muted small">Pon el nombre de tu superhéroe favorito</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="fas fa-mouse-pointer fa-2x text-success mb-3"></i>
                                        <h6>2. Busca</h6>
                                        <p class="text-muted small">Dale clic al botón o presiona Enter</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3">
                                        <i class="fas fa-download fa-2x text-danger mb-3"></i>
                                        <h6>3. Descarga</h6>
                                        <p class="text-muted small">¡Guarda la info en PDF!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario oculto para generar PDF -->
    <form id="pdfForm" action="<?= base_url('reportes/Report5PDF') ?>" method="post" style="display: none;">
        <input type="hidden" id="pdfSuperheroId" name="superhero_id">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mi código JavaScript con autocompletado - Sandra De La Cruz
        
        let autocompleteTimeout;
        let currentSuggestionIndex = -1;
        let suggestions = [];
        
        const searchInput = document.getElementById('searchInput');
        const suggestionsContainer = document.getElementById('autocompleteSuggestions');
        
        // Autocompletado mientras escribes
        searchInput.addEventListener('input', function() {
            const term = this.value.trim();
            
            // Limpiar timeout anterior
            clearTimeout(autocompleteTimeout);
            
            if (term.length < 2) {
                ocultarSugerencias();
                return;
            }
            
            // Esperar un poco antes de hacer la consulta (para no saturar el servidor)
            autocompleteTimeout = setTimeout(() => {
                buscarSugerencias(term);
            }, 300);
        });
        
        // Navegación con teclado en las sugerencias
        searchInput.addEventListener('keydown', function(e) {
            const suggestionItems = suggestionsContainer.querySelectorAll('.suggestion-item');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                currentSuggestionIndex = Math.min(currentSuggestionIndex + 1, suggestionItems.length - 1);
                actualizarSugerenciaActiva();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                currentSuggestionIndex = Math.max(currentSuggestionIndex - 1, -1);
                actualizarSugerenciaActiva();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (currentSuggestionIndex >= 0 && suggestionItems[currentSuggestionIndex]) {
                    seleccionarSugerencia(suggestions[currentSuggestionIndex]);
                } else {
                    buscarSuperheroe();
                }
            } else if (e.key === 'Escape') {
                ocultarSugerencias();
            }
        });
        
        // Ocultar sugerencias al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                ocultarSugerencias();
            }
        });
        
        function buscarSugerencias(term) {
            const formData = new FormData();
            formData.append('term', term);
            
            fetch('<?= base_url('reportes/autocompleteSuperhero') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mostrarSugerencias(data);
            })
            .catch(error => {
                console.error('Error en autocompletado:', error);
                ocultarSugerencias();
            });
        }
        
        function mostrarSugerencias(data) {
            suggestions = data;
            currentSuggestionIndex = -1;
            
            if (data.length === 0) {
                ocultarSugerencias();
                return;
            }
            
            let html = '';
            data.forEach((item, index) => {
                html += `
                    <div class="suggestion-item" onclick="seleccionarSugerencia(suggestions[${index}])">
                        <div class="suggestion-name">${item.label}</div>
                        <div class="suggestion-publisher">📖 ${item.publisher}</div>
                    </div>
                `;
            });
            
            suggestionsContainer.innerHTML = html;
            suggestionsContainer.style.display = 'block';
        }
        
        function ocultarSugerencias() {
            suggestionsContainer.style.display = 'none';
            currentSuggestionIndex = -1;
        }
        
        function actualizarSugerenciaActiva() {
            const suggestionItems = suggestionsContainer.querySelectorAll('.suggestion-item');
            
            suggestionItems.forEach((item, index) => {
                if (index === currentSuggestionIndex) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        }
        
        function seleccionarSugerencia(suggestion) {
            searchInput.value = suggestion.value;
            ocultarSugerencias();
            buscarSuperheroe(); // Buscar automáticamente cuando selecciona
        }
        
        // Para que funcione con Enter (me gusta esta funcionalidad)
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                // Ya se maneja en el keydown de arriba
            }
        });

        function buscarSuperheroe() {
            const nombreBuscar = document.getElementById('searchInput').value.trim();
            
            // Validación básica
            if (!nombreBuscar) {
                alert('¡Oye! Tienes que escribir algo primero 😅');
                return;
            }

            // Mostrar indicador de carga
            document.getElementById('loading').style.display = 'block';
            document.getElementById('results').innerHTML = '';
            document.getElementById('noResults').style.display = 'none';
            document.getElementById('instructions').style.display = 'none';

            // Preparar datos para enviar
            const formData = new FormData();
            formData.append('search_term', nombreBuscar);

            // Hacer la petición AJAX al servidor
            fetch('<?= base_url('reportes/SuperheroReport5') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('loading').style.display = 'none';
                
                // Debug: Ver qué está devolviendo el servidor
                console.log('Respuesta del servidor:', data);
                
                if (data.success) {
                    mostrarResultados(data.data);
                } else {
                    document.getElementById('noResults').style.display = 'block';
                    
                    // Mostrar información de debug si está disponible
                    if (data.debug) {
                        console.log('Info de debug:', data.debug);
                        
                        // Agregar la info de debug al mensaje de error
                        const noResultsDiv = document.getElementById('noResults');
                        const debugInfo = `
                            <div style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 10px; font-size: 12px; color: #6c757d;">
                                <strong>Info de debug:</strong><br>
                                Total de superhéroes en BD: ${data.debug.total_heroes}<br>
                                Término buscado: "${data.debug.search_term}"<br>
                                Ejemplos de superhéroes: ${data.debug.sample_heroes ? data.debug.sample_heroes.map(h => h.superhero_name).join(', ') : 'N/A'}
                            </div>
                        `;
                        noResultsDiv.innerHTML += debugInfo;
                    }
                }
            })
            .catch(error => {
                document.getElementById('loading').style.display = 'none';
                console.error('Error:', error);
                alert('Algo salió mal... Intenta de nuevo 😕');
            });
        }

        function mostrarResultados(superheroes) {
            const contenedor = document.getElementById('results');
            contenedor.innerHTML = '';

            superheroes.forEach(heroe => {
                const tarjetaHeroe = crearTarjetaHeroe(heroe);
                contenedor.appendChild(tarjetaHeroe);
            });
        }

        function crearTarjetaHeroe(heroe) {
            const columna = document.createElement('div');
            columna.className = 'col-md-6 col-lg-4 mb-4';
            
            const claseAlineacion = obtenerClaseAlineacion(heroe.alignment);
            const textoAltura = heroe.height_cm ? `${heroe.height_cm} cm` : 'No disponible';
            const textoPeso = heroe.weight_kg ? `${heroe.weight_kg} kg` : 'No disponible';
            
            // Crear la tarjeta HTML (me gusta como se ve)
            columna.innerHTML = `
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
                                <span class="stat-value">${textoAltura}</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-label"><i class="fas fa-weight me-2"></i>Peso:</span>
                                <span class="stat-value">${textoPeso}</span>
                            </div>
                        </div>
                        
                        <div class="text-center mt-3">
                            <button class="btn btn-pdf btn-sm px-4" onclick="generarPDF(${heroe.id})">
                                <i class="fas fa-file-pdf me-2"></i>Descargar PDF
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            return columna;
        }

        function obtenerClaseAlineacion(alineacion) {
            // Función para los colores de las etiquetas
            switch(alineacion) {
                case 'Good': 
                    return 'bg-success'; // Verde para los buenos
                case 'Bad': 
                    return 'bg-danger';  // Rojo para los malos
                case 'Neutral': 
                    return 'bg-warning'; // Amarillo para neutrales
                default: 
                    return 'bg-secondary'; // Gris si no sabemos
            }
        }

        function generarPDF(idSuperheroe) {
            // Función para descargar el PDF
            document.getElementById('pdfSuperheroId').value = idSuperheroe;
            document.getElementById('pdfForm').submit();
        }
        
        // Un pequeño mensaje de que terminé esto :)
        console.log('✅ Buscador de Superhéroes cargado correctamente - Sandra De La Cruz');
    </script>
</body>
</html>