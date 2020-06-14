<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pedido;
use Carbon\Carbon;
use App\PedidoProducto;
use DB;

class PedidoController extends Controller
{
    public function insertarPedido($idProducto,$hora1,$fecha1,$cantidad,$precio,$total,$notas,$estado){
        try{
            $oldFecha = substr($fecha1, 0, -6);
            $fecha = date('Y-m-d', strtotime($oldFecha));
            $oldHora = substr($hora1, 0, -6);
            $hora = date('h:i A', strtotime($oldHora));

            $idPedido = DB::table('pedido')
                ->insertGetId([                    
                    'hora' => $hora,
                    'fecha' => $fecha,
                    'total' => $total,
                    'estado' => $estado
                ]);

            $PedProd = PedidoProducto::insert(['idPedido'=>$idPedido,'idProducto'=>$idProducto,'cantidad'=>$cantidad,'precio'=>$precio, 'notas'=>$notas]);
            
            if($PedProd == 1){
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
        $pedido = DB::select("
        SELECT producto.tipoProducto, producto.precio, pedido.fecha, pedido.hora, pedido.total, pedido.estado, pedido_producto.cantidad, pedido_producto.notas, pedido_producto.idProducto, pedido.idPedido
        FROM producto, pedido, pedido_producto
        WHERE pedido_producto.idPedido = pedido.idPedido
        AND producto.idProducto = pedido_producto.idProducto");

                    echo json_encode($pedido);
   }

   public function getPedidos($fecha){
        $pedido = DB::select("
        SELECT producto.tipoProducto, producto.precio, pedido.fecha, pedido.hora, pedido.estado, pedido.total, pedido_producto.cantidad, pedido_producto.precio, pedido_producto.notas, pedido_producto.idProducto, pedido.idPedido
        FROM producto, pedido, pedido_producto
        WHERE pedido_producto.idPedido = pedido.idPedido
        AND producto.idProducto = pedido_producto.idProducto
        AND pedido.fecha = curdate()
        ", [$fecha]);

        echo json_encode($pedido);
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

    public function pedidoEntregado($estado,$idPedido,$cantidad,$idProducto){
        try{
            $actualizar = DB::update(
                'update pedido set estado = ?
                 where idPedido = ?', 
            [$estado,$idPedido]);

            $quitarStock = DB::update('update producto set stock = stock - ? where idProducto = ?', [$cantidad,$idProducto]);
                if($actualizar == 1 && $quitarStock == 1){
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

        public function updatePedido($hora,$fecha,$cantidad,$precio,$total,$notas,$idPedido){
            try{
                $actualizar = DB::update(
                    'update pedido,pedido_producto 
                     set pedido.hora = ?, pedido.fecha = ?, pedido.total = ?,
                     pedido_producto.cantidad = ?, pedido_producto.precio = ?, pedido_producto.notas = ?
                     where pedido.idPedido = pedido_producto.idPedido
                     and pedido.idPedido = ?', 
                [$hora,$fecha,$cantidad,$precio,$total,$notas,$idPedido]);

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
