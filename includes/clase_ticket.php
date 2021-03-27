<?php
  date_default_timezone_set('America/Mexico_City');
  /**
   *
   */
  include_once('consulta.php');
  class Ticket extends ConexionMYSql
  {
    function __construct()
    {

    }
    function obtener_etiqueta(){
      $sentencia = "SELECT ticket FROM labels LIMIT 1";
      $etiqueta ="";
      $comentario="obtener la etiqueta del ticket";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        $etiqueta=$fila["ticket"];
      }
      return $etiqueta;
    }
    function cacelar_tickes($mov){
      $sentencia = "SELECT id FROM  ticket WHERE mov = $mov;";
      $comentario="obtener la id del los tickets";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        $this->eliminar_cocepto($fila['id']);
        $this->eliminar_ticket($fila['id']);
      }

    }
    function eliminar_cocepto($ticket_id){
      $sentencia = "DELETE FROM `concepto`
      WHERE ((`ticket` = '$ticket_id'));";
      $comentario="Elimina el concepto ";
      $this->realizaConsulta($sentencia,$comentario);
    }
    function eliminar_ticket($ticket_id){
      $sentencia = "DELETE FROM `ticket`
      WHERE ((`id` = '$ticket_id'));";
      $comentario="Elimina el concepto ";
      $this->realizaConsulta($sentencia,$comentario);
    }
    function actualizar_etiqueta(){
      $nueva_etiqueta=$this->obtener_etiqueta()+1;
      $sentencia = "UPDATE `labels` SET
      `ticket` = '$nueva_etiqueta'
      WHERE `id` = '1';";
      $comentario="Actualizar la etiqueta del ticket";
      $this->realizaConsulta($sentencia,$comentario);
    }
    function id_mysql(){
      $id=0;
      $sentencia = "SELECT id FROM ticket ORDER BY id DESC LIMIT 1";
      $comentario="Recojer el id del movimiento anterior";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id= $fila['id'];
      }
      return $id;
    }
    function sabertiempo_ultimo($mov){
      $tiempo=0;
      $sentencia = "SELECT * FROM ticket WHERE mov = $mov ORDER BY id DESC LIMIT 1";
      $comentario="Obtener el tiempo ";
      //echo $sentencia;
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           $tiempo= $fila['tiempo'];
      }
      if($tiempo>0){
        $tiempo=time()-$tiempo;
        if($tiempo>10){
           $saber='si';
        }else{
           $saber='no';
        }
      }else{
        $saber='si';
      }
      return $saber;
    }
    /*function guardar_ticket($mov,$habitacion,$recep,$recam,$total,$pago,$cambio,$tarjeta,$descuento,$estado,$baucher,$resta,$comanda){
      $fecha=date("Y-m-d H:i");
      $tiempo=time();
      $nueva_etiqueta=$this->obtener_etiqueta();
      $this->actualizar_etiqueta();
      $sentencia = "INSERT INTO `ticket` (`etiqueta`, `mov`, `habitacion`, `fecha`, `tiempo`, `recep`, `recam`, `total`, `pago`, `cambio`, `tarjeta`, `descuento`, `estado`, `facturado`, `baucher`, `impreso`, `resta`, `comanda`)
      VALUES ('$nueva_etiqueta', '$mov', '$habitacion', '$fecha', '$tiempo', '$recep', '$recam', '$total', '$pago', '$cambio', '$tarjeta', '$descuento', '$estado', '0', '$baucher', '1', '$resta', 0);";
      echo $sentencia;
      $comentario="Guardar la informacion del ticket";
      $this->realizaConsulta($sentencia,$comentario);
      $MYSql_id=$this->id_mysql();
      return $MYSql_id;
    }*/
    function guardar_ticket($recep,$trabajador,$total,$pago,$cambio,$tarjeta,$descuento){
      $fecha=date("Y-m-d H:i");
      $tiempo=time();
      $nueva_etiqueta=$this->obtener_etiqueta();
      $this->actualizar_etiqueta();
      $sentencia = "INSERT INTO `ticket` (`etiqueta`, `fecha`, `tiempo`, `recep`, `trabajador`, `total`, `pago`, `cambio`, `tarjeta`, `descuento`, `estado`, `facturado`, `impreso`)
      VALUES ('$nueva_etiqueta', '$fecha', '$tiempo', '$recep', '$trabajador', '$total', '$pago', '$cambio', '$tarjeta', '$descuento', '0', '0', '0');";
      //echo $sentencia;
      $comentario="Guardar la informacion del ticket";
      $this->realizaConsulta($sentencia,$comentario);
      $MYSql_id=$this->id_mysql();
      return $MYSql_id;

    }
    function guardar_concepto($ticket,$nombre,$cantidad,$precio,$total,$tipocargo,$categoria){
      $sentencia = "INSERT INTO `concepto` (`ticket`, `nombre`, `cantidad`, `precio`, `total`, `tipocargo`, `categoria`)
      VALUES ('$ticket', '$nombre', '$cantidad', '$precio', '$total', '$tipocargo', '$categoria');";
      $comentario="Guardando concepto ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function cambiar_estado($id_ticket){
      $sentencia = "UPDATE `ticket` SET
      `impreso` = '0'
      WHERE `id` = '$id_ticket';";
      $comentario="Cambiar estado del ticket";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function cambiar_comanda($ticket){
      $sentencia = "SELECT * FROM concepto WHERE ticket = 0";
      $comentario="Recojer el id del movimiento anterior";
      //echo $sentencia."</br>";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $inventario=$this->cantidad_inventario($fila['categoria']);
        $historial=$this->cantidad_historial($fila['categoria']);
        $inventario=$inventario-$fila['cantidad'];
        $historial=$historial+$fila['cantidad'];
        $this->editar_cantidad_inventario($fila['categoria'],$inventario);
        $this->editar_cantidad_historial($fila['categoria'],$historial);
      }
      $sentencia = "UPDATE `concepto` SET
      `ticket` = '$ticket'
      WHERE `ticket` = '0';";
      $comentario="cambiar el estado de las comandas";
      $consulta= $this->realizaConsulta($sentencia,$comentario);

    }

    function cantidad_inventario($producto){
      $sentencia = "SELECT inventario FROM producto WHERE id = $producto LIMIT 1 ";
      $comentario="Mostrar inventario de un producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia."</br>";
      $inventario=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $inventario=$fila['inventario'];
      }
      return $inventario;
    }
    function cantidad_historial($producto){
      $sentencia = "SELECT historial FROM producto WHERE id = $producto LIMIT 1 ";
      $comentario="Mostrar historial de un producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //  echo $sentencia."</br>";
      $historial=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $historial=$fila['historial'];
      }
      return $historial;
    }
    function editar_cantidad_inventario($producto, $cantidad){
      $sentencia = "UPDATE `producto` SET
        `inventario` = '$cantidad'
        WHERE `id` = '$producto';";
      $comentario="Mostrar historial de un producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
        //echo $sentencia."</br>";
    }
    function editar_cantidad_historial($producto, $cantidad){

      $sentencia = "UPDATE `producto` SET
        `historial` = '$cantidad'
        WHERE `id` = '$producto';";
      $comentario="Mostrar historial de un producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
        //echo $sentencia."</br>";
    }
    function ticket_ini(){
      $id=0;
      $sentencia = "SELECT id FROM  ticket WHERE estado = 0 ORDER BY id LIMIT 1 ";
      $comentario="Recojer el id del movimiento anterior";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id= $fila['id'];
      }
      return $id;
    }
    function ticket_fin(){
      $id=0;
      $sentencia = "SELECT id FROM  ticket WHERE estado = 0 ORDER BY id DESC LIMIT 1 ";
      $comentario="Recojer el id del movimiento anterior";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id= $fila['id'];
      }
      return $id;
    }
  }

?>
