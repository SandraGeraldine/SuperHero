<style>

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
    
    /* Autocompletado - funcionalidad que aprendi */
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