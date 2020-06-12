<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get');
header("Access-Control-Max-Age", "3600");
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Access-Control-Allow-Credentials", "true");


Route::get('/', function () {
    return view('welcome');
});

//USUARIOS
Route::get('login/{nombre}/{contra}', ['uses' => 'UsuarioController@login']);
Route::get('registro/{nombre}/{telefono}/{contra}/{tipoUsuario}', ['uses' => 'UsuarioController@registrar']);
Route::get('mostrarUsuarios', ['uses' => 'UsuarioController@mostrarUsuarios']);
Route::get('eliminarUsuario/{idUsuario}', ['uses' => 'UsuarioController@eliminarUsuario']);
Route::get('updateUsuario/{nombre}/{telefono}/{contrasena}/{tipoUsuario}/{idUsuario}', ['uses' => 'UsuarioController@updateU']);

//ENTRADAS $idProducto,$cantidad,$precio,$fecha,$total
Route::get('registroEntrada/{idProducto}/{cantidad}/{precio}/{fecha}/{total}', ['uses' => 'EntradaController@registrar']);
Route::get('getEntradas/{fecha}', ['uses' => 'EntradaController@getEntradas']);
Route::get('mostrarTotal/{fecha}', ['uses' => 'EntradaController@mostrarTotal']);
Route::get('eliminarEntrada/{idEntrada}/{cantidad}/{idProducto}', ['uses' => 'EntradaController@eliminarEntrada']);

//PRODUCTOS
Route::get('registroProducto/{tipoProducto}/{descripcion}/{precio}/{stock}', ['uses' => 'ProductoController@registrar']);
Route::get('mostrarProductos', ['uses' => 'ProductoController@mostrarProductos']);
Route::get('mostrarProducto/{idProducto}', ['uses' => 'ProductoController@mostrarProducto']);
Route::get('eliminarProducto/{idProducto}', ['uses' => 'ProductoController@eliminarProducto']);
Route::get('existeProducto/{tipoProducto}', ['uses' => 'ProductoController@existeProducto']);
Route::get('updateProducto/{tipoProducto}/{descripcion}/{precio}/{idProducto}', ['uses' => 'ProductoController@updateP']);

//PEDIDOS
Route::get('registroPedido/{idProducto}/{hora}/{fecha}/{cantidad}/{precio}/{total}/{notas}', ['uses' => 'PedidoController@insertarPedido']);
Route::get('mostrarPedidos', ['uses' => 'PedidoController@mostrarPedidos']);
Route::get('eliminarPedido/{idPedido}', ['uses' => 'PedidoController@eliminarPedido']);

//GASTOS
Route::get('registroGasto/{idUsuario}/{fecha}/{total}/{descripcion}', ['uses' => 'GastoController@registrar']);
Route::get('mostrarGastos', ['uses' => 'GastoController@mostrarGastos']);
Route::get('getGasto/{fecha}', ['uses' => 'GastoController@getGasto']);
Route::get('mostrarG', ['uses' => 'GastoController@mostrarG']);
Route::get('eliminarGasto/{idGasto}', ['uses' => 'GastoController@eliminarGasto']);
Route::get('updateGasto/{descripcion}/{idUsuario}/{total}/{idGasto}', ['uses' => 'GastoController@updateG']);
Route::get('mostrarTotalG/{fecha}', ['uses' => 'GastoController@mostrarTotal']);


//SALIDAS $idSalida,$idProducto,$idUsuario,$fecha,$cantidad,$precio,$totalSalida
Route::get('nuevaSalida/{idSalida}/{idProducto}/{idUsuario}/{fecha}/{cantidad}/{precio}/{totalSalida}',['uses'=> 'SalidaController@nuevaSalida']);

//VENTAS $idVenta,$idProducto,$idUsuario,$fecha,$cantidad,$precio,$total
Route::get('nuevaVenta/{idVenta}/{idUsuario}/{fecha}/{total}',['uses'=> 'VentaController@nuevaVenta']);
Route::get('getVenta/{idVenta}', ['uses' => 'VentaController@getVenta']);
Route::get('getNewID', ['uses' => 'VentaController@getNewID']);
//registrarVentaP($idVenta,$idProducto,$cantidad,$precio
Route::get('registrarVentaP/{idVenta}/{idProducto}/{cantidad}/{precio}/{subtotal}',['uses'=> 'VentaController@registrarVentaP']);
Route::get('mostrarVenta/{idVenta}', ['uses' => 'VentaController@mostrarVenta']);

?>