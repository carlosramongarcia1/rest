<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  $user= NEW Usuario(0);
  $user->borrar_usuario($_POST['id']);
?>
