<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use DB;

class ProductoController extends Controller
{

    public function registrar($tipoProducto,$descripcion,$precio,$stock){
        try{
                $producto = Producto::insert(['tipoProducto'=>$tipoProducto,'descripcion'=>$descripcion, 'precio'=>$precio, 'stock'=>$stock]);
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

    public function mostrarProductos(){
        $producto = Producto::get();
        echo $producto;
   }

   public function existeProducto($tipoProducto){
    $existe = Producto::where('tipoProducto',$tipoProducto)->first();

            if($existe) {
                $arr = array('resultado' => "existe");
                echo json_encode($arr);
            } else {
                $arr = array('resultado' => "no existe");
                echo json_encode($arr);
            }
    }

    public function nohayProducto($idProducto){
        $producto = DB::select("
        SELECT idProducto, stock
        FROM producto
        WHERE stock = 0
        AND idProducto = ?
        ", [$idProducto]);

        if($producto) {
                    $arr = array('resultado' => "no hay");
                    echo json_encode($arr);
                } else {
                    $arr = array('resultado' => "si hay");
                    echo json_encode($arr);
                }
        }

   public function mostrarProducto($idProducto){
    try{
        $producto = Producto::where('idProducto',$idProducto)->first();
        echo $producto;
    } catch(\Illuminate\Database\QueryException $e){
        $errorCore = $e->getMessage();
        $arr = array('estado' => $errorCore);
        echo json_encode($arr);
    }
}

public function eliminarProducto($idProducto){
    try{
        $eliminar = DB::delete('delete from producto where idProducto = ?', [$idProducto]);
        if($eliminar == 1){
            $arr = array('resultado' => "eliminado");
            echo json_encode($arr);
        } else {
            $arr = array('resultado' => "no eliminado");
            echo json_encode($arr);
        }
    } catch(\Illuminate\Database\QueryException $e){
        $errorCore = $e->getMessage();
        $arr = array('resultado' => $errorCore);
        echo json_encode($arr);
    }
}

    public function updateP($tipoProducto,$descripcion,$precio,$idProducto){
    try{
        
        $actualizar = DB::update(
            'update producto set tipoProducto = ?,descripcion = ?, precio = ? 
             where idProducto = ?', 
        [$tipoProducto,$descripcion,$precio,$idProducto]);

            if ($actualizar != 1){
                $arr = array('resultado'=>'error');
                echo json_encode($arr);
            } else {
                $arr = array('resultado' => 'actualizado');
                echo json_encode($arr);
            }

        } catch(\Illuminate\Database\QueryException $e){
            $errorCore = $e->getMessage();
            $arr = array('estado' => $errorCore);
            echo json_encode($arr);
        }
    }

    public function mostrarTotal(){
        $producto = DB::table('producto')->sum('stock');
        echo $producto;
   }
}
