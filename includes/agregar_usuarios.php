<?php
date_default_timezone_set('America/Mexico_City');
echo '
  <div class="container texto_entrada">
      <h2>Agregar Usuario</h2>
      <div class="form-group">
      <label for="usuario">
        Usuario:
      </label>
      <input class="form-control" type="text"  id="usuario"  placeholder="Usuario"/>
      </div>
      <div class="form-group">
        <label for="contraseña">
          Contraseña:
        </label>
        <input class="form-control" type="password" id="contrasena" placeholder="Contraseña"/>
      </div>
      <div class="form-group">
        <label for="precio_compra">
          Contraseña:
        </label>
        <input class="form-control" type="password" id="recontrasena" placeholder="Contraseña"/>
      </div>
      <div class="form-group">
      <label for="categoria">Categoria</label>
        <select class="form-control" id="nivel">
          <option value="1">Administrador</option>
          <option value="2">Cajer@</option>
          
        </select>
      </div>
      <input type="submit" class="btn btn-block btn-default btn-lg" value="Guardar" onclick="guardar_usuario()">
  </div> </br>';
?>
