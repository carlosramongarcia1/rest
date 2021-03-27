<?php
  include_once('clase_ticket.php');
  include_once("clase_inventario.php");
  $producto = NEW Producto ($_GET['id']);
  $ticket = NEW Ticket();
  $inven = NEW Inventario();

    $ticket->guardar_concepto(0,$producto->nombre,1,$producto->precio,$producto->precio,0,$producto->id);
    $inven->mostrar_comanda();
?>
