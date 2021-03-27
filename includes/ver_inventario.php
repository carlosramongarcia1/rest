<?php
	date_default_timezone_set('America/Mexico_City');
include_once("clase_inventario.php");
$inventario = NEW Inventario(0);
  echo ' <div class="container-fluid">
          <h2>Inventario</h2>';
          $inventario->mostrar();
  echo  '</div>';
?>
