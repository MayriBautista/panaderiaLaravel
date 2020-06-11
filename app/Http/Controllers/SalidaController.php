<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salida;
use Carbon\Carbon;
use App\SalidaProducto;
use DB;

class SalidaController extends Controller
{

    public function registrar($fecha,$idProducto,$cantidad,$precio,$totalSalida){
        try {
                $idSalida = DB::table('salida')
                ->insertGetId([      
                    'fecha' => $fecha,
                    'totalSalida' => $totalSalida
                ]);

            $salida = SalidaProducto::insert(['idSalida'=>$idSalida,'idProducto'=>$idProducto,'cantidad'=>$cantidad, 'precio'=>$precio]);
                if($salida == 1){
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

    public function nuevaSalida($idSalida,$idProducto,$idUsuario,$fecha,$cantidad,$precio,$total){
        try {
            $existe = Salida::where('idSalida',$idSalida)->first();

            if(empty($existe)) {
                $salida = Salida::insert([
                    'idSalida' => $idSalida,
                    'idUsuario' => $idUsuario,
                    'fecha' => DB::raw('curdate()'),
                    'total' => 0
                ]);
            }
            $salidaProducto = DB::insert('insert into salida_producto (idSalida, idProducto, cantidad, precio) values (?, ?, ?, ?)', 
            [$idSalida, $idProducto, $cantidad, $precio]);

            $actualizarTotal = DB::update('update salida set total = total + ? where idSalida = ?', [$total, $idSalida]);
            $total = DB::table('salida')->where('idSalida',$idSalida)->sum('total');
            $quitarEntrada = DB::update('update entra set total = total - ? where idProducto = ?', [$cantidad,$idProducto]);

                if($salidaProducto == 1 && $quitarEntrada == 1 && $actualizarTotal == 1) {
                    $arr = array('resultado' => "insertado",
                'total'=>$total);
                    echo json_encode($arr);
                } else {
                    $arr = array('resultado' => "no insertado");
                    echo json_encode($arr);
                }

        } catch(\Illuminate\Database\QueryException $e){
            $errorCore = $e->getMessage();
            $arr = array('resultado' => $errorCore);
            echo json_encode($arr);
        }
    }
}
