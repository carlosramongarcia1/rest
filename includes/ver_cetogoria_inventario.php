<?php
	date_default_timezone_set('America/Mexico_City');
include_once("clase_inventario.php");
$categoria = NEW Categoria(0);
  echo ' <div class="container">
          <h2>Categorias Inventario</h2>';
          $categoria->mostrar();
  echo  '</div>';
?>
