<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informe 4</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head> 
<body>
  <div class="container mt-2">
    <button class="btn btn-outline-primary" id="obtener-datos" type="button">Obtener Datos</button>
    <canvas id="lienzo"></canvas>
    <canvas id="lienzo2" class="mt-4"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
  <script>
    const lienzo = document.getElementById('lienzo');
    const lienzo2 = document.getElementById('lienzo2');
    const btnDatos = document.getElementById('obtener-datos');
    let grafico = null;
    let grafico2 = null;

    function renderGraphic(){
      grafico = new Chart(lienzo,{
        type: 'bar',
        data:{
          labels: [],
          datasets:[{
            label: 'Género',
            data: [],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
          }]
        }
      });
      grafico2 = new Chart(lienzo2,{
        type: 'bar',
        data:{
          labels: [],
          datasets:[{
            label: 'Publisher',
            data: [],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
          }]
        }
      });
    }
    btnDatos.addEventListener("click", async()=>{
      try {
        // Primer gráfico: género
        const responseGenero = await fetch('<?= base_url()?>public/api/informe4Cache',{method:'GET'});
        if(!responseGenero.ok){
          throw new Error('No se pudo lograr la comunicacion (género)');
        }
        const dataGenero = await responseGenero.json();
        if(dataGenero.success){
          const labelsGenero = dataGenero.resumen.map(row => row.gender);
          const valuesGenero = dataGenero.resumen.map(row => row.total);
          grafico.data.labels = labelsGenero;
          grafico.data.datasets[0].data = valuesGenero;
          grafico.update();
        }
        // Segundo gráfico: publisher
        const responsePublisher = await fetch('<?= base_url()?>public/api/informe5Cache',{method:'GET'});
        if(!responsePublisher.ok){
          throw new Error('No se pudo lograr la comunicacion (publisher)');
        }
        const dataPublisher = await responsePublisher.json();
        if(dataPublisher.success){
          const labelsPublisher = dataPublisher.resumen.map(row => row.publisher_name);
          const valuesPublisher = dataPublisher.resumen.map(row => row.total);
          grafico2.data.labels = labelsPublisher;
          grafico2.data.datasets[0].data = valuesPublisher;
          grafico2.update();
        }
      } catch (error) {
        console.error(error);
      }
    });
    renderGraphic();
  </script>
</body>
</html>