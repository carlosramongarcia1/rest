<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario = NEW Inventario();
  //$hab=NEW  habitacion($_GET['hab_id']);
  echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Herraminetas</h2>
      </div>';
      echo '<div class="container-fluid">';
      echo '</br>';
      $inventario->mostar_info_comanda($_GET['comanda']);

      echo '</br>
      <div class="row">
      <div class="btn-group btn-group-justified">
        <a href="#" class="btn btn-primary" data-dismiss="modal" onclick="agregar_comanda('.$_GET['comanda'].')">Agregar</a>
        <a href="#" class="btn btn-danger" data-dismiss="modal" onclick="borrar_comanda('.$_GET['comanda'].')">Borrar</a>

      </div>
      </div>
      </div>';
  echo '<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>';
?>
