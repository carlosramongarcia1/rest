<?php
  include_once("clase_inventario.php");
  $inventario = NEW Inventario();
  //echo 'borrar_comanda';
  $inventario->borrar_comanda($_GET['id']);
  $inventario->mostrar_comanda();
?>
