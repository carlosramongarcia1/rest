<?php
	date_default_timezone_set('America/Mexico_City');
	include ("informacion.php");

	$usuario =$_POST["usuario"];
	$password =md5($_POST["password"]); 
	$saber = NEW Informacion();
	$id=$saber->evaluarEntrada($usuario ,$password);
	echo $id;
?>
