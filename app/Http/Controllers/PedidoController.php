<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use Carbon\Carbon;
use App\PedidoProducto;
use DB;

class PedidoController extends Controller
{
    public function insertarPedido($idProducto,$fecha1,$hora1,$cantidad,$totalPedido,$notas){
        try{
            $oldFecha = substr($fecha1, 0, -6);
            $fecha = date('Y-m-d', strtotime($oldFecha));
            $oldHora = substr($hora1, 0, -6);
            $hora = date('h:i A', strtotime($oldHora));

            $idPedido = DB::table('pedido')
                ->insertGetId([                    
                    'hora' => $hora,
                    'fecha' => $fecha,
                    'totalPedido' => $totalPedido
                ]);

            $PedProd = PedidoProducto::insert(['idPedido'=>$idPedido,'idProducto'=>$idProducto,'cantidad'=>$cantidad, 'notas'=>$notas]);
            $quintarStock = DB::update('update producto set stock = stock - ? where idProducto = ?', [$cantidad,$idProducto]);
        
            if($PedProd == 1 && $quintarStock == 1){
                $arr = array('resultado' => "insertado");
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

    public function registrar($idProducto,$hora,$fecha,$cantidad,$total,$notas){
        $fecha = Carbon::now()->toDateTimeString();
        try {
                $idPedido = DB::table('pedido')
                ->insertGetId([                    
                    'hora' => $hora,
                    'fecha' => $fecha,
                    'total' => $total
                ]);

            $PedProd = PedidoProducto::insert(['idPedido'=>$idPedido,'idProducto'=>$idProducto,'cantidad'=>$cantidad, 'notas'=>$notas]);
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

    public function mostrarPedidos(){
        $pedidos = DB::table('pedido')->distinct()
                    ->join('pedido_producto','pedido_producto.idPedido','=','pedido.idPedido')
                    ->join('producto','producto.idProducto','=','pedido_producto.idProducto')
                    ->select('pedido.idPedido', 'pedido.hora', 'pedido.fecha', 'pedido.totalPedido',
                    'producto.tipoProducto as producto', 
                    'pedido_producto.cantidad')
                    ->get();

                     echo $pedidos;
   }

    public function mostrarPedido($idPedido){
        try{
            $pedido = Pedido::where('idPedido',$idPedido)->first();
            echo $pedido;
        } catch(\Illuminate\Database\QueryException $e){
            $errorCore = $e->getMessage();
            $arr = array('estado' => $errorCore);
            echo json_encode($arr);
        }
    }
    
    public function eliminarPedido($idPedido){
        try{
            $eliminar = DB::delete('delete from pedido where idPedido = ?', [$idPedido]);
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
