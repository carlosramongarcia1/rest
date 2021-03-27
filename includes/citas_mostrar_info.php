<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_cliente.php');
  include_once('clase_usuario.php');
  $cliente = NEW Cliente();
  $usuario = NEW Usuario($_GET['trabajador']);
  echo '<div class="modal-header">
        <h3 class="modal-title">Cita con  '.$usuario->nombre.' <button type="button" onclick="eliminar_cita('.$_GET['id'].')" class="btn btn-danger">Eliminar cita</button></h3>
      </div>';
      echo '<div class="container-fluid">';
      echo '</br>';
      echo '<div class="row">';
      $consulta=$cliente->informacion_cita($_GET['id']);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $consulta2=$cliente->mostrar_cliente($fila['cliente']);
        while ($fila2 = mysqli_fetch_array($consulta2))
        {

          echo '
          <div class="container">
            <h2>'.$fila['hora'].':';
            if($fila['minuto']==0){
              echo '00';
            }else{
              echo $fila['minuto'];
            }
            echo ' '.$fila['titulo'].'</h2>
            <p>'.$fila['comentario'].'</p>
            <table class="table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Telefono</th>
                  <th>E-mail</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>'.$fila2['nombre'].'</td>
                  <td>'.$fila2['telefono'].'</td>
                  <td>'.$fila2['email'].'</td>
                </tr>
              </tbody>
            </table>
            </div>';
        }

      }
      echo '</div>';
      echo '</div>';
?>
