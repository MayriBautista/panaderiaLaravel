<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'entrada';
    protected $primaryKey = 'idEntrada';
    public $timestamps = false;
}
