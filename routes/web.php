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
Route::get('mostrarEntradas', ['uses' => 'EntradaController@mostrarEntradas']);
Route::get('mostrarTotalE', ['uses' => 'EntradaController@mostrarTotal']);
Route::get('eliminarEntrada/{idEntrada}/{cantidad}/{idProducto}', ['uses' => 'EntradaController@eliminarEntrada']);
Route::get('updateEntrada/{cantidad}/{precio}/{fecha}/{total}/{notas}/{idEntrada}/{idProducto}', ['uses' => 'EntradaController@updateE']);

//PRODUCTOS
Route::get('registroProducto/{tipoProducto}/{descripcion}/{precio}/{stock}', ['uses' => 'ProductoController@registrar']);
Route::get('mostrarProductos', ['uses' => 'ProductoController@mostrarProductos']);
Route::get('mostrarProducto/{idProducto}', ['uses' => 'ProductoController@mostrarProducto']);
Route::get('eliminarProducto/{idProducto}', ['uses' => 'ProductoController@eliminarProducto']);
Route::get('existeProducto/{tipoProducto}', ['uses' => 'ProductoController@existeProducto']);
Route::get('updateProducto/{tipoProducto}/{descripcion}/{precio}/{idProducto}', ['uses' => 'ProductoController@updateP']);
Route::get('mostrarTotalP', ['uses' => 'ProductoController@mostrarTotal']);

//PEDIDOS
Route::get('registroPedido/{idProducto}/{hora}/{fecha}/{cantidad}/{precio}/{total}/{notas}/{estado}', ['uses' => 'PedidoController@insertarPedido']);
Route::get('mostrarPedidos', ['uses' => 'PedidoController@mostrarPedidos']);
Route::get('getPedidos/', ['uses' => 'PedidoController@getPedidos']);
Route::get('eliminarPedido/{idPedido}', ['uses' => 'PedidoController@eliminarPedido']);
Route::get('pedidoEntregado/{estado}/{idPedido}/{cantidad}/{idProducto}', ['uses' => 'PedidoController@pedidoEntregado']);
Route::get('updatePedido/{hora}/{fecha}/{cantidad}/{precio}/{total}/{notas}/{idPedido}', ['uses' => 'PedidoController@updatePedido']);

//GASTOS
Route::get('registroGasto/{idUsuario}/{fecha}/{total}/{descripcion}', ['uses' => 'GastoController@registrar']);
Route::get('mostrarGastos/{fecha}', ['uses' => 'GastoController@mostrarGastos']);
Route::get('getGasto', ['uses' => 'GastoController@mostrarG']);
Route::get('eliminarGasto/{idGasto}', ['uses' => 'GastoController@eliminarGasto']);
Route::get('updateGasto/{descripcion}/{total}/{idGasto}', ['uses' => 'GastoController@updateG']);
Route::get('mostrarTotalG', ['uses' => 'GastoController@mostrarTotal']);


//SALIDAS $idSalida,$idProducto,$idUsuario,$fecha,$cantidad,$precio,$totalSalida
Route::get('nuevaSalida/{idSalida}/{idProducto}/{idUsuario}/{fecha}/{cantidad}/{precio}/{totalSalida}',['uses'=> 'SalidaController@nuevaSalida']);

//VENTAS 
Route::get('nuevaVenta/{idVenta}/{idUsuario}/{fecha}/{total}',['uses'=> 'VentaController@nuevaVenta']);
Route::get('getVenta/{idVenta}', ['uses' => 'VentaController@getVenta']);
Route::get('getNewID', ['uses' => 'VentaController@getNewID']);
Route::get('ventasTotales', ['uses' => 'VentaController@ventasTotales']);
Route::get('registrarVentaP/{idVenta}/{idProducto}/{cantidad}/{precio}/{subtotal}',['uses'=> 'VentaController@registrarVentaP']);
Route::get('mostrarVenta/{idVenta}', ['uses' => 'VentaController@mostrarVenta']);
//public function eliminarSV($idSVenta,$cantidad,$idProducto){
Route::get('eliminarSV/{idVenta}/{cantidad}/{idProducto}', ['uses' => 'VentaController@eliminarSV']);
Route::get('mostrarTotalV', ['uses' => 'VentaController@mostrarTotal']);

?>