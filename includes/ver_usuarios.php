<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  $user= NEW Usuario(0);
  echo ' <div class="container-fluid">
          <h2 class="texto_entrada">Usuarios</h2>';
          $user->mostrar();
  echo  '</div>';
?>
