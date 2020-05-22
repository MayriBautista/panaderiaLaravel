<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use DB;

class ProductoController extends Controller
{
    public function registrar($tipoProducto,$precio,$descripcion){
        try{
                $producto = Producto::insert(['tipoProducto'=>$tipoProducto, 'precio'=>$precio,'descripcion'=>$descripcion]);

                //Si fue insertada nos regresa el mensaje "insertado"
                if($producto == 1){
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
