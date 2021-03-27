<?php
  echo '
    <div class="container-fluid">
      <div class="row">
        <div class="form-group">
          <label for="telefono" class="control-label col-sm-2">Telefono</label>
          <div class="col-sm-4 ">
            <input class="form-control" type="text" id="telefono"  placeholder="Telefono" >
          </div>
          <label for="email" class="control-label col-sm-2">E-Mail</label>
          <div class="col-sm-4 ">
            <input class="form-control" type="text" id="email"  placeholder="Correo electronico" >
          </div>
        </div>
      </div>

    </div>
    </br>
    </br>
    <div class="container-fluid">
      <div class="row">
        <div class="form-group">

          <div class="col-sm-8 ">

          </div>

          <div class="col-sm-4 ">
            <button type="button" class="btn btn-success btn-block" onclick="guardar_agendar('.$_GET['tiempo'].','.$_GET['trabajador'].')">Guardar y Agendar</button>
          </div>
        </div>
      </div>

    </div>
        ';
?>
