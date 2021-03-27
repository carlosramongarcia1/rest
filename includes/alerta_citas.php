<?php
  include_once("clase_cliente.php");
  $cliente = NEW Cliente();
  $alerta_cita = $cliente->cantidad_citas();
  echo $alerta_cita;
?>
