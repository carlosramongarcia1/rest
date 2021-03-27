<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
  session_start();
  include_once('includes/clase_configuracion.php');
  $config = NEW Configuracion();
  $timepo = time();
  $activo= $config->activacion- $timepo;
  echo '
    <!DOCTYPE html>
      <html lang="es">
          <head>
            <title>ABCloud</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta charset="utf-8">
            <meta http-equiv="Expires" content="0">
            <meta http-equiv="Last-Modified" content="0">
            <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
            <meta http-equiv="Pragma" content="no-cache">
            <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
            <link rel="icon" href="favicon.ico" type="image/x-icon">
            <link rel=stylesheet href="bootstrap/css/bootstrap.min.css" type="text/css">
            <link rel=stylesheet href="styles/estilos.css" type="text/css">
            <script src="js/live.js"></script>
            <script src="js/jquery.js"></script>
            <script src="bootstrap/js/bootstrap.min.js"></script>
            <script src="js/events.js"></script>
          </head>
    <body onload="sabersession()">
      <header class="titulo">
        <div class="container">
          <h1>ABCloud <img src="images/nuve.png"></h1>
        </div>
      </header>
      </br>';
      if($activo>0){
        echo '<div class="container">
        <form>
          <div class="form-group texto_entrada">
          <label for="user">
            Usuario:
          </label>
          <input class="form-control" type="text"  id="user"  placeholder="Usuario"/>
        </div>
          <div class="form-group texto_entrada">
            <label for=""pass">
              Contraseña:
            </label>
            <input class="form-control" type="password" id="pass" placeholder="Contraseña"/>
          </div>
          <button class="btn btn-block btn-default btn-lg" name="login" id="login">
            <span class="glyphicon glyphicon-user"></span> Iniciar sesión
          </button>
        </form>
        </br>
        </br>
        </div>
          <div class="container "  id="renglon_entrada_mensaje">';
            if($activo<518400){
              echo '<div class="alert alert-warning">
                <strong>El uso del sistema vencera el dia '.date("d/m/y ",$config->activacion ).'</strong> Contacte a su proveedor.
              </div>';
            }
          echo'</div>';
      }else{
        echo '<div class="container">
        <form>
          <div class="form-group texto_entrada">
          <label for="user">
            Usuario:
          </label>
          <input class="form-control" type="text"  id="user"  placeholder="Usuario" disabled />
        </div>
          <div class="form-group texto_entrada">
            <label for=""pass">
              Contraseña:
            </label>
            <input class="form-control" type="password" id="pass" placeholder="Contraseña" disabled />
          </div>
          <button class="btn btn-block btn-default btn-lg" name="login" id="login" disabled>
            <span class="glyphicon glyphicon-user"></span> Iniciar sesión
          </button>
        </form>
        </br>
        </br>
        </div>
          <div class="container "  id="renglon_entrada_mensaje">
          <div class="alert alert-danger">
            <strong>Sistema deshabilitado </strong> Contacte a su proveedor.
          </div>
          </div>';
      }

  echo '  </body>
  ';


?>
