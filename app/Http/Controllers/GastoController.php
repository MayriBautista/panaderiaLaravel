<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gasto;
use DB;

class GastoController extends Controller
{
    public function registrar($idUsuario,$fecha1,$total,$descripcion){
        try{
            $oldFecha = substr($fecha1, 0, -6);
            $fecha = date('Y-m-d', strtotime($oldFecha));

                $gasto = Gasto::insert(['idUsuario'=>$idUsuario, 'fecha'=>$fecha,'total'=>$total,'descripcion'=>$descripcion]);

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
   
   public function mostrarG($fecha){
        $gasto = DB::select("
        SELECT usuario.nombre, gasto.descripcion, gasto.total, gasto.fecha, gasto.idusuario, gasto.idGasto
        FROM usuario, gasto
        WHERE usuario.idUsuario = gasto.idUsuario
        AND gasto.fecha = curdate()
        ", [$fecha]);

        echo json_encode($gasto);
   }

   public function mostrarTotal($fecha1){
        $oldFecha = substr($fecha1, 0, -6);
            $fecha = date('Y-m-d', strtotime($oldFecha));
        $gasto = DB::table('gasto')->where('fecha',$fecha)->sum('total');
        echo $gasto;
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

    public function getGasto($fecha) {
        $gasto = DB::select("
        SELECT usuario.nombre, gasto.descripcion, gasto.total, gasto.fecha, gasto.idUsuario, gasto.idGasto
        FROM usuario, gasto
        WHERE usuario.idUsuario = gasto.idUsuario
        AND gasto.fecha = curdate()
        ", [$fecha]);

        echo json_encode($gasto);
    }

    public function updateG($descripcion,$total,$idGasto){
        try{
            
            $actualizar = DB::update(
                'update gasto set descripcion = ?, total = ? 
                 where idGasto = ?', 
            [$descripcion,$total,$idGasto]);
    
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

}
