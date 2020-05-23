<?php
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

Route::get('/', function () {
    return view('welcome');
});

//USUARIOS
Route::get('login/{email}/{contra}', ['uses' => 'UsuarioController@login']);
Route::get('registro/{nombre}/{telefono}/{contra}/{tipoUsuario}', ['uses' => 'UsuarioController@registrar']);

//ENTRADAS
Route::get('registroEntrada/{cantidad}/{producto}/{precio}/{totalEntrada}', ['uses' => 'EntradaController@registrar']);

//PRODUCTOS
Route::get('registroProducto/{tipoProducto}/{precio}/{descripcion}', ['uses' => 'ProductoController@registrar']);

//PEDIDOS
Route::get('registroPedido/{producto}/{hora}/{fecha}/{cantidad}/{precio}/{totalPedido}/{notas}', ['uses' => 'PedidoController@registrar']);