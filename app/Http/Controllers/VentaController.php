<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;
use Carbon\Carbon;
use App\VentaProducto;
use DB;

class VentaController extends Controller
{
    public function nuevaVenta($idVenta,$idUsuario,$fecha,$total){
        try {
            $existe = Venta::where('idVenta',$idVenta)->first();

            if(empty($existe)) {
                $venta = Venta::insert([
                    'idVenta' => $idVenta,
                    'idUsuario' => $idUsuario,
                    'fecha' => DB::raw('curdate()'),
                    'total' => 0
                ]);
            }

            $total = DB::table('venta_producto')->where('idVenta',$idVenta)->sum('subtotal');
            $actualizarTotal = DB::update('update venta set total = total + ? where idVenta = ?', [$total, $idVenta]);            

                if($actualizarTotal == 1) {
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

    public function getVenta($idVenta) {
        $venta = DB::select("
        SELECT producto.tipoProducto, producto.descripcion, producto.precio,venta_producto.cantidad, venta_producto.subtotal, venta_producto.idVenta, venta_producto.idSVenta
        FROM producto, venta_producto
        WHERE producto.idProducto = venta_producto.idProducto
        AND venta_producto.idVenta = ?
        ", [$idVenta]);

        echo json_encode($venta);
    }

    public function ventasTotales($fecha) {
        $venta = DB::select("
        SELECT usuario.nombre, venta.total, venta.fecha, venta.idUsuario, venta.idVenta
        FROM usuario, venta
        WHERE usuario.idUsuario = venta.idUsuario
        AND venta.fecha = curdate()
        ", [$fecha]);

        echo json_encode($venta);
    }

    public function eliminarSV($idSVenta,$cantidad,$idProducto){
        try{
            $eliminar = DB::delete('delete from venta_producto where idSVenta = ?', [$idSVenta]);
            $restarStock = DB::update('update producto set stock = stock - ? where idProducto = ?', [$cantidad,$idProducto]);
            if($eliminar == 1 && $restarStock == 1){
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

    public function registrarVentaP($idVenta,$idProducto,$cantidad,$precio,$subtotal){
        try{
                $producto = VentaProducto::insert(['idVenta'=>$idVenta, 'idProducto'=>$idProducto,'cantidad'=>$cantidad,'precio'=>$precio,'subtotal'=>$subtotal]);
                $quitarStock = DB::update('update producto set stock = stock - ? where idProducto = ?', [$cantidad,$idProducto]);
                if($producto == 1 && $quitarStock){
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

    public function getNewID(){
        try{
            $idVenta = Venta::latest('idVenta')->pluck('idVenta')->first();
            $arr = array('idVenta' => $idVenta+1);
            echo json_encode($arr);
        } catch(\Illuminate\Database\QueryException $e){
            $errorCore = $e->getMessage();
            $arr = array('resultado' => $errorCore);
            echo json_encode($arr);
        }
    }

    public function obtenerID(){
        try{
            $idVenta = Venta::latest('idVenta')->pluck('idVenta')->first();
            $arr = array('idVenta' => $idVenta+1);
            echo json_encode($arr);
        } catch(\Illuminate\Database\QueryException $e){
            $errorCore = $e->getMessage();
            $arr = array('resultado' => $errorCore);
            echo json_encode($arr);
        }
    }

}