<?php

namespace App\Controllers;
use App\Models\ReporteAlignment;
use App\Models\ReportePublisher;
use App\Models\SuperHero;
use App\Controllers\BaseController;
use App\Models\ReporteRender;

class DashboardController extends BaseController{
    protected $db;
    public function __construct(){
        $this->db = \Config\Database::connect();
      }
      public function getinforme1(){
        
        return view('dashboard/informe1');
      }
      public function getinforme2(){
        
        return view('dashboard/informe2');
      }
      public function getDataInforme2(){
        $this->response->setContentType('application/json');

        //Popularidad
        $data = [
          ["superhero" => "Superman","popularidad" => 95],
          ["superhero" => "Spider-Man","popularidad" => 90],
          ["superhero" => "Batman","popularidad" => 85],
          ["superhero" => "Wonder Woman","popularidad" => 80],
          ["superhero" => "Flash","popularidad" => 75],
        ];
        //En caso no encontramos datos
        if(!$data){
          return $this->response->setJSON([
            'success' => false,
            'message'=> 'No se encontraron superheroes',
            'resumen' => []
          ]);
        }

        sleep(3);

        //Datos encontrados. 
        return $this->response->setJSON([
          'success' => true,
          'message'=> 'Datos obtenidos',
          'resumen' => $data
        ]);
      }
      public function getinforme3(){
        

        return view('dashboard/informe3');
      }
      public function getDataInforme3(){
        $this->response->setContentType('application/json');
        $reporteAlignment = new ReporteAlignment();
        $data = $reporteAlignment->findAll();

        if(!$data){
          return $this->response->setJSON([
            'success' => false,
            'message'=> 'No se encontraron superheroes',
            'resumen' => []
          ]);
        }

        //Datos encontrados. 
        return $this->response->setJSON([
          'success' => true,
          'message'=> 'Aligbnments obtenidos',
          'resumen' => $data
        ]);
      }
      public function getDataInforme3Cache(){
        $this->response->setContentType('application/json');

        //Clave unica - indentificador al conjunto de datos.

        //Objecto de cache
        $cacheKey = 'resumen-alignment';

        //Obtener los datos de la memoria cache
        $data = cache($cacheKey); 

        if($data == null){
          //No existe en cache. 
          $reporteAlignment = new ReporteAlignment();
          $data = $reporteAlignment->findAll();

          //Nueva memoria cache
          cache()->save($cacheKey, $data, 3600); 
        }

        if(!$data){
          return $this->response->setJSON([
            'success' => false,
            'message'=> 'No se encontraron superheroes',
            'resumen' => []
          ]);
        }

        //Datos encontrados. 
        return $this->response->setJSON([
          'success' => true,
          'message'=> 'Alignments obtenidos',
          'resumen' => $data
        ]);
      }
      public function getinforme4(){
        
        return view('dashboard/informe4');

      }
      public function getDataInforme4(){
        $this->response->setContentType('application/json');
        $reportePublisher = new ReportePublisher();
        $reporteRender = new ReporteRender();
        $data = [
          'publishers' => $reportePublisher->findAll(),
          'renders' => $reporteRender->findAll()
        ];

        if(!$data){
          return $this->response->setJSON([
            'success' => false,
            'message'=> 'No se encontraron generos',
            'resumen' => []
          ]);
        }

        //Datos encontrados. 
        return $this->response->setJSON([
          'success' => true,
          'message'=> 'Generos obtenidos',
          'resumen' => $data
        ]);
    }
    public function getDataInforme4Cache(){
        $this->response->setContentType('application/json');


        //Objecto de cache
        $cacheKey = 'resumen-gender';

        //Obtener los datos de la memoria cache
        $data = cache($cacheKey); 

        if($data == null){
          //No existe en cache. 
          $reporteRender = new ReporteRender();
          $data = $reporteRender->findAll();

          //Nueva memoria cache
          cache()->save($cacheKey, $data, 3600); 
        }

        if(!$data){
          return $this->response->setJSON([
            'success' => false,
            'message'=> 'No se encontraron superheroes',
            'resumen' => []
          ]);
        }

        //Datos encontrados. 
        return $this->response->setJSON([
          'success' => true,
          'message'=> 'Aligbnments obtenidos',
          'resumen' => $data
        ]);
      }
      public function getDataInforme5Cache(){
        $this->response->setContentType('application/json');
        $cacheKey = 'resumen-publisher';

        //Obtener los datos de la memoria cache
        $data = cache($cacheKey);

        if($data == null){
          //No existe en cache.
          $reportePublisher = new ReportePublisher();
          $data = $reportePublisher->findAll();

          //Nueva memoria cache
          cache()->save($cacheKey, $data, 3600);
        }

        if(!$data){
          return $this->response->setJSON([
            'success' => false,
            'message'=> 'No se encontraron superheroes',
            'resumen' => []
          ]);
        }

        //Datos encontrados.
        return $this->response->setJSON([
          'success' => true,
          'message'=> 'Aligbnments obtenidos',
          'resumen' => $data
        ]);
      }
    }