<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use Carbon\Carbon;
use App\PedidoProducto;
use DB;

class PedidoController extends Controller
{
    public function registrar($producto,$hora,$fecha,$cantidad,$precio,$totalPedido,$notas){
        $fecha = Carbon::now()->toDateTimeString();
        try {
                $idPedido = DB::table('pedido')
                ->insertGetId([                    
                    'hora' => $hora,
                    'fecha' => $fecha,
                    'totalPedido' => $totalPedido
                ]);

            $PedProd = PedidoProducto::insert(['idPedido'=>$idPedido,'producto'=>$producto,'cantidad'=>$cantidad, 'precio'=>$precio, 'notas'=>$notas]);
                if($PedProd == 1){
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
