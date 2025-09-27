<?php

namespace App\Models;
use CodeIgniter\Model;

class Race extends Model{
  protected $table = "race";
  protected $allowedFields = ['id','race'];
}