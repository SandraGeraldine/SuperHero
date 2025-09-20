<style>
    * {
      margin: 0;
      padding: 0;
      border: 0;
      box-sizing: border-box;
    }
    .bg-secondary {background-color: #5bb0c1ff;}

    .bg-primary {
      background-color: #b95858ff;
      color: white; 
    }

    .bg-danger {
      background-color: #dfd8d8ff;
    }

    .text-light {
      color: #fff;
    }

    .text-center {
      text-align: center;
    }

    .text-end {
      text-align: right;
    }

    .text-justify {
      text-align: justify;
    }

    .mb-1 {
      margin-bottom: 5px;
    }

    .mb-2 {
      margin-bottom: 10px;
    }

    .mb-3 {
      margin-bottom: 15px;
    }

    .mt-1 {
      margin-top: 5px;
    }

    .mt-2 {
      margin-top: 10px;
    }

    .mt-3 {
      margin-top: 15px;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      border: 0.5px solid black;
    }

    .table td,
    .table th {
      border: 0.5px solid black;
      padding: 5px;
    }

    /* Estilos específicos para reporte5_pdf - Sandra De La Cruz */
    .pdf-body {
        font-family: 'Arial', sans-serif; /* Me gusta esta fuente */
        margin: 10px; /* Reducido de 20px para ahorrar espacio */
        background-color: #f8f9fa;
        line-height: 1.4; /* Reducido de 1.6 para ser más compacto */
    }
    
    .header {
        /* Header con los colores que me gustan */
        background: linear-gradient(135deg, #745c77ff 0%, #b88087ff 100%);
        color: white;
        padding: 20px; /* Reducido de 35px */
        border-radius: 10px; /* Reducido de 15px */
        text-align: center;
        margin-bottom: 15px; /* Reducido de 30px */
        box-shadow: 0 4px 10px rgba(0,0,0,0.15); /* Sombra más pequeña */
    }
    
    .hero-card {
        background: white;
        border-radius: 15px; /* Reducido de 20px */
        padding: 20px; /* Reducido de 35px */
        box-shadow: 0 5px 15px rgba(0,0,0,0.1); /* Sombra más pequeña */
        margin-bottom: 15px; /* Reducido de 25px */
        border: 1px solid #e9ecef; /* Borde sutil */
    }
    .hero-name {
        color: #2c3e50;
        font-size: 24px; /* Reducido de 32px */
        font-weight: bold;
        margin-bottom: 8px; /* Reducido de 15px */
        text-align: center;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1); /* Sombra sutil */
    }
    
    .hero-real-name {
        color: #6c757d; /* Color más suave */
        font-size: 16px; /* Reducido de 20px */
        text-align: center;
        margin-bottom: 20px; /* Reducido de 35px */
        font-style: italic;
        font-weight: 300;
    }
    .info-grid {
        display: table;
        width: 100%;
        margin-top: 10px; /* Reducido de 20px */
    }
    .info-row {
        display: table-row;
    }
    .info-label {
        display: table-cell;
        background: linear-gradient(135deg, #9cc9c6ff 0%, #44a08d 100%); /* Mis colores favoritos */
        color: white;
        padding: 12px; /* Reducido de 18px */
        font-weight: bold;
        width: 35%; /* Un poco más ancho */
        vertical-align: middle;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.2);
        font-size: 13px; /* Añadido para texto más pequeño */
    }
    
    .info-value {
        display: table-cell;
        background-color: #f8f9fa; /* Color más suave */
        padding: 12px; /* Reducido de 18px */
        border-left: 3px solid #9cc9c6ff; /* Borde más delgado */
        vertical-align: middle;
        font-size: 13px; /* Añadido para texto más pequeño */
    }
    .alignment-badge {
        display: inline-block;
        padding: 6px 12px; /* Reducido de 10px 18px */
        border-radius: 20px; /* Reducido de 25px */
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 11px; /* Reducido de 14px */
        box-shadow: 0 2px 4px rgba(0,0,0,0.2); /* Sombra más pequeña */
    }
    
    /* Colores que me gustan para las alineaciones */
    .alignment-good { 
        background: linear-gradient(45deg, #27ae60, #2ecc71); 
    }
    .alignment-bad { 
        background: linear-gradient(45deg, #e74c3c, #c0392b); 
    }
    .alignment-neutral { 
        background: linear-gradient(45deg, #f39c12, #e67e22); 
    }
    .alignment-unknown { 
        background: linear-gradient(45deg, #95a5a6, #7f8c8d); 
    }
    .footer {
        margin-top: 25px; /* Reducido de 50px */
        text-align: center;
        color: #6c757d; /* Color más suave */
        font-size: 11px; /* Reducido de 13px */
        border-top: 1px solid #dee2e6; /* Línea más delgada */
        padding-top: 15px; /* Reducido de 25px */
        background: linear-gradient(to right, transparent, #f8f9fa, transparent);
        padding: 15px; /* Reducido de 25px */
        border-radius: 8px; /* Reducido de 10px */
    }
    
    .icon {
        margin-right: 8px; /* Reducido de 10px */
        font-size: 14px; /* Reducido de 16px */
    }
    
    /* Efecto hover para cuando se vea en pantalla */
    .info-row:hover .info-label {
        background: linear-gradient(135deg, #44a08d 0%, #9cc9c6ff 100%);
    }
  </style>