<?php
  include_once("clase_cliente.php");
  $cliente = NEW Cliente();
  echo '  <div class="container-fluid">

  ';
    $cliente->buscar_cliente($_GET['busqueda'],$_GET['fecha'],$_GET['trabajador']);
  echo '

  </div>';
?>
