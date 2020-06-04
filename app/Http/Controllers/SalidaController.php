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
}
