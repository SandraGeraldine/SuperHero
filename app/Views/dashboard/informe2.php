<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informe 2</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <button class="btn btn-outline-primary" id="obtener-datos" type="button">Obtener Datos</button>
    <canvas id="lienzo"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const lienzo = document.getElementById('lienzo');
  const btnDatos = document.getElementById('obtener-datos');
  const tabla = document.getElementById("tabla");

  let grafico = null;

  function renderGraphic() {

    const backgroundColor=[
      'rgba(54, 162, 235, 0.2)',
      'rgba(46, 204, 113, 0.2)',
      'rgba(52, 152, 219, 0.2)',
      'rgba(155, 89, 182, 0.2)',
      'rgba(241, 196, 15, 0.2)',
    ];
    const borderColor=[
        'rgba(54, 162, 235, 1)',
        'rgba(46, 204, 113, 1)',
        'rgba(52, 152, 219, 1)',
        'rgba(155, 89, 182, 1)',
        'rgba(241, 196, 15, 1)',
    ];

    grafico = new Chart(lienzo, {
      type: 'bar',
      data: {
        labels: [],
        datasets: [{
          label: 'Popularidad',
          data: [],
          backgroundColor: backgroundColor,
        }]
      }

    });
  }

  btnDatos.addEventListener('click', async () => {
    try {
      const response = await fetch('http://superhero.test/public/api/informe2', { method: 'GET' });
      if (!response.ok) {
        throw new Error('No se pudo lograr la comunicacion');
      }
      const data = await response.json();
      console.log('Respuesta completa de la API:', data);
      if (data.success && Array.isArray(data.resumen) && data.resumen.length > 0) {
        const labels = data.resumen.map(row => row.superhero);
        const values = data.resumen.map(row => row.popularidad);
        console.log('Labels:', labels);
        console.log('Values:', values);
        grafico.data.labels = labels;
        grafico.data.datasets[0].data = values;
        grafico.update();

        data.resumen.forEach(element => {
           document.querySelector("#tabla-resumen thead tr").innerHTML +=  `${element.superhero}>`
        });
      } else {
        alert('No se recibieron datos válidos para el gráfico.');
        console.warn('Datos recibidos pero vacíos o mal formateados:', data.resumen);
      }
    } catch (error) {
      console.error('Error al obtener datos:', error);
      alert('Error al obtener datos del servidor. Revisa la consola para más detalles.');
    }
  });

  renderGraphic();
});
</script>
</body>
</html>