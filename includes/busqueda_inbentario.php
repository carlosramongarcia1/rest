<?php
	date_default_timezone_set('America/Mexico_City');
	include_once("clase_inventario.php");
	$inventario = NEW Inventario(0);
	$inventario->buscar($_GET['busqueda']);
?>