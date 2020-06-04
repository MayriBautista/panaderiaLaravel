<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $table = 'gasto';
    protected $primaryKey = 'idGasto';
    public $timestamps = false;
}
