<?php
  include_once("clase_inventario.php");
  $inventario = NEW Inventario();
  //echo 'borrar_comanda';
  $inventario->agregar_a_comanda($_GET['id']);
  $inventario->mostrar_comanda();
?>
