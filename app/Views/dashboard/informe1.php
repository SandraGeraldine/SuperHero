<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
<body>
  <div class="container mt-5">
    <canvas id="lienzo"></canvas>
    <hr>
    <canvas id="otro-lienzo"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded',()=>{
        const lienzo = document.getElementById('lienzo');
        const otroLienzo = document.getElementById('otro-lienzo');

        const grafico1 = new Chart(lienzo,{
          type: 'bar',
          data: {
            labels: ,
            datasets: [{
              label: 'Musica',
              data: [12, 19, 3, 5],
              data: [10, 15, 8, 6],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });

        const data = [
          {year:2010,ingresos:10,egresos:20},
          {year:2011,ingresos:15,egresos:15},
          {year:2012,ingresos:8,egresos:10},
          {year:2013,ingresos:6,egresos:5},
        ];

        const grafico2 = new Chart(otroLienzo,{
          type:'line',
          data:{
            labels: data.map(item => item.year),
            datasets:[{
              data: data.map(item => item.egresos),
              label:'Egresados',
            }]
          }
        });
      });
  
          
    </script>
  </body>
</html>