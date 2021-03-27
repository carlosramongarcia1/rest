<?php
	date_default_timezone_set('America/Mexico_City');
include_once("clase_inventario.php");
$inventario = NEW Inventario(0);
$inventario->guardar_producto($_POST['nombre'],$_POST['categoria'],$_POST['precio_venta'],$_POST['precio_compra'],$_POST['inventario'],$_POST['stock'],
$_POST['bodega_inventario'],$_POST['bodega_stock'],$_POST['clave']);
?>
