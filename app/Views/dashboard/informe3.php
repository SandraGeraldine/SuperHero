<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informe 3</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>

<div class="container mt-2">
    <button class="btn btn-outline-primary" id="obtener-datos" type="button">Obtener Datos</button>
    <canvas id="lienzo"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
  <script>
    const lienzo = document.getElementById('lienzo');
    const btnDatos = document.getElementById('obtener-datos');
    let grafico = null

    function renderGraphic(){
      grafico = new Chart(lienzo,{
         type: 'bar',
         data:{
          labels: [],
          datasets:[{
            labels: '',
            data: [],
            background: 'rgba(54, 197, 185, 0.87)',
            borderColor: 'rgba(209, 214, 130, 1)',
          }]
         } 
      })//new Chart
    }//renderGraphic

    btnDatos.addEventListener("click", async()=>{
      try {
        const response = await fetch('<?= base_url()?>/public/api/informe3Cache',{method:'GET'});

        if(!response.ok){
          throw new Error('No se pudo lograr la comunicacion');
        }
        const data = await response.json();
        if(data.success){
          grafico.data.labels = data.resumen.map(row=> row.alignment);
          grafico.data.datasets[0].data = data.resumen.map(row=> row.total);
          grafico.data.datasets[0].labels = data.message
          grafico.update();
        }
        
      } catch (error) {
        console.error(error);
      }
    })
    renderGraphic();


  </script>
</body>
</html> 