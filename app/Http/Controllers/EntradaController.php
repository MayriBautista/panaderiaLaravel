<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entrada;
use Carbon\Carbon;
use App\EntradaProducto;
use DB;

class EntradaController extends Controller
{
    public function registrar($idProducto,$cantidad,$precio,$fecha,$total){
        try{

        $producto = Entrada::insert([
            'idProducto'=>$idProducto,
            'cantidad'=>$cantidad,
            'precio'=>$precio,
            'fecha'=>DB::raw('curdate()'),
            'total'=>$total
            ]);

            $sumarStock = DB::update('update producto set stock = stock + ? where idProducto = ?', [$cantidad,$idProducto]);
            if($producto == 1 && $sumarStock == 1){
                $arr = array('resultado' => "insertado");
                echo json_encode($arr);
            } else {
                $arr = array('resultado' => "no insertado");
                echo json_encode($arr);
            }     
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->getMessage();
            $arr = array('estado' => $errorCode);

            echo json_encode($arr);
        }

    }

    public function getEntradas($fecha) {
        $entrada = DB::select("
        SELECT producto.tipoProducto, entradas.precio, entradas.cantidad, entradas.total, entradas.fecha, entradas.idProducto, entradas.idEntrada
        FROM producto, entradas
        WHERE producto.idProducto = entradas.idProducto
        AND entradas.fecha = curdate()
        ", [$fecha]);

        echo json_encode($entrada);
    }

    public function mostrarEntradas(){
        $entrada = DB::select("
        SELECT producto.tipoProducto, entradas.precio, entradas.cantidad, entradas.total, entradas.fecha, entradas.idProducto, entradas.idEntrada
        FROM producto, entradas
        WHERE producto.idProducto = entradas.idProducto
        ");
        echo json_encode($entrada);
   }

    public function mostrarTotal(){
        $entrada = DB::table('entradas')->sum('total');
        echo $entrada;
   }

   public function updateE($cantidad,$precio,$fecha,$total,$idEntrada,$idProducto){
    try{
        
        $actualizar = DB::update(
            'update entradas set cantidad = ?, precio = ?, fecha = ?, total = ?, notas = ?
             where idEntrada = ?', 
        [$cantidad,$precio,$fecha,$total,$idEntrada]);
        $sumarStock = DB::update('update producto set stock = stock + ? where idProducto = ?', [$cantidad,$idProducto]);

            if($actualizar == 1 && $sumarStock == 1){
                $arr = array('resultado' => "actualizado");
                echo json_encode($arr);
            } else {
                $arr = array('resultado' => "no actualizado");
                echo json_encode($arr);
            }

        } catch(\Illuminate\Database\QueryException $e){
            $errorCore = $e->getMessage();
            $arr = array('estado' => $errorCore);
            echo json_encode($arr);
        }
    }

   public function eliminarEntrada($idEntrada,$cantidad,$idProducto){
    try{
        $eliminar = DB::delete('delete from entradas where idEntrada = ?', [$idEntrada]);
        $quintarStock = DB::update('update producto set stock = stock - ? where idProducto = ?', [$cantidad,$idProducto]);
            if($eliminar == 1 && $quintarStock == 1){
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
    
}