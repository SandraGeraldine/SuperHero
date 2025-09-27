<?php

namespace App\Models;
use CodeIgniter\Model;


class ReportePublisher extends Model{
  protected $table = "view_superhero_publisher";
  protected $returnType = "array";
  protected $useSoftDeletes = false;
  protected $allowedFields = [];
}