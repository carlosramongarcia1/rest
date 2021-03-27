<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_cliente.php');
  include_once('clase_usuario.php');
  $citas = NEW Cliente();
  $cita = NEW Citas($_GET['trabajador']);
  $user = NEW Usuario($_GET['trabajador']);
  $clie=$citas->guardar_cliente($_GET['cliente'],$_GET['telefono'],$_GET['email']);
  $fecha_nueva=$_GET['tiempo'];
  for($z =0 ; $z<$_GET['cantidad_tiempo']; $z++){
    $citas->guardar_cita($fecha_nueva,$clie,$_GET['trabajador'],$_GET['titulo'],$_GET['descripcion']);

    $fecha_nueva=$fecha_nueva+1800;
  }
  if($_GET['trabajador']>0){
    $fecha = date('Y-m-j' , $_GET['tiempo']);
   echo '
      <ul class="nav nav-pills nav-stacked">
      <li class="active"><a href="#">'.$user->nombre.'</a></li>
      </ul>
    ';
    /*if(isset ($_GET['tiempo'])){
      $fecha=$_GET['tiempo'];
    }else{
      $fecha = date('Y-m-j');
    }*/
    $fecha =strtotime($fecha)+28800;
    //$fecha =$_GET['tiempo']+28800;

    for ($i = 0; $i <= 26; $i++) {
     $mod=$i%2;
     $cita->saber_cita($fecha, $user->id,$user->nombre,$mod);
      $fecha =$fecha+1800;
    }


  }
?>
