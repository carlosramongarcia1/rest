<?php
  include_once('clase_cliente.php');
  $cliente = NEW Cliente();
  $cliente->elimiar_cita($_GET['id']);
  echo '<div class="alert alert-danger">
  <strong>Cita eliminada!</strong>
</div>';
?>
