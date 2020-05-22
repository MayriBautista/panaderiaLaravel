<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entrada;
use DB;

class EntradaController extends Controller
{
    public function registrar($cantidad,$producto,$precio,$totalEntrada){
        try{
                $entrada = Entrada::insert(['cantidad'=>$cantidad, 'producto'=>$producto,'precio'=>$precio,'totalEntrada'=>$totalEntrada]);

                //Si fue insertada nos regresa el mensaje "insertado"
                if($entrada == 1){
                   $arr = array('resultado' => "insertado");
                   echo json_encode($arr);
                } else {
                   $arr = array('resultado' => "no insertado");
                   echo json_encode($arr);
                }          
        } catch(\Illuminate\Database\QueryException $e){
            $errorCore = $e->getMessage();
            $arr = array('estado' => $errorCore);
            echo json_encode($arr);
        }
    }
}