<?php
    date_default_timezone_set('America/Mexico_City');
    /**
     *
     */
     include_once('consulta.php');

    class Usuario extends ConexionMYSql
    {
      public $id;
      public $nombre;
      public $nivel;
      public $nivel_texto;
      public $estado;
      public $activo;
      public $user_privilegio;
      public $user_ver;
      public $user_ediar;
      public $user_borrar;
      public $user_agrear;
      public $user_asig_reca;
      public $hab_detallar;
      public $hab_lavar;
      public $hab_limpiar;
      public $hab_mantenimiento;
      public $hab_bloqueo;
      public $hab_asignar;
      public $hab_terminar_detalle;
      public $hab_cambiar_per_detalle;


      function __construct($id_usuario)
      {
        if($id_usuario==0){
          $this->id= 0;
          $this->nombre= "Sin/Nombre";
          $this->nivel= -1;
          $this->estado=-1;
          $this->activo= -1;
          $this->user_privilegio= -1;
          $this->user_ver= -1;
          $this->user_ediar= -1;
          $this->user_borrar= -1;
          $this->user_agrear= -1;
          $this->user_asig_reca= -1;
          $this->hab_detallar= -1;
          $this->hab_lavar= -1;
          $this->hab_limpiar= -1;
          $this->hab_mantenimiento= -1;
          $this->hab_bloqueo= -1;
          $this->hab_asignar= -1;
          $this->hab_terminar_detalle= -1;
          $this->hab_cambiar_per_detalle= -1;
        }else{
          $sentencia = "SELECT * FROM usuario WHERE id = $id_usuario LIMIT 1";
          //echo $sentencia;
          $comentario="Asignación de usuarios a la clase usuario funcion constructor";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          while ($fila = mysqli_fetch_array($consulta))
          {
    			     $this->id= $fila['id'];
               $this->nombre= $fila['usuario'];
               $this->nivel= $fila['nivel'];
               switch ($fila['nivel']) {

                 case 0:
                      $this->nivel_texto='Master';
                   break;
                 case 1:
                      $this->nivel_texto='Administrador';
                   break;
                 case 2:
                      $this->nivel_texto='Cajer@';
                    ;
                   break;
                 case 3:
                      $this->nivel_texto='Barber@';

                   break;
                 case 4:
                    $this->nivel_texto='Estilista';

                   break;
                 default:
                      $this->nivel_texto='Indefinido';

                   break;
               }
               $this->estado= $fila['estado'];
               $this->activo= $fila['activo'];
               $this->user_ver= $fila['user_ver'];
               $this->user_ediar= $fila['user_ediar'];
               $this->user_borrar= $fila['user_borrar'];
               $this->user_agrear= $fila['user_agrear'];
               $this->user_asig_reca= $fila['user_asig_reca'];
               $this->hab_detallar=  $fila['hab_detallar'];
               $this->hab_lavar=  $fila['hab_lavar'];
               $this->hab_limpiar=  $fila['hab_limpiar'];
               $this->hab_mantenimiento=  $fila['hab_mantenimiento'];
               $this->hab_bloqueo=  $fila['hab_bloqueo'];
               $this->hab_asignar=  $fila['hab_asignar'];
               $this->hab_terminar_detalle=  $fila['hab_terminar_detalle'];
               $this->hab_cambiar_per_detalle=  $fila['hab_cambiar_per_detalle'];
    		  }
          $this->user_privilegio=$this->user_ver+$this->user_ediar+$this->user_borrar+$this->user_agrear+$this->user_asig_reca;
        }

      }
      function mostrar_trabajador(){
        $sentencia = "SELECT * FROM usuario WHERE  nivel >=3 AND nivel <=4 AND activo = 1 ORDER BY usuario";
        $comentario="Mostrar barberos y estilistas";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<option value="'.$fila['id'].'">'.$fila['usuario'].'</option>';
        }
      }
      function salec_mante($hab_id, $hab_estado){
        $sentencia = "SELECT * FROM usuario WHERE activo = 1 AND nivel = 4 ORDER BY usuario ";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          switch ($hab_estado) {
            case 1:
                echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                    echo '<div class="asignar_reca_activa" onclick="conceptomante('.$hab_id.','.$hab_estado.','.$fila['id'].')">';
                    echo '</br>';
                    echo '<div>';
                        echo '<img src="images/persona.png"  class="center-block img-responsive">';
                    echo '</div>';
                    echo '<div>';
                      echo $fila['usuario'];
                    echo '</div>';
                    echo '</br>';
                  echo '</div>';
                echo '</div>';
              break;
            default:
                echo "Sin Información que mostrar";
              break;
          }
        }
      }
      function borrar_usuario($id){
        $sentencia = "UPDATE `usuario` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de usuario como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function mostrar(){
        $sentencia = "SELECT * FROM usuario WHERE estado = 1 ORDER BY nivel, usuario";
        $comentario="Mostrar los usuarios";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive">
          <table class="table">
            <thead>
              <tr class="texto_entrada">
                <th>Nombre</th>
                <th>Nivel</th>
                <th><span class="glyphicon glyphicon-cog"></span> Borrar</th>
              </tr>
            </thead>
            <tbody>';
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($fila['nivel']>0){
              echo '<tr>
              <td class="texto_entrada">'.$fila['usuario'].'</td>';
              switch ($fila['nivel']) {

                case 1:
                    echo '<td class="texto_entrada">Administrador</td>';
                  break;
                case 2:
                    echo '<td class="texto_entrada">Cajer@</td>';
                  break;
                case 3:
                    echo '<td class="texto_entrada">Barber@</td>';
                  break;
                case 4:
                    echo '<td class="texto_entrada">Estilista</td>';
                  break;
                default:
                    echo '<td class="texto_entrada">Indefinido</td>';
                  break;
              }

              echo '<td><button class="btn-danger" onclick="borrar_usuario('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Borrar</button></td>
            </tr>';
          }
        }
          echo '</table>
            </div>';
      }
      function saber_nombre($id_usuario){
        $sentencia = "SELECT usuario FROM usuario WHERE id = $id_usuario LIMIT 1";
        $comentario="selecciona el nombre del usuario ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
             $usuario= $fila['usuario'];
        }
        return $usuario;
      }
      function guardar_usuario($usuario,$pass,$nivel){
        $pass=md5($pass);
        $sentencia = "INSERT INTO `usuario` (`usuario`, `pass`, `nivel`, `estado`, `activo`)
        VALUES ('$usuario', '$pass', '$nivel', '1', '1');";
        $comentario="Guardamos el usuario en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function salec_reca($hab_id, $hab_estado){
        $sentencia = "SELECT * FROM usuario WHERE activo = 1 AND nivel = 3 AND estado=1 AND user_asig_reca = 1 ORDER BY usuario ";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          switch ($hab_estado) {
            case 1:
                echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                    echo '<div class="asignar_reca_activa" onclick="detalletiempo('.$hab_id.','.$hab_estado.','.$fila['id'].')">';
                    echo '</br>';
                    echo '<div>';
                        echo '<img src="images/persona.png"  class="center-block img-responsive">';
                    echo '</div>';
                    echo '<div>';
                      echo $fila['usuario'];
                    echo '</div>';
                    echo '</br>';
                  echo '</div>';
                echo '</div>';
              break;
              case 2:
                echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                    echo '<div class="asignar_reca_activa" onclick="lavartiempo('.$hab_id.','.$hab_estado.','.$fila['id'].')">';
                    echo '</br>';
                    echo '<div>';
                        echo '<img src="images/persona.png"  class="center-block img-responsive">';
                    echo '</div>';
                    echo '<div>';
                      echo $fila['usuario'];
                    echo '</div>';
                    echo '</br>';
                  echo '</div>';
                echo '</div>';
                break;
                case 3:
                  echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                      echo '<div class="asignar_reca_activa" onclick="limpiartiempo('.$hab_id.','.$hab_estado.','.$fila['id'].')">';
                      echo '</br>';
                      echo '<div>';
                          echo '<img src="images/persona.png"  class="center-block img-responsive">';
                      echo '</div>';
                      echo '<div>';
                        echo $fila['usuario'];
                      echo '</div>';
                      echo '</br>';
                    echo '</div>';
                  echo '</div>';
                  break;
                  case 4:
                    echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                        echo '<div class="asignar_reca_activa" onclick="asignarcobrar('.$hab_id.','.$hab_estado.','.$fila['id'].')">';
                        echo '</br>';
                        echo '<div>';
                            echo '<img src="images/persona.png"  class="center-block img-responsive">';
                        echo '</div>';
                        echo '<div>';
                          echo $fila['usuario'];
                        echo '</div>';
                        echo '</br>';
                      echo '</div>';
                    echo '</div>';
                    break;
                    case 5:
                      echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                          echo '<div class="asignar_reca_activa" onclick="limpiar_sucia_tiempo('.$hab_id.','.$hab_estado.','.$fila['id'].')">';
                          echo '</br>';
                          echo '<div>';
                              echo '<img src="images/persona.png"  class="center-block img-responsive">';
                          echo '</div>';
                          echo '<div>';
                            echo $fila['usuario'];
                          echo '</div>';
                          echo '</br>';
                        echo '</div>';
                      echo '</div>';
                      break;
                    case 6:
                      echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                          echo '<div class="asignar_reca_activa" onclick="cambiar_persona('.$hab_id.','.$hab_estado.','.$fila['id'].')">';
                          echo '</br>';
                          echo '<div>';
                              echo '<img src="images/persona.png"  class="center-block img-responsive">';
                          echo '</div>';
                          echo '<div>';
                            echo $fila['usuario'];
                          echo '</div>';
                          echo '</br>';
                        echo '</div>';
                      echo '</div>';
                      break;
            default:
                echo "Sin Información que mostrar";
              break;
          }
        }
      }
      function rotar_reca($estado,$id){
        $sentencia = "UPDATE `usuario` SET
          `user_asig_reca` = '$estado'
          WHERE `id` = '$id';";
        $comentario="Asignar/Desasignar Recamarera dentro del horario de trabajo en clase_usuario";
        echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function usario_asignar(){
        $sentencia = "SELECT * FROM usuario WHERE activo = 1 AND  estado=1 AND nivel = 3  ORDER BY usuario ";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
            if($fila['user_asig_reca']==0){
              echo '<div class="asignar_reca" onclick="selecionareca(1,'.$fila['id'].')">';
            }else{
              echo '<div class="asignar_reca_activa" onclick="selecionareca(0,'.$fila['id'].')">';
            }
              echo '</br>';
              echo '<div>';
                  echo '<img src="images/persona.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                echo $fila['usuario'];
              echo '</div>';
              if($fila['user_asig_reca']==0){
                echo '<div>';
                  echo '<p class="infor_asig_reca">No Asignada</p>';
                echo '</div>';
              }else{
                echo '<div>';
                  echo '<p class="infor_asig_reca">Asignada</p>';
                echo '</div>';
              }
              echo '</br>';
            echo '</div>';
          echo '</div>';




        }
      }
    }
    class Citas extends ConexionMYSql{
      public $trabajador_nombre=array();
      public $trabajador_id=array();
      function __construct($trabajador)
      {
        $this->obtener_trabajadores($trabajador);
      }
      function obtener_trabajadores($trabajador){
        $posicion=0;
        $sentencia = "SELECT * FROM usuario WHERE estado = 1 AND nivel >= 3 AND nivel <=4 ORDER BY usuario";
        $comentario="obtener informacion de los trabajadores";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $this->trabajador_nombre[$posicion]=$fila["usuario"];
          $this->trabajador_id[$posicion]=$fila["id"];
          $posicion++;
        }
      }
      function saber_cita($fecha ,$trabajador,$nombre,$mod){
        $year =date("Y",$fecha);
        $mes=date("m",$fecha);
        $dia=date("j",$fecha);
        $hora=date("H",$fecha);
        $minuto=date("i",$fecha);
        $id =0;
        $comentario = "";
        $sentencia = "SELECT * FROM citas WHERE year = $year AND mes  = $mes  AND dia = $dia AND hora = $hora AND minuto  = $minuto AND trabajador = $trabajador  LIMIT 1 ";
        $comentario="Obtener de la bese de datos el reporte de las matricula";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
            $id=$fila['id'];
            $comentario=$fila['titulo'];
        }
        if($id==0){

          if(($mod)==0){

            echo '
              <a  href="#caja_herramientas" onclick="citas_asignar('.$fecha.','.$trabajador.')">
                <div class="alert alert-success no-margen">
                  <strong>'.date("H:i",$fecha).'</strong>
                </div>
              </a>
            ';
          }else{
            echo '
            <a  href="#caja_herramientas"  onclick="citas_asignar('.$fecha.','.$trabajador.')">
              <div class="alert alert-info no-margen">
                <strong>'.date("H:i",$fecha).'</strong>
              </div>
            </a>
            ';
          }

        }else{
          echo '
          <a  href="#caja_herramientas"  onclick="citas_mostrar_info('.$id.','.$fecha.','.$trabajador.')">
            <div class="alert alert-danger no-margen">
              <strong>'.date("H:i",$fecha).'</strong> - '.$comentario.'
            </div>
          </a>
          ';
        }
      }
    }
?>
