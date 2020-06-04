<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entrada;
use Carbon\Carbon;
use App\EntradaProducto;
use DB;

class EntradaController extends Controller
{
    public function registrar($fecha,$idProducto,$cantidad,$precio,$totalEntrada){
        $fecha = Carbon::now()->toDateTimeString();
        try {
            $idEntrada = DB::table('entra')
            ->insertGetId([      
                'fecha' => $fecha,
                'totalEntrada' => $totalEntrada
            ]);

        $entrada = EntradaProducto::insert(['idEntrada'=>$idEntrada,'idProducto'=>$idProducto,'cantidad'=>$cantidad, 'precio'=>$precio]);
            if($entrada == 1){
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