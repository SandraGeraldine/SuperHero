<?php

namespace App\Models;
use CodeIgniter\Model;

class Alignment extends Model{
  protected $table = "alignment";
  protected $allowedFields = ['id','alignment'];
}