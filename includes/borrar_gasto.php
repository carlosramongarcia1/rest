<?php
	date_default_timezone_set('America/Mexico_City');
	include ("clase_gastos.php");
	$gasto = NEW Gastos();
  $gasto->borrar_gasto($_POST['id']);          
?>
