<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\Database\Query;
use Exception;
use PhpParser\Node\Expr\Exit_;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class ReporteController extends BaseController{

  protected $db;

  
  public function __construct(){
    $this->db = \Config\Database::connect();
  }
  public function getReport1()
  {
      // Load view content
      $html = view('reportes/reporte1');

      // Generate PDF
      $Html2Pdf = new Html2Pdf();
      $Html2Pdf->writeHTML($html);

      // Return PDF as response
      $this->response->setHeader('Content-Type', 'application/pdf');
      $Html2Pdf->output('reporte1.pdf'); 
  }
  public function getReport2(){
      $data = [
        "area" => "Sistemas",
        "autor" => "Sandra De La Cruz",
        "productos" => [
        ["id" => 1 , "Descripcion" => "Monitor", "Precio" => 750],
        ["id" => 2 , "Descripcion" => "Impresora", "Precio" => 500],
        ["id" => 3 , "Descripcion" => "WebCam", "Precio" => 220],
           
        ],
        "estilos" => view('reportes/estilos')
     ];
      $html = view('reportes/reporte2', $data);

      $html2Pdf = new Html2Pdf('P','A4','es',true);
      
      try{
        $html2Pdf->writeHTML($html);

        $this->response->setHeader('Content-Type','application/pdf');
        $html2Pdf->output('Reporte-Finanzas.pdf');
        Exit();
      }
      catch(Html2PdfException $e){
        $html2Pdf->clean();
        $formatter = new ExceptionFormatter($e);
        echo $formatter->getMessage();
      }
  }
    public function getReport3(){

      $cn = \Config\Database::connect();
      $query = "
        SELECT 
          SH.id,
          SH.superhero_name,
          SH.full_name,
          PB.publisher_name,
          AL.alignment
          FROM superhero SH
          LEFT JOIN publisher PB ON SH.publisher_id = PB.id
          LEFT JOIN alignment AL ON SH.alignment_id = AL.id
          ORDER BY 4
          LIMIT 100;
      ";
      $rows = $cn->query($query);

      $data = [
        "rows" => $rows-> getResultArray(),
        "estilos" => view('reportes/estilos')
      ];

      $html = view('reportes/reporte3', $data);

      $html2Pdf = new Html2Pdf('P','A4','es',true);
      
      try{
        $html2Pdf->writeHTML($html);

        $this->response->setHeader('Content-Type','application/pdf');
        $html2Pdf->output('Reporte-Superhero.pdf');
        Exit();
      }
      catch(Html2PdfException $e){
        $html2Pdf->clean();
        $formatter = new ExceptionFormatter($e);
        echo $formatter->getMessage();

      }
  }
 public function index()
  {
      $cn = \Config\Database::connect();
      $query = $cn->query(
        "SELECT id, publisher_name 
              FROM publisher 
              ORDER BY publisher_name");
      $publishers = $query->getResultArray();

      $data = [
          'publishers' => $publishers
      ];

      return view('reportes/index', $data);
  }

  public function getReport4()
{
    $publisher_id = $this->request->getPost('publisher_id');

    // Consulta filtrada por publisher_id
    $cn = \Config\Database::connect();
    $query = "
        SELECT 
          SH.id,
          SH.superhero_name,
          SH.full_name,
          PB.publisher_name,
          AL.alignment
        FROM superhero SH
        LEFT JOIN publisher PB ON SH.publisher_id = PB.id
        LEFT JOIN alignment AL ON SH.alignment_id = AL.id
        WHERE PB.id = ?
        ORDER BY SH.superhero_name;
    ";
    $rows = $cn->query($query, [$publisher_id]);

    $data = [
        "rows" => $rows->getResultArray(),
        "estilos" => view('reportes/estilos')
    ];

    $html = view('reportes/reporte4', $data);

    $html2Pdf = new Html2Pdf('P','A4','es',true);
    
    try {
        $html2Pdf->writeHTML($html);

        $this->response->setHeader('Content-Type','application/pdf');
        $html2Pdf->output('Reporte-Superhero.pdf');
        exit();
    }
    catch(Html2PdfException $e){
        $html2Pdf->clean();
        $formatter = new ExceptionFormatter($e);
        echo $formatter->getMessage();
    }
}

}
