<?php
	date_default_timezone_set('America/Mexico_City');
	include ("clase_gastos.php");
	$gasto = NEW Gastos();
  $gasto->guardar_gasto($_POST['id'],$_POST['nombre'],$_POST['total']);          
?>
