<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  include_once("clase_cliente.php");
  include_once("clase_configuracion.php");
  $cliente = NEW Cliente();
  $confi=NEW Configuracion();
  $user = NEW Usuario($_GET['id']);
  $alerta_cita = $cliente->cantidad_citas();
 	echo '
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="inicio.php"><span class="glyphicon  glyphicon-cloud"></span> '.$confi->nombre.' </a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
        ';
          if($user->nivel<=2){
            echo '
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Usuario <span class="caret"></span></a>
              <ul class="dropdown-menu">
              ';
              if($user->nivel<=1){
                echo '
                  <li><a href="#" onclick="ver_usuarios()">Ver usuarios</a></li>
                ';
              }
              if($user->nivel<=1){
                echo '
                  <li><a href="#" onclick="agregar_usuarios()">Agregar Usuarios</a></li>
                ';
              }

                echo '
              </ul>
            </li>';
          }
          if($user->nivel<=1){
            echo '
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Inventario <span class="caret"></span></a>
              <ul class="dropdown-menu">
              ';
              if($user->nivel<=1){
                echo '
                  <li><a href="#" onclick="agregar_inventario()">Agregar Producto</a></li>
                ';
              }
              if($user->nivel<=1){
                echo '
                  <li><a href="#" onclick="ver_inventario()">Ver Inventario</a></li>
                ';
              }
              if($user->nivel<=1){
                echo '
                  <li><a href="#" onclick="surtir_inventario()">Surtir</a></li>
                ';
              }

              if($user->nivel<=1){
                echo '
                  <li><a href="#" onclick="ver_cetogoria_inventario()">Ver Categorias</a></li>
                ';
              }
                echo '
              </ul>
            </li>';

          }
          if($user->nivel<=2){
            echo '
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Herramientas<span class="caret"></span></a>
              <ul class="dropdown-menu">
              ';
              if($user->nivel<=2){
                echo '
                  <li><a href="#" onclick="calcular_precio()">Calcular Precio</a></li>
                ';
              }
             
                echo '
              </ul>
            </li>';

          }
          /*if($user->nivel<=1){
            echo '
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Informacion<span class="caret"></span></a>
              <ul class="dropdown-menu">
              ';
              if($user->nivel<=1){
                echo '
                  <li><a href="#" onclick="informacion_hospedaje()">Ultimo mes</a></li>
                ';
                echo '
                  <li><a href="#" onclick="informacion_fecha()">Fecha</a></li>
                ';
              }
                echo '
              </ul>
            </li>';

          }*/


            echo '
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">Corte<span class="caret"></span></a>
              <ul class="dropdown-menu">
              ';
              if($confi->pre_ver_corte==0){
                echo '
                  <li><a href="#" onclick="ver_cortes()">Hacer Corte</a></li>
                ';
              }else{
                echo '
                  <li><a href="#" onclick="ver_precorte()">Hacer Corte</a></li>
                ';
              }

                if($user->nivel<=1){
                echo '
                  <li><a href="#" onclick="ver_cortes_hechos()">Ver Cortes</a></li>
                ';
              }

                echo '
              </ul>
            </li>';



            if($user->nivel<=2){
                echo '
                  <li><a href="#" onclick="ver_gastos()">Gastos</a></li>
                ';
              }
            /*  if($user->nivel<=2){
                echo '
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Factura<span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="#" onclick="ver_facturas_folio()">Facturas Folio</a></li>
                    <li><a href="#" onclick="ver_facturas_fecha()">Facturas por fecha</a></li>
                  </ul>
                </li>';
                }
              */
          echo '
        </ul>
        <ul class="nav navbar-nav navbar-right">';

          echo '<li class="hidden-xs hidden-sm" ><a href="#"><span class="glyphicon glyphicon glyphicon-warning-sign" onclick="ver_alerta_citas()"></span> <span id="alerta_citas" style="color:white">'.$alerta_cita.'</span></a></li>';
          echo '
          <li class="hidden-xs hidden-sm"><a href="#"><span class="glyphicon glyphicon-user"></span> '.$user->nombre.'</a></li>
          <li class="hidden-xs hidden-sm"><a href="#"> '.$user->nivel_texto.'</a></li>
          <li><a href="#ventanasalir" data-toggle="modal"><span class="glyphicon glyphicon-log-in"></span> Salir</a></li>
        </ul>
      </div>
    </div>
    </nav>
    <div class="modal fade" id="ventanasalir">
      <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">AHCloud>Salir</h3>
          </div>
          <div class="modal-body">
            <p>¿'.$user->nombre.' estas seguro de salir de la alicación?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="salirsession()">Salir</button>
          </div>
        </div>
      </div>
    </div>
    ';
?>
