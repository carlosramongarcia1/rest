<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_usuario.php');

  if(isset ($_GET['tiempo'])){
    $fecha=$_GET['tiempo'];
  }else{
    $fecha = date('Y-m-j');
  }

  $fecha =strtotime($fecha)+28800;
  if(isset ($_GET['trabajador'])){
    $trabajador=$_GET['trabajador'];
  }else{
    $trabajador = 0;
  }
  $cita = NEW Citas($trabajador);
  $user = NEW Usuario($trabajador);
  echo '
  <div class="panel panel-success">
    <div class="panel-heading"><h3>Citas del dia  </h3> </div>
    <div class="row">
    </br>


    <div class="panel-body">
      <div class="container-fluid">
        <div class="row">
        <nav class="col-sm-3" id="myScrollspy">
          <ul class="nav nav-pills nav-stacked">
          <li class="active"><input type="date" class="form-control" id="tiempo" value="'.date('Y-m-d',$fecha).'" onchange="cambio_fecha('.$trabajador.')"></li>
          ';
          $cantidad=count($cita->trabajador_id);
            for($z =0 ; $z<$cantidad; $z++){

                if($cita->trabajador_id[$z]==$trabajador){
                  echo '<li class="danger">';
                }else{
                  echo '<li class="active">';
                }

                echo '<a href="#" onclick="cambio_trabajador('.$cita->trabajador_id[$z].')">'.$cita->trabajador_nombre[$z].'</a></li>';
                //echo '<th class="alinear_centro separador" style="width: 10%" onclick="cambio_trabajador('.$cita->trabajador_id[$z].')">'.$cita->trabajador_nombre[$z].'</th>';
            }
          echo '


            </li>
          </ul>
        </nav>
        <div class="col-sm-6">
          <div id="section">';
          if($trabajador>0){
           echo '
              <ul class="nav nav-pills nav-stacked">
              <li class="active"><a href="#">'.$user->nombre.'</a></li>
              </ul>
            ';
            for ($i = 0; $i <= 26; $i++) {
             $mod=$i%2;
             $cita->saber_cita($fecha, $user->id,$user->nombre,$mod);
              $fecha =$fecha+1800;
            }


          }

          echo '
          </div>

        </div>
        </div>
        </div>
      </div>
    </div>
  ';
?>
