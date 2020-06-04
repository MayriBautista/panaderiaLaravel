<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gasto;
use DB;

class GastoController extends Controller
{
    public function registrar($idUsuario,$fecha1,$totalGasto,$descripcion){
        try{
            $oldFecha = substr($fecha1, 0, -6);
            $fecha = date('Y-m-d', strtotime($oldFecha));

                $gasto = Gasto::insert(['idUsuario'=>$idUsuario, 'fecha'=>$fecha,'totalGasto'=>$totalGasto,'descripcion'=>$descripcion]);

                if($gasto == 1){
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

    public function mostrarGastos(){
        $gasto = Gasto::get();
        echo $gasto;
   }
   
   public function mostrarG(){
        $gastos = DB::table('gasto')->distinct()
                    ->join('usuario','usuario.idUsuario','=','gasto.idUsuario')
                    ->select('gasto.idGasto', 'gasto.fecha', 'gasto.descripcion', 'gasto.totalGasto',
                    'usuario.nombre as usuario')
                    ->get();

                     echo $gastos;
   }

   public function eliminarGasto($idGasto){
    try{
        $eliminar = DB::delete('delete from gasto where idGasto = ?', [$idGasto]);
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

}
