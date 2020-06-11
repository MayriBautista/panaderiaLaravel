<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use DB;

class UsuarioController extends Controller
{
    public function login($nombre, $contra){
        try{
           $uc = new UsuarioController;
            $nombreExiste = $uc->comprobarNombre($nombre);
                $usuario = Usuario::where('contrasena','=',$contra)->where('nombre','=',$nombre)->first();
                if(empty($usuario)){
                    if($nombreExiste){
                        $arr = array('idUsuario'=> -2);
                        echo json_encode($arr);
                    } else {
                        $arr = array('idUsuario'=> 0);
                        echo json_encode($arr);
                    }
                } else {
                    echo $usuario;
                }
        } catch(\Illuminate\Database\QueryException $e){
            $errorCore = $e->getMessage();
            $arr = array('estado' => $errorCore);
            echo json_encode($arr);
        }
    }

    public function nombreExiste($nombre){
        $nombre = Usuario::select('nombre')->where('nombre','=',$nombre)->first();
        if($nombre != null){
            return true;
        }
    }

    public function comprobarNombre($nombre){
        $ucont = new UsuarioController;
        if( $ucont->nombreExiste($nombre)){
            return true;
        } 
    }

    public function registrar($nombre,$telefono,$contra,$tipoUsuario){
        try{
                $usuario = Usuario::insert(['nombre'=>$nombre, 'telefono'=>$telefono,'contrasena'=>$contra,'tipoUsuario'=>$tipoUsuario]);

                //Si fue insertada nos regresa el mensaje "insertado"
                if($usuario == 1){
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

    public function mostrarUsuarios(){
        $usuario = Usuario::get();
        echo $usuario;
   }

   public function eliminarUsuario($idUsuario){
    try{
        $eliminar = DB::delete('delete from usuario where idUsuario = ?', [$idUsuario]);
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

public function updateU($nombre,$telefono,$contrasena,$tipoUsuario,$idUsuario){
    try{
        
        $actualizar = DB::update('update usuario set nombre = ?,telefono = ?, contrasena = ?, tipoUsuario = ? where idUsuario = ?', [$nombre,$telefono,$contrasena,$tipoUsuario,$idUsuario]);
        //echo $actualizar;

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
