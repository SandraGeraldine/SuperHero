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
        $this->db = \config\Database::connect();
    }

    // REPORTE 5 - Vista principal de búsqueda de superhéroes
    public function getReport5()
    {
        return view('reportes/reporte5');
    }

    // REPORTE 5 - Autocompletado para el campo de búsqueda
    public function autocompleteSuperhero()
    {
        $searchTerm = $this->request->getPost('term');
        
        if (empty($searchTerm) || strlen($searchTerm) < 2) {
            return $this->response->setJSON([]);
        }

        $cn = \Config\Database::connect();
        
        try {
            $query = "
                SELECT DISTINCT
                    SH.id,
                    SH.superhero_name,
                    SH.full_name,
                    PB.publisher_name
                FROM superhero SH
                LEFT JOIN publisher PB ON SH.publisher_id = PB.id
                WHERE SH.superhero_name LIKE ? OR SH.full_name LIKE ?
                ORDER BY SH.superhero_name ASC
                LIMIT 8
            ";
            
            $searchPattern = '%' . $searchTerm . '%';
            $result = $cn->query($query, [$searchPattern, $searchPattern]);
            $suggestions = $result->getResultArray();
            
            // Formatear las sugerencias para el frontend
            $formattedSuggestions = [];
            foreach ($suggestions as $hero) {
                $formattedSuggestions[] = [
                    'id' => $hero['id'],
                    'label' => $hero['superhero_name'] . ($hero['full_name'] ? ' (' . $hero['full_name'] . ')' : ''),
                    'value' => $hero['superhero_name'],
                    'publisher' => $hero['publisher_name'] ?? 'Sin editorial'
                ];
            }
            
            return $this->response->setJSON($formattedSuggestions);
            
        } catch (Exception $e) {
            return $this->response->setJSON([]);
        }
    }

    // REPORTE 5 - Método para buscar superhéroe por nombre (AJAX)
    public function SuperheroReport5()
    {
        $searchTerm = $this->request->getPost('search_term');
        
        if (empty($searchTerm)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Por favor ingresa un nombre para buscar'
            ]);
        }

        $cn = \Config\Database::connect();
        
        // Debug: Verificar la conexión
        try {
            // Primero probemos una consulta simple
            $testQuery = "SELECT COUNT(*) as total FROM superhero";
            $testResult = $cn->query($testQuery);
            $total = $testResult->getRowArray();
            
            $query = "
                SELECT 
                    SH.id,
                    SH.superhero_name,
                    SH.full_name,
                    SH.height_cm,
                    SH.weight_kg,
                    PB.publisher_name,
                    AL.alignment
                FROM superhero SH
                LEFT JOIN publisher PB ON SH.publisher_id = PB.id
                LEFT JOIN alignment AL ON SH.alignment_id = AL.id
                WHERE SH.superhero_name LIKE ? OR SH.full_name LIKE ?
                LIMIT 10
            ";
            
            $searchPattern = '%' . $searchTerm . '%';
            $result = $cn->query($query, [$searchPattern, $searchPattern]);
            $superheroes = $result->getResultArray();

            // Debug: Agregar información adicional
            if (empty($superheroes)) {
                // Intentar búsqueda más amplia para debug
                $debugQuery = "SELECT superhero_name FROM superhero LIMIT 5";
                $debugResult = $cn->query($debugQuery);
                $sampleHeroes = $debugResult->getResultArray();
                
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se encontraron superhéroes con ese nombre',
                    'debug' => [
                        'search_term' => $searchTerm,
                        'search_pattern' => $searchPattern,
                        'total_heroes' => $total['total'],
                        'sample_heroes' => $sampleHeroes
                    ]
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'data' => $superheroes
            ]);
            
        } catch (Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error de base de datos: ' . $e->getMessage()
            ]);
        }
    }

    // REPORTE 5 - Método para generar PDF del superhéroe seleccionado
    public function Report5PDF()
    {
        $superhero_id = $this->request->getPost('superhero_id');
        
        if (empty($superhero_id)) {
            return redirect()->back()->with('error', 'ID de superhéroe no válido');
        }

        $cn = \Config\Database::connect();
        $query = "
            SELECT 
                SH.id,
                SH.superhero_name,
                SH.full_name,
                SH.height_cm,
                SH.weight_kg,
                PB.publisher_name,
                AL.alignment
            FROM superhero SH
            LEFT JOIN publisher PB ON SH.publisher_id = PB.id
            LEFT JOIN alignment AL ON SH.alignment_id = AL.id
            WHERE SH.id = ?
        ";
        
        $result = $cn->query($query, [$superhero_id]);
        $superhero = $result->getRowArray();

        if (!$superhero) {
            return redirect()->back()->with('error', 'Superhéroe no encontrado');
        }

        $data = [
            "superhero" => $superhero,
            "estilos" => view('reportes/estilos')
        ];

        $html = view('reportes/reporte5_pdf', $data);

        $html2Pdf = new Html2Pdf('P','A4','es',true);
        
        try {
            $html2Pdf->writeHTML($html);

            $this->response->setHeader('Content-Type','application/pdf');
            $filename = 'Reporte5-Superhero-' . str_replace(' ', '-', $superhero['superhero_name']) . '.pdf';
            $html2Pdf->output($filename);
            exit();
        }
        catch(Html2PdfException $e){
            $html2Pdf->clean();
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getMessage();
        }
    }

    // Métodos existentes
    public function getReport1()
    {
        $html = view('reportes/reporte1');
        $Html2Pdf = new Html2Pdf();
        $Html2Pdf->writeHTML($html);
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
            exit();
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
            "rows" => $rows->getResultArray(),
            "estilos" => view('reportes/estilos')
        ];

        $html = view('reportes/reporte3', $data);

        $html2Pdf = new Html2Pdf('P','A4','es',true);
        
        try{
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