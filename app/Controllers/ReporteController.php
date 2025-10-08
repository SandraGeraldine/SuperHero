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
        
        $query = "
            SELECT 
                SH.id,
                SH.superhero_name,
                SH.full_name,
                PB.publisher_name
            FROM superhero SH
            LEFT JOIN publisher PB ON SH.publisher_id = PB.id
            WHERE SH.superhero_name LIKE ? OR SH.full_name LIKE ?
            ORDER BY SH.superhero_name ASC
            LIMIT 5
        ";
        
        $searchPattern = '%' . $searchTerm . '%';
        $result = $cn->query($query, [$searchPattern, $searchPattern]);
        $suggestions = $result->getResultArray();
        
        $data = [
          
        ];
        foreach ($suggestions as $hero) {
            $data[] = [
                'id' => $hero['id'],
                'label' => $hero['superhero_name'] . ($hero['full_name'] ? ' (' . $hero['full_name'] . ')' : ''),
                'value' => $hero['superhero_name'],
                'publisher' => $hero['publisher_name'] ?? 'Sin editorial'
            ];
        }
        
        return $this->response->setJSON($data);
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

        if (empty($superheroes)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No se encontraron superhéroes con ese nombre'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $superheroes
        ]);
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

        // Obtener atributos del superhéroe (Intelligence, Strength, etc.)
        $attributesQuery = "
            SELECT 
                AT.attribute_name,
                HA.attribute_value
            FROM hero_attribute HA
            INNER JOIN attribute AT ON HA.attribute_id = AT.id
            WHERE HA.hero_id = ?
            ORDER BY AT.id
        ";
        $attributesResult = $cn->query($attributesQuery, [$superhero_id]);
        $attributes = $attributesResult->getResultArray();

        // Obtener poderes del superhéroe
        $powersQuery = "
            SELECT 
                SP.power_name
            FROM hero_power HP
            INNER JOIN superpower SP ON HP.power_id = SP.id
            WHERE HP.hero_id = ?
            ORDER BY SP.power_name
        ";
        $powersResult = $cn->query($powersQuery, [$superhero_id]);
        $powers = $powersResult->getResultArray();

        $data = [
            "superhero" => $superhero,
            "attributes" => $attributes,
            "powers" => $powers,
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

    public function getReport6()
    {
        return view('reportes/reporte6');
    }

    public function Report6PDF()
    {
        $titulo = $this->request->getPost('titulo');
        $genero = $this->request->getPost('genero');
        $limite = $this->request->getPost('limite');
        
        // Validaciones
        if (empty($titulo)) {
            return redirect()->back()->with('error', 'El título es requerido');
        }
        
        if (empty($genero)) {
            return redirect()->back()->with('error', 'Debe seleccionar al menos un género');
        }
        
        $limite = (int)$limite;
        if ($limite < 10 || $limite > 20) {
            return redirect()->back()->with('error', 'El límite debe estar entre 10 y 20');
        }

        $cn = \Config\Database::connect();
        
        // Construir la consulta según el género seleccionado
        $whereClause = "";
        $params = [];
        
        if (is_array($genero)) {
            $genderConditions = [];
            foreach ($genero as $g) {
                if ($g === 'masculino') {
                    $genderConditions[] = "SH.gender_id = 1";
                } elseif ($g === 'femenino') {
                    $genderConditions[] = "SH.gender_id = 2";
                } elseif ($g === 'na') {
                    $genderConditions[] = "SH.gender_id IS NULL OR SH.gender_id NOT IN (1, 2)";
                }
            }
            if (!empty($genderConditions)) {
                $whereClause = "WHERE (" . implode(" OR ", $genderConditions) . ")";
            }
        }
        
        $query = "
            SELECT 
                SH.id,
                SH.superhero_name,
                SH.full_name,
                SH.height_cm,
                SH.weight_kg,
                PB.publisher_name,
                AL.alignment,
                G.gender as gender_name
            FROM superhero SH
            LEFT JOIN publisher PB ON SH.publisher_id = PB.id
            LEFT JOIN alignment AL ON SH.alignment_id = AL.id
            LEFT JOIN gender G ON SH.gender_id = G.id
            $whereClause
            ORDER BY SH.superhero_name
            LIMIT ?
        ";
        
        $params[] = $limite;
        $result = $cn->query($query, $params);
        $superheroes = $result->getResultArray();

        $data = [
            "titulo" => $titulo,
            "superheroes" => $superheroes,
            "genero_seleccionado" => $genero,
            "limite" => $limite,
            "total_encontrados" => count($superheroes),
            "estilos" => view('reportes/estilos')
        ];

        $html = view('reportes/reporte6_pdf', $data);

        $html2Pdf = new Html2Pdf('P','A4','es',true);
        
        try {
            $html2Pdf->writeHTML($html);
            $this->response->setHeader('Content-Type','application/pdf');
            $filename = 'Reporte-' . str_replace(' ', '-', $titulo) . '.pdf';
            $html2Pdf->output($filename);
            exit();
        }
        catch(Html2PdfException $e){
            $html2Pdf->clean();
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getMessage();
        }
    }

    public function getReport7()
    {
        return view('reportes/reporte7');
    }

    public function generateChart7()
    {
        $publishers = $this->request->getPost('publishers');
        
        if (empty($publishers)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Debe seleccionar al menos una editorial'
            ]);
        }

        $cn = \Config\Database::connect();
        
        // Construir condiciones WHERE
        $whereConditions = [];
        $params = [];
        
        foreach ($publishers as $publisher) {
            if ($publisher === 'na') {
                $whereConditions[] = "PB.publisher_name IS NULL";
            } else {
                $whereConditions[] = "PB.publisher_name LIKE ?";
                $params[] = '%' . $publisher . '%';
            }
        }
        
        $whereClause = "WHERE (" . implode(" OR ", $whereConditions) . ")";
        
        $query = "
            SELECT 
                COALESCE(PB.publisher_name, 'N/A') as publisher_name,
                COUNT(*) as total_heroes,
                SUM(CASE WHEN AL.alignment = 'good' THEN 1 ELSE 0 END) as heroes_buenos,
                SUM(CASE WHEN AL.alignment = 'bad' THEN 1 ELSE 0 END) as heroes_malos,
                SUM(CASE WHEN AL.alignment = 'neutral' THEN 1 ELSE 0 END) as heroes_neutrales
            FROM superhero SH
            LEFT JOIN publisher PB ON SH.publisher_id = PB.id
            LEFT JOIN alignment AL ON SH.alignment_id = AL.id
            $whereClause
            GROUP BY PB.publisher_name
            ORDER BY total_heroes DESC
        ";
        
        $result = $cn->query($query, $params);
        $data = $result->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }

    public function generateWeightChart7()
    {
        $publishers = $this->request->getPost('publishers');
        
        if (empty($publishers)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Debe seleccionar al menos una editorial'
            ]);
        }

        $cn = \Config\Database::connect();
        
        // Construir condiciones WHERE
        $whereConditions = [];
        $params = [];
        
        foreach ($publishers as $publisher) {
            if ($publisher === 'na') {
                $whereConditions[] = "PB.publisher_name IS NULL";
            } else {
                $whereConditions[] = "PB.publisher_name LIKE ?";
                $params[] = '%' . $publisher . '%';
            }
        }
        
        $whereClause = "WHERE (" . implode(" OR ", $whereConditions) . ") AND SH.weight_kg IS NOT NULL AND SH.weight_kg > 0";
        
        $query = "
            SELECT 
                COALESCE(PB.publisher_name, 'N/A') as publisher_name,
                ROUND(AVG(SH.weight_kg), 2) as promedio_peso,
                COUNT(*) as total_heroes_con_peso,
                MIN(SH.weight_kg) as peso_minimo,
                MAX(SH.weight_kg) as peso_maximo
            FROM superhero SH
            LEFT JOIN publisher PB ON SH.publisher_id = PB.id
            LEFT JOIN alignment AL ON SH.alignment_id = AL.id
            $whereClause
            GROUP BY PB.publisher_name
            HAVING COUNT(*) > 0
            ORDER BY promedio_peso ASC
        ";
        
        $result = $cn->query($query, $params);
        $data = $result->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }

    public function getReport8()
    {
        return view('reportes/reporte8');
    }

    public function generateWeightChart8()
    {
        $publishers = $this->request->getPost('publishers');
        
        if (empty($publishers)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Debe seleccionar al menos una editorial'
            ]);
        }

        $cn = \Config\Database::connect();
        
        // Construir condiciones WHERE
        $whereConditions = [];
        $params = [];
        
        foreach ($publishers as $publisher) {
            if ($publisher === 'na') {
                $whereConditions[] = "PB.publisher_name IS NULL";
            } else {
                $whereConditions[] = "PB.publisher_name LIKE ?";
                $params[] = '%' . $publisher . '%';
            }
        }
        
        $whereClause = "WHERE (" . implode(" OR ", $whereConditions) . ") AND SH.weight_kg IS NOT NULL AND SH.weight_kg > 0";
        
        $query = "
            SELECT 
                COALESCE(PB.publisher_name, 'N/A') as publisher_name,
                ROUND(AVG(SH.weight_kg), 2) as promedio_peso,
                COUNT(*) as total_heroes_con_peso,
                MIN(SH.weight_kg) as peso_minimo,
                MAX(SH.weight_kg) as peso_maximo
            FROM superhero SH
            LEFT JOIN publisher PB ON SH.publisher_id = PB.id
            LEFT JOIN alignment AL ON SH.alignment_id = AL.id
            $whereClause
            GROUP BY PB.publisher_name
            HAVING COUNT(*) > 0
            ORDER BY promedio_peso ASC
        ";
        
        $result = $cn->query($query, $params);
        $data = $result->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => $data
        ]);
    }
}