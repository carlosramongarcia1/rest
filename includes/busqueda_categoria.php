<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once("clase_inventario.php");
  $inventario = NEW Inventario();
  //$hab=NEW  habitacion($_GET['hab_id']);
  echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="reiniciarintervalo()">&times;</button>
        <h2 class="modal-title">Categorias</h2>
      </div>';
      echo '<div class="container-fluid">';
      echo '</br>';
      echo '<div class="row">

        ';

        $inventario->mostar_producto_categoria($_GET['categoria']);
      echo '
      </div>';
      echo '</div>';
  echo '<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>';
?>
