<?php
	date_default_timezone_set('America/Mexico_City');
include_once("clase_usuario.php");
$user= NEW Usuario(0);
$user->guardar_usuario($_POST['usuario'],$_POST['contrasena'],$_POST['nivel']);
?>
