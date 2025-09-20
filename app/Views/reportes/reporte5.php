<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Superhéroes - SENATI</title>
    <!-- Bootstrap 5 - Como nos enseñaron en clase -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para los iconos bonitos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Estilos web personalizados -->
    <?= view('reportes/estilo') ?>
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
                                    <!-- Contenedor  -->
                                    <div id="autocompleteSuggestions" class="autocomplete-suggestions"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <div id="loading" class="loading text-center py-4">
                            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <p class="mt-3 text-muted">Buscando superhéroes increíbles...</p>
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
                Proyecto desarrollado por <strong>Sandra De La Cruz</strong> - SENATI<br>
            </small>
        </div>
    </div>

    <!-- Formulario oculto para generar PDF -->
    <form id="pdfForm" action="<?= base_url('reportes/Report5PDF') ?>" method="post" style="display: none;">
        <input type="hidden" id="pdfSuperheroId" name="superhero_id">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>

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