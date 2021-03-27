<?php
  /**
   *
   */
   date_default_timezone_set('America/Mexico_City');
   include_once('consulta.php');


  class Cliente extends ConexionMYSql
  {

    function __construct()
    {
      // code...
    }
    function mostrar_cliente($id){
      $sentencia = "SELECT * FROM cliente WHERE id = $id LIMIT 1 ";
      $comentario="ver cliente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      return   $consulta;
    }
    function buscar_cliente($busqueda,$tiempo, $trabajador){
      if((strlen ($busqueda))>0){
        $sentencia = "SELECT * FROM cliente WHERE nombre LIKE '%$busqueda%' LIMIT 15;";
        $comentario="Buscar cliente";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cont = 0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($cont==0){
            echo '
            <table class="table">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Telefono</th>
                  <th>Email</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>';
          }

            echo '
            <tr>
               <td>'.$fila['nombre'].'</td>
               <td>'.$fila['telefono'].'</td>
               <td>'.$fila['email'].'</td>
               <td><button type="button" class="btn btn-success"  onclick="agendar('.$fila['id'].','.$tiempo.','.$trabajador.')">Seleccionar</button></td>
             </tr>  ';


          $cont++;
        }
        if($cont>0){
          echo '
            </tbody>
          </table>
          ';
        }
        else{
          echo '<button type="button" class="btn btn-success" onclick="agregar_cliente('.$tiempo.','.$trabajador.')">Agregar Cliente</button>';
        }

      }
    }
    function guardar_cita($fecha,$cliente,$trabajador,$titulo,$comentario){
      $year =date("Y",$fecha);
      $mes=date("m",$fecha);
      $dia=date("j",$fecha);
      $hora=date("H",$fecha);
      $minuto=date("i",$fecha);

      $sentencia = "INSERT INTO `citas` (`year`, `mes`, `dia`, `hora`, `minuto`, `cliente`, `estado`, `trabajador`, `titulo`, `comentario`)
      VALUES ('$year', '$mes', '$dia', '$hora', '$minuto', '$cliente', '1', '$trabajador', '$titulo', '$comentario');";
      $comentario="Agendar Cita";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function guardar_cliente($nombre,$telefono,$email){
      $sentencia = "INSERT INTO `cliente` (`nombre`, `telefono`, `email`)
      VALUES ('$nombre', '$telefono', '$email');";
      $comentario="Guardar Cliente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $id = $this->obtener_id();
      return $id;
    }
    function obtener_id(){
      $sentencia = "SELECT id FROM cliente ORDER BY id DESC LIMIT 1 ";
      $comentario="obtener id";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $id = 0;
      while ($fila = mysqli_fetch_array($consulta))
      {
          $id = $fila['id'];
      }
      return $id;
    }
    function informacion_cita($id){
      $sentencia = "SELECT * FROM citas  WHERE id = $id LIMIT 1";
      $comentario="Buscar cita";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      return   $consulta;

    }
    function cantidad_citas(){
      $fecha =time();
      $year =date("Y",$fecha);
      $mes=date("m",$fecha);
      $dia=date("j",$fecha);
      $hora=date("H",$fecha);
      $id = 0;
      if($hora<=21){
        $hora_pasada=(date("H",$fecha))-2;
        $hora++;
        $sentencia = "SELECT COUNT(*) AS total FROM citas WHERE year = $year AND mes  = $mes  AND dia = $dia AND hora >=$hora_pasada AND hora <= $hora ";// AND hora = $hora
        $comentario="obntener la citas de hoy";
        //echo $sentencia ;
        $consulta= $this->realizaConsulta($sentencia,$comentario);

      while ($fila = mysqli_fetch_array($consulta))
        {
            $id = $fila['total'];
        }
      }

      return $id;
    }
    function citas_restantes(){
      $fecha =time();
      $year =date("Y",$fecha);
      $mes=date("m",$fecha);
      $dia=date("j",$fecha);
      $hora=date("H",$fecha);
      $contador = 0;

      if($hora<=21){
        $hora_pasada=(date("H",$fecha))-2;
        $hora++;
        $sentencia = "SELECT * FROM citas WHERE year = $year AND mes  = $mes  AND dia = $dia AND hora >=$hora_pasada";// AND hora = $hora
        $comentario="obntener la citas de hoy";
        //echo $sentencia ;
        $consulta= $this->realizaConsulta($sentencia,$comentario);

      while ($fila = mysqli_fetch_array($consulta))
        {
          if($contador == 0){
            echo '<table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Titulo</th>
                      <th>Cliente</th>
                      <th>Trabajador</th>
                      <th>Hora</th>
                    </tr>
                  </thead>
                  <tbody>';
          }
          echo '
          <tr>
            <td>'.$fila['titulo'].'</td>
            <td>'.$this->mostrar_cliente_nombre($fila['cliente']).'</td>
            <td>'.$this->mostrar_usuario_nombre($fila['trabajador']).'</td>';
            if($fila['minuto']==0){
              echo '<td>'.$fila['hora'].':00</td>';
            }else{
              echo '<td>'.$fila['hora'].':'.$fila['minuto'].'</td>';
            }

          echo '</tr>';
            $contador++;
        }
      }


    }
    function mostrar_cliente_nombre($id){
      $sentencia = "SELECT * FROM cliente WHERE id = $id LIMIT 1 ";
      $comentario="ver cliente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $nombre = "";
      while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre = $fila['nombre'];
        }
      return   $nombre;
    }
    function mostrar_usuario_nombre($id){
      $sentencia = "SELECT * FROM usuario WHERE id = $id LIMIT 1 ";
      $comentario="ver cliente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $nombre = "";
      while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre = $fila['usuario'];
        }
      return   $nombre;
    }
    function elimiar_cita($id){
      $sentencia = "DELETE FROM `citas`
      WHERE ((`id` = '$id'));";
      $comentario="Eliminando cita";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
  }

?>
