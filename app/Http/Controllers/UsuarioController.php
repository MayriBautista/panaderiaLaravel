<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use DB;

class UsuarioController extends Controller
{
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
}
