<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Configuracion extends ConexionMYSql{
    public $corte;
    public $nombre;
    public $pre_ver_corte;
    public $activacion;

    function __construct()
    {
      $sentencia = "SELECT * FROM configuracion WHERE id = 1 LIMIT 1 ";
      $comentario="Obtener todos los valores de la configuracion ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           $this->corte= $fila['corte'];
           $this->nombre= $fila['nombre'];
           $this->pre_ver_corte= $fila['pre_ver_corte'];
           $this->activacion= $fila['activacion'];
      }
    }
    function editar_portada($hab){
      $sentencia = "UPDATE `configuracion` SET
      `portada_hab` = '$hab'
      WHERE `id` = '1';";
      $comentario="Actualizar informacion de la portada";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
  }

?>
