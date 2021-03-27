<?php
  date_default_timezone_set('America/Mexico_City');
include_once("clase_inventario.php");
$inventario = NEW Inventario(0);
  echo ' <div class="container-fluid">

          <div class="row">
          <h2>Surtir Inventario</h2>
           <div class="col-sm-8">
          ';
          $inventario->mostrar_surtir();

  echo  '
      </div>
      <div class="row">
       <div class="col-sm-4">
      ';
          $inventario->mostrar_a_surtir();
      echo '
    </div>';
?>
