<?php 
	date_default_timezone_set('America/Mexico_City');
	include_once('consulta.php');
	/**
	* 
	*/
	class Gastos extends ConexionMYSql
	{
		
		function __construct()
		{
			
		}
		function guardar_gasto($id,$nombre,$total){
			$tiempo=time();
			$sentencia = "INSERT INTO `gasto` (`nombre`, `total`, `estado`, `fecha`, `realizo`)
			VALUES ('$nombre', '$total', '0', '$tiempo', '$id');";
		    $comentario="agregar gastos";
		    $this->realizaConsulta($sentencia,$comentario);
		}
		function borrar_gasto($id){
			$sentencia = "DELETE FROM `gasto`
			WHERE ((`id` = '$id'));";
		    $comentario="borrar gastos";
		    $this->realizaConsulta($sentencia,$comentario);
		}
		function ver_gastos_activos(){
			  $sentencia = "SELECT * FROM gasto WHERE estado = 0 ORDER BY fecha DESC";
		      $comentario="obtener los gastos activos ";
		      $consulta= $this->realizaConsulta($sentencia,$comentario);
		      echo '<div class="table-responsive">
				        <table class="table">
				          <thead>
				            <tr>
				              <th>Producto</th>
				              <th>Cantidad</th>
				              <th>fecha</th>
				              <th><span class=" glyphicon glyphicon-cog"></span> Herramientas</th>
				            </tr>
				          </thead>
				          <tbody>';
				          echo '<tr>
						        <td><input type="text" placeholder="Gasto" id ="gasto_nombre" class="color_black"></td>
						        <td><input type="number" placeholder="Total" id ="gasto_total" class="color_black"></td>
						        <td></td>
						        <td><button class="btn-success" onclick="guardar_gasto()"><span class="glyphicon glyphicon-edit"></span> Guardar</button></td>
						      </tr>';
						      $total=0;
		      while ($fila = mysqli_fetch_array($consulta))
      		  {
      		  	echo '<tr>
			        <td>'.$fila['nombre'].'</td>
			        <td>$'.$fila['total'].'</td>
			        <td>'.date("Y-m-d H:i:s",$fila['fecha']).'</td>
			        <td><button class="btn-danger" onclick="borrar_gasto('.$fila['id'].')"><span class="glyphicon glyphicon-trash"></span> Borrar</button></td>
			      </tr>';
			      $total=$total+$fila['total'];
      		  }
      		  	echo '<tr>
			        <td></td>
			        <td>$'.$total.'</td>
			        <td></td>
			        <td></td>
			      </tr>';
      		   echo '</table>
          </div>';
		}
	}
?>