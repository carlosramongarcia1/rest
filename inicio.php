<?php
  session_start();

  echo '  <!DOCTYPE html>
      <html lang="es">
          <head>
            <title>ABCloud</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
            <link rel="icon" href="favicon.ico" type="image/x-icon">
            <script src="js/live.js"></script>
            <script src="js/jquery.js"></script>
            <script src="bootstrap/js/bootstrap.min.js"></script>
            <script src="js/events.js"></script>
            <link rel=stylesheet href="bootstrap/css/bootstrap.min.css" type="text/css">
            <link rel=stylesheet href="styles/estilos.css" type="text/css">

          </head>
    <body onload="sabernosession()">
      <div class="menu"></div>
      <div id="area_trabajo" class="container-fluid">
      

      </div>
      <!-- Modal -->
              <div id="caja_herramientas" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                  <!-- Modal content-->
                  <div class="modal-content" id="mostrar_herramientas">



                  </div>

                </div>
              </div>
    </body>
  ';


?>
