<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_usuario.php');
  $user = NEW Usuario($_GET['trabajador']);

  echo '<div class="modal-header">
        <h2>Agendar Cita  </h2>
        <p>el dia '.date('Y-m-d H:i',$_GET['fecha']).' con '.$user->nombre.'</p>
      </div>';
      echo '<div class="container-fluid">';
      echo '</br>';
      echo '
      <div class="row">
      <div class="form-group">
        <label for="titulo" class="control-label col-sm-2">Titulo</label>
        <div class="col-sm-4 ">
          <input class="form-control" type="text" id="titulo"  placeholder="Titulo" >
        </div>
        <label for="descripcion" class="control-label col-sm-2">Descripción</label>
        <div class="col-sm-4 ">
          <input class="form-control" type="text" id="descripcion"  placeholder="Descripcion" >
        </div>
      </div>
      </br>
      </br>
        <div class="form-group">
          <label for="cliente" class="control-label col-sm-2">Cliente</label>
          <div class="col-sm-4 ">
            <input class="form-control" type="text" id="cliente"  placeholder="Cliente" onkeyup="buscar_cliente('.$_GET['fecha'].','.$_GET['trabajador'].')">
          </div>
          <label for="cantidad_tiempo" class="control-label col-sm-2">Tiempo</label>
          <div class="col-sm-4">
            <select class="form-control" id="cantidad_tiempo">
              <option value="1">1/2 hora</option>
              <option value="2">1 hora</option>
              <option value="3">1 1/2 horas</option>
              <option value="4">2 horas</option>
              <option value="5">2 1/2 horas</option>
              <option value="6">3 horas</option>
              <option value="7">3 1/2 horas</option>
              <option value="8">4 horas</option>
            </select>
          </div>
        </div>


      </div>
      </br>
      <div class="row" id="buscar_cliente">


      </div>
      </br>
      ';

      echo '</div>';
?>
