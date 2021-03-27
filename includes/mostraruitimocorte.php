<?php
    date_default_timezone_set('America/Mexico_City');
	include_once('consulta.php');
	$etiqueta=0;
	$sentencia = "SELECT etiqueta FROM corte ORDER BY id  DESC  LIMIT 1 ";
    $comentario="Asignación de usuarios a la clase usuario funcion constructor";
    $consulta= ConexionMYSql::realizaConsulta($sentencia,$comentario);
    while ($fila = mysqli_fetch_array($consulta))
        {
  			     $etiqueta= $fila['etiqueta'];
  		  }
    //echo $etiqueta;
    if($etiqueta>0){
    	echo '<object width="900" height="600" type="application/pdf" data="../corte/corte_caja'.$etiqueta.'.pdf">
			<param name="src" value="//192.168.1.145/gestion/viewer/doc.pdf" />
			<p>N o PDF available</p>
			</object>';
    }
?>