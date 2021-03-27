<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $categoria = NEW Categoria(0);
  $categoria->guardar($_POST['categoria']);
?>
