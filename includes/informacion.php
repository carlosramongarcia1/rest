<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  class Informacion extends ConexionMYSql
  {

    function __construct()
    {

    }
    function evaluarEntrada($usuario_evaluar ,$password_evaluar){
      $id=0;
      $sentencia = "SELECT id FROM usuario WHERE usuario = '$usuario_evaluar' AND pass= '$password_evaluar' AND estado = 1";
      $comentario="Busqueda de colores en base de datos archvivo Colors.php funcion constructor";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id= $fila['id'];
      }
      return $id;
    }
    function conversorSegundosHoras($tiempo_en_segundos) {
      $horas = floor($tiempo_en_segundos / 3600);
      $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
      $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
      if($minutos<10){
        $minutos="0".$minutos;
      }
      return $horas . ':' . $minutos ;
    }
}
?>
