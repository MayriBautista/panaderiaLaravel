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

    public function mostrarTotal($fecha1){
        $oldFecha = substr($fecha1, 0, -6);
            $fecha = date('Y-m-d', strtotime($oldFecha));
        $entrada = DB::table('entradas')->where('fecha',$fecha)->sum('total');
        echo $entrada;
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