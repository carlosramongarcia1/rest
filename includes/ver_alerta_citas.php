<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cliente.php");
  $cliente = NEW Cliente();
  echo '
  <div class="panel panel-success">
    <div class="panel-heading"><h3>Citas del dia  </h3> </div>
    <div class="row">
    </br>


    <div class="panel-body">
      <div class="container-fluid">
        <div class="row">';
        $cliente->citas_restantes();
        echo '</div>
        </div>
      </div>
    </div>
  ';
?>
