<?php

namespace App\Models;
use CodeIgniter\Model;


class ReporteRender extends Model{
  protected $table = "view_superhero_gender";
  protected $returnType = "array";
  protected $useSoftDeletes = false;
  protected $allowedFields = [];
}

