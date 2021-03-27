<?php
	date_default_timezone_set('America/Mexico_City');
	include_once('consulta.php');
/**
 *
 */
 class Cortes_limpieza_info extends ConexionMYSql
 {
	 public $hab_tipo=array();
	 public $hab_cantidad=array();
	 public $hab_precio=array();
	 public $hab_total=array();

	 public $hab_tipo_hospedaje=array();
	 public $hab_cantidad_hospedaje=array();
	 public $hab_precio_hospedaje=array();
	 public $hab_total_hospedaje=array();

	 public $tipo_restaurante=array();
	 public $global_restaurante=array();
	 public $total_restaurante=array();

	 public $producto_nombre=array();
	 public $producto_venta=array();
	 public $producto_inventario=array();

	 public $gasto_nombre=array();
	 public $gasto_venta=array();
	 public $ticket_inicial_id;
	 public $ticket_inicial_etiqueta;
	 public $ticket_final_id;
	 public $total_personas;
	 public $total_horas;
	 public $total_gastos;

	 public $total_efectivo;
	 public $total_tarjeta;
	 public $total_cortesia;
	 public $ticket_primero_etiqueta;
	 public $ticket_fin_etiqueta;
	 public $total_Restaurante;


	 public $num_corte=0;
	 function __construct($corte_ini,$corte_fin)
	 {
		 $this->ticket_inicial($corte_ini);
		 $this->ticket_final($corte_fin);
		 $this->total_Restaurante= $this->cantidad_Restaurante($this->ticket_inicial_id, $this->ticket_final_id);
		 $this->total_horas=$this->cantidad_horas($this->ticket_inicial_id, $this->ticket_final_id);
		 $this->total_personas=$this->cantidad_personas($this->ticket_inicial_id, $this->ticket_final_id);
		 $this->ticket_inicial_etiqueta=$this->obtener_etiqueta($this->ticket_inicial_id);
		 $contador=0;
		 $sentencia = "SELECT * FROM tarifa;";
		 $comentario="Obtener las tarifas";
		 $consulta= $this->realizaConsulta($sentencia,$comentario);
		 while ($fila = mysqli_fetch_array($consulta))
		 {
			 $this->hab_tipo[$contador]=$fila['nombre'];
			 $this->hab_precio[$contador]=$fila['precio_lunes'];
			 $this->hab_cantidad[$contador]=$this->cantida_renta($this->ticket_inicial_id, $this->ticket_final_id,$fila['id']);
			 $this->hab_total[$contador]=$this->total_renta($this->ticket_inicial_id, $this->ticket_final_id,$fila['id']);
			 $contador++;
			 //echo $this->hab_tipo[$contador];
		 }
	 }
	 function guardar_limpieza($corte_ini,$corte_fin,$realizo){
	   $tiempo=time();
	   $sentencia = "INSERT INTO `limpieza` (`fecha`, `corte_ini`, `corte_fin`, `realizo`)
	     VALUES ('$tiempo', '$corte_ini', '$corte_fin', '$realizo');";
	   $comentario="Guardar Limpieza";
	   $consulta= $this->realizaConsulta($sentencia,$comentario);
	   $id_limpieza=$this->id_mysql();
	   return $id_limpieza;
	 }
	 function id_mysql(){
		 $id=0;
		 $sentencia = "SELECT id FROM limpieza ORDER BY id DESC LIMIT 1";
		 $comentario="Recojer el id del limpieza anterior";
		 $consulta= $this->realizaConsulta($sentencia,$comentario);
		 while ($fila = mysqli_fetch_array($consulta))
		 {
					$id= $fila['id'];
		 }
		 return $id;
	 }
	 function obtener_etiqueta(){
		 $etiqueta=0;
		 $sentencia = "SELECT etiqueta FROM ticket WHERE  id = $this->ticket_inicial_id limit 1 ";
		 //echo  $sentencia.'</br>';
		 $comentario="Recojer el id del limpieza anterior";
		 $consulta= $this->realizaConsulta($sentencia,$comentario);
		 while ($fila = mysqli_fetch_array($consulta))
		 {
					$etiqueta= $fila['etiqueta'];
		 }
		 return $etiqueta;
	 }
	 function cambiar_etiqueta($etiqueta,$impreso,$corte_ini,$corte_fin){

		 $sentencia = "SELECT * FROM ticket WHERE id >= $this->ticket_inicial_id ";
		 $comentario="Recojer el id del limpieza anterior";
		 //echo $sentencia;
		 $consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		 {
			 if($fila['id']<= $this->ticket_final_id){
				 if($fila['estado']==1){
					 $this->aplicar_cambio_etiqueta($fila['id'],$etiqueta,$impreso);
					 	$etiqueta++;
				 }else{
					 $this->aplicar_cambio_etiqueta($fila['id'],0,1);
				 }
			 }else{
				 $this->aplicar_cambio_etiqueta($fila['id'],$etiqueta,1);
					$etiqueta++;
			 }
		 }
		  $this->cambiar_etiqueta_general($etiqueta);
		  $this->apicar_cambio_corte($corte_ini,$corte_fin);
	 }
	 function aplicar_cambio_etiqueta($id,$etiqueta,$impreso){
		 $sentencia = "UPDATE `ticket` SET
		`etiqueta` = '$etiqueta',
		`impreso` = '$impreso'
		WHERE `id` = '$id';";
		 $comentario="Aplicar Cambio de las etiquetas ";
		 //echo $sentencia.'</br>';
		 $consulta= $this->realizaConsulta($sentencia,$comentario);
	 }
	 function apicar_cambio_corte($corte_ini,$corte_fin){
		 $sentencia = "UPDATE `corte` SET
		`estado` = '1'
		WHERE `id` >= '$corte_ini' AND `id` <= '$corte_fin' ;";
		$comentario="Recojer el id del limpieza anterior";

		$consulta= $this->realizaConsulta($sentencia,$comentario);

	 }
	 function cambiar_etiqueta_general($etiqueta){
		 $sentencia = "UPDATE `labels` SET
			`ticket` = '$etiqueta'
			WHERE `id` = '1';";
		 $comentario="Recojer el id del limpieza anterior";
		 //echo $sentencia.'</br>';
		 $consulta= $this->realizaConsulta($sentencia,$comentario);
	 }
	 function ticket_inicial($id){
 		$sentencia = "SELECT tiket_ini FROM  corte WHERE id = $id LIMIT 1 ";
 		$comentario="Seleccionar el primer ticket";
 		$consulta= $this->realizaConsulta($sentencia,$comentario);
 		while ($fila = mysqli_fetch_array($consulta))
 		{
 			$this->ticket_inicial_id=$fila['tiket_ini'];
 		}
 	}
 	function ticket_final($id){
 		$sentencia = "SELECT tiket_fin FROM  corte WHERE id = $id LIMIT 1 ";
 		$comentario="Seleccionar el ultimo ticket";
 		$consulta= $this->realizaConsulta($sentencia,$comentario);
 		while ($fila = mysqli_fetch_array($consulta))
 		{
 			$this->ticket_final_id=$fila['tiket_fin'];
 		}
 	}
	function cantida_renta($id_ini, $id_fin,$tarifa){

		$total=0;
		$sentencia = "SELECT SUM(cantidad) AS total FROM concepto LEFT JOIN ticket ON concepto.ticket = ticket.id WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 1 AND concepto.categoria = $tarifa AND  ticket.estado=1;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function cantidad_horas($id_ini, $id_fin){
		$total=0;
		$sentencia = "SELECT SUM(concepto.total) AS total  FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 5 AND  ticket.estado=1;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}


	function cantidad_personas($id_ini, $id_fin){
		$total=0;
		$sentencia = "SELECT SUM(concepto.total) AS total  FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 4 AND  ticket.estado=1;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function cantidad_Restaurante($id_ini, $id_fin){
		$total=0;
		$sentencia = "SELECT SUM(concepto.total) AS total  FROM concepto  LEFT JOIN ticket ON concepto.ticket = ticket.id WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 2 AND  ticket.estado=1;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
	function total_renta($id_ini, $id_fin,$tarifa){

		$total=0;
		$sentencia = "SELECT SUM(concepto.total) AS total FROM concepto LEFT JOIN ticket ON concepto.ticket = ticket.id WHERE concepto.ticket >= $id_ini AND concepto.ticket <=$id_fin AND concepto.tipocargo = 1 AND concepto.categoria = $tarifa AND  ticket.estado=1;";
		$comentario="Obtener el total del  de hospedaje";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$total=$fila['total'];
		}
		if($total>0){

		}else{
			$total=0;
		}
		return $total;
	}
 }
class Cortes_limpieza extends ConexionMYSql
{
	public $corte_inicial_id;
	public $corte_inicial_etiqueta;
	public $corte_final_id;
	public $corte_final_etiqueta;
	public $ticket_inicial_id;
	public $ticket_inicial_etiqueta;
	public $ticket_final_id;
	public $ticket_final_etiqueta;
	public $cantidad_tickets;
	public $tickets_id=array();
	public $tickets_fecha=array();
	public $tickets_etiqueta=array();
	public $tickets_total=array();
	public $tickets_tarjeta=array();
	public $tickets_habitacion=array();
	public $tickets_tipo=array();
	public $tickets_facturado=array();
	public $tickets_conservar=array();
	public $cantidad_hospedaje;
	public $cantidad_consumo;
	public $total_hospedaje;
	public $total_consumo;

	public $contador;

	function __construct()
	{
		$this->obtenercorteinicial();
	}
	function obtenercorteinicial(){
		$sentencia = "SELECT * FROM corte WHERE estado = 0 ORDER BY id DESC ";
		$comentario="Seleccionar el corte inicial ";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->corte_inicial_id=$fila['id'];
			$this->corte_inicial_etiqueta=$fila['etiqueta'];
		}
	}
	function cargar_datos_faltantes($horas,$personas,$corte_final, $hospedaje,$consumo){
		$this->contador=0;
		$this->ticket_inicial($this->corte_inicial_id);
		$this->ticket_final($corte_final);
		$this->ticket_inicial_etiqueta=$this->ticket_etiqueta($this->ticket_inicial_id);
		$this->ticket_final_etiqueta=$this->ticket_etiqueta($this->ticket_final_id);
		$this->cantidad_tickes($this->ticket_inicial_id,$this->ticket_final_id);
		$this->cambiar_estado_global($this->ticket_inicial_id,$this->ticket_final_id);
		$this->cargar_info($this->ticket_inicial_id,$this->ticket_final_id,$horas,$personas);

	}
	function cambiar_estado_global($id_ini,$id_fin){
		$sentencia = "UPDATE `ticket` SET
		`estado` = '2'
		WHERE `id` >= '$id_ini' AND `id` <= '$id_fin';";
		$comentario="cambiar el estado de los tickets";
		$consulta= $this->realizaConsulta($sentencia,$comentario);

	}
	function cambiar_estado_individual($id_ini){
		$sentencia = "UPDATE `ticket` SET
		`estado` = '1'
		WHERE `id` = '$id_ini';";
		$comentario="cambiar el estado de los tickets";
		$consulta= $this->realizaConsulta($sentencia,$comentario);

	}
	function cargar_info($id_ini,$id_fin,$horas,$personas){
		$sentencia = "SELECT * FROM ticket WHERE id >= $id_ini AND id <= $id_fin AND (resta = 0 OR resta = 1 ";
		if($horas=='true'){
			$sentencia=$sentencia." OR resta = 2";
		}
		if($personas=='true'){
			$sentencia=$sentencia." OR resta = 3";
		}
			$sentencia=$sentencia." );";
		//echo $sentencia;
		$comentario="Obtener informacion de los tickets";
		$this->total_consumo=0;
		$this->total_hospedaje=0;
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			 $this->tickets_id[$this->contador]=$fila['id'];
			 $this->tickets_etiqueta[$this->contador]=$fila['etiqueta'];
			 $this->tickets_tipo[$this->contador]=$fila['resta'];
			 $this->tickets_total[$this->contador]=$fila['total'];
			 $this->tickets_fecha[$this->contador]=$fila['fecha'];
			 $this->tickets_facturado[$this->contador]=$fila['facturado'];
			 $this->tickets_tarjeta[$this->contador]=$fila['tarjeta'];
			 $this->tickets_habitacion[$this->contador]=$fila['habitacion'];
			 $this->tickets_conservar[$this->contador]=0;
			 $this->contador++;
			 if($fila['resta']==1){
				 $this->cantidad_consumo++;
				 $this->total_consumo= $this->total_consumo+$fila['total'] ;
			 }else{
				 $this->cantidad_hospedaje++;
				 $this->total_hospedaje= $this->total_hospedaje+$fila['total'] ;
				 //$this->total_hospedaje= $this->total_hospedaje+ $this->tickets_total[$this->contador];
			 }


		}
	}
	function ticket_inicial($id){
		$sentencia = "SELECT tiket_ini FROM  corte WHERE id = $id LIMIT 1 ";
		$comentario="Seleccionar el primer ticket";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->ticket_inicial_id=$fila['tiket_ini'];
		}
	}
	function ticket_final($id){
		$sentencia = "SELECT tiket_fin FROM  corte WHERE id = $id LIMIT 1 ";
		$comentario="Seleccionar el primer ticket";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->ticket_final_id=$fila['tiket_fin'];
		}
	}
	function cantidad_tickes($id_ini,$id_fin){
		$total = 0;
		$sentencia = "SELECT COUNT(*) AS total FROM ticket WHERE id >= $id_ini AND id <= $id_fin  ";
		$comentario="Seleccionar la cantidad de ticket";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$this->cantidad_tickets=$fila['total'];
		}
	}
	function ticket_etiqueta($id){
		$etiqueta=0;
		$sentencia = "SELECT etiqueta FROM ticket  WHERE id = $id LIMIT 1 ";
		$comentario="Obtener la etiqueta del ticket";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$etiqueta=$fila['etiqueta'];
		}
		return $etiqueta;
	}
}

  class Corte_ver extends ConexionMYSql
  {
  	function __construct()
    {

    }
    function ver_cortes(){
    	$sentencia = "SELECT * FROM corte WHERE estado = 0 ORDER BY id DESC ";
		$comentario="Obtener los cortes hechos";
		$consulta= $this->realizaConsulta($sentencia,$comentario);

			 echo '<div class="table-responsive">
		        <table class="table">
		          <thead>
		            <tr>
		              <th>Corte</th>
		              <th>Total</th>
		              <th>Efectivo</th>
		              <th>Tarjeta</th>
		              <th>Descuento</th>
		              <th>Ver</th>
		            </tr>
		          </thead>
		          <tbody>';
		      while ($fila = mysqli_fetch_array($consulta))
		      {
		        echo '<tr>
		        <td>'.$fila['etiqueta'].'</td>
		        <td>'.$fila['total'].'</td>
		        <td>'.$fila['efectivo'].'</td>
		        <td>'.$fila['tarjeta'].'</td>
		        <td>'.$fila['descuento'].'</td>
		        <td><button onclick="mostrar_corte_hecho('.$fila['etiqueta'].')" class="btn btn-info">Ver pdf</button></td>
		      </tr>';
		    }

		        echo '</table>
		          </div>';

    }
		function ver_reportes_hecho(){
    	$sentencia = "SELECT * FROM limpieza ORDER BY id DESC ";
		$comentario="Obtener los cortes hechos";
		$consulta= $this->realizaConsulta($sentencia,$comentario);

			 echo '<div class="table-responsive">
		        <table class="table">
		          <thead>
		            <tr>
		              <th>Reporte</th>
		              <th>Fecha</th>
		              <th>Primer corte</th>
		              <th>Ultimo Corte</th>

		              <th>Ver</th>
		            </tr>
		          </thead>
		          <tbody>';
		      while ($fila = mysqli_fetch_array($consulta))
		      {
		        echo '<tr>
		        <td>'.$fila['id'].'</td>
		        <td>'.date('Y-m-d',$fila['fecha']).'</td>
		        <td>'.$fila['corte_ini'].'</td>
		        <td>'.$fila['corte_fin'].'</td>
		        <td><button onclick="mostrar_reporte_hecho('.$fila['id'].')" class="btn btn-info">Ver pdf</button></td>
		      </tr>';
		    }

		        echo '</table>
		          </div>';

    }
  }
  class Corte_info extends ConexionMYSql
  {
  	public $trabajor=array();
    public $hab_cantidad=array();
		public $hab_cantidad_cortesias=array();
    public $hab_precio=array();
    public $hab_total=array();



    public $tipo_restaurante=array();
		public $global_restaurante=array();
    public $total_restaurante=array();

	public $producto_nombre=array();
    public $producto_venta=array();
	public $producto_inventario=array();

	public $gasto_nombre=array();
  public $gasto_venta=array();


	public $total_personas;
	public $total_horas;
	public $total_gastos;

	public $total_efectivo;
	public $total_tarjeta;
	public $total_cortesia;
	public $ticket_primero_etiqueta;
	public $ticket_fin_etiqueta;


	public $num_corte=0;

  	function __construct($id_ini,$id_fin)
    {
			$this->ticket_primero_etiqueta=$this->obtener_etiqueta($id_ini);
			$this->ticket_fin_etiqueta=$this->obtener_etiqueta($id_fin);
			;
    	//Obtenemos el total de las horas y las personas extras
    	$this->total_horas=$this->cantidad_horas($id_ini, $id_fin);
    	$this->total_personas=$this->cantidad_personas($id_ini, $id_fin);
    	//Obtener el total de dinero ingresado
    	$this->cantidad_dinero($id_ini, $id_fin);
    	//obtener corte
    	//$this->num_corte = $this->obtener_corte();
    	//obtenemos la cantidad y el total de los cuartos rentados
    	$contador=0;
    	$sentencia = "SELECT * FROM usuario WHERE activo = 1 AND nivel >= 3 AND nivel <= 4;";
	    $comentario="Obtener trabajadores";
	    $consulta= $this->realizaConsulta($sentencia,$comentario);
	    while ($fila = mysqli_fetch_array($consulta))
	    {
				$venta = $this->saber_total_por_trabajador($fila['id']);
				if($venta>0){
					$this->trabajor[$contador]=$fila['usuario'];
		    	$this->hab_total[$contador]=$venta ;
		    	$contador++;
				}

	    	//echo $this->hab_tipo[$contador];
	    }
	    //function obtenemos el total del hospedaje
	   /* $contador=0;
    	$sentencia = "SELECT * FROM  tarifa_hospedaje;";
	    $comentario="Obtener las tarifas de hospedaje";
	    $consulta= $this->realizaConsulta($sentencia,$comentario);
	    while ($fila = mysqli_fetch_array($consulta))
	    {
	    	$this->hab_tipo_hospedaje[$contador]=$fila['nombre'];
	    	$this->hab_precio_hospedaje[$contador]=$fila['precio_hospedaje'];
	    	$this->hab_cantidad_hospedaje[$contador]=$this->cantida_hospedaje($id_ini,$id_fin,$fila['id']);
	    	$this->hab_total_hospedaje[$contador]=$this->total_hospe($id_ini,$id_fin,$fila['id']);
	    	$contador++;
	    	//echo $this->hab_tipo[$contador];
	    }
*/
	    //obtenemos el total del restaurante
	    $contador=0;
			for($z = 0; $z <4; $z++){
				$this->global_restaurante[$z]=0;
			}
    	$sentencia = "SELECT * FROM  categoria_inventario;";
	    $comentario="Obtener las tarifas de hospedaje";
	    $consulta= $this->realizaConsulta($sentencia,$comentario);
	    while ($fila = mysqli_fetch_array($consulta))
	    {
	    	$this->tipo_restaurante[$contador]=$fila['nombre'];


	    	$this->total_restaurante[$contador]=$this->total_restaurante($id_ini,$id_fin,$fila['id']);
				//$this->global_restaurante[$fila['global']]=$this->global_restaurante[$fila['global']]+$this->total_restaurante($id_ini,$id_fin,$fila['id']);
	    	$contador++;
	    	//echo $this->hab_tipo[$contador];
	    }


	    $contador=0;
    	$sentencia = "SELECT * FROM gasto WHERE estado  = 0;";
	    $comentario="Obtener los gastos del corte";
	    $consulta= $this->realizaConsulta($sentencia,$comentario);
	    while ($fila = mysqli_fetch_array($consulta))
	    {
	    	$this->gasto_nombre[$contador]=$fila['nombre'];
	    	$this->gasto_venta[$contador]=$fila['total'];
	    	$contador++;

	    }

		$contador=0;
    	$sentencia = "SELECT * FROM producto ORDER BY categoria , nombre";
	    $comentario="Obtener el inventario";
	    $consulta= $this->realizaConsulta($sentencia,$comentario);
	    while ($fila = mysqli_fetch_array($consulta))
	    {
	    	$this->producto_nombre[$contador]=$fila['nombre'];
	    	$this->producto_venta[$contador]=$this->venta_producto($id_ini, $id_fin,$fila['nombre']);
			$this->producto_inventario[$contador]=$fila['inventario'];
	    	$contador++;
	    	//echo $this->hab_tipo[$contador];
	    }
	    $sentencia = "SELECT SUM(total) AS TOTAL FROM gasto WHERE estado = 0";
	    $comentario="Obtener gastos";
	    $this->total_gastos=0;
	    $consulta= $this->realizaConsulta($sentencia,$comentario);
	    while ($fila = mysqli_fetch_array($consulta))
	    {
	    	$this->total_gastos=$this->total_gastos+$fila['TOTAL'];

	    }
    }
		function saber_total_por_trabajador($id){
			$total=0;
			$sentencia = "SELECT SUM(total) AS total FROM ticket WHERE trabajador = $id AND estado  =  0";
			$comentario="Obtener las ventas por trabajador";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total=$fila['total'];

			}
			return $total;
		}
		function obtener_etiqueta($id){
			$etiqueta=0;
			$sentencia = "SELECT etiqueta FROM ticket WHERE id = $id LIMIT 1 ";
			$comentario="Obtener la etiqueta del ticket";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$etiqueta=$fila['etiqueta'];

			}
			return $etiqueta;
		}
    function obtener_corte(){
    	$corte=1;
		$sentencia = "SELECT corte FROM labels  WHERE id = 1 LIMIT 1 ";
		$comentario="Obtener el numero de corte";
		$consulta= $this->realizaConsulta($sentencia,$comentario);
		while ($fila = mysqli_fetch_array($consulta))
		{
			$corte=$fila['corte'];
			$new_corte=$fila['corte']+1;
		}
		$sentencia = "UPDATE `labels` SET
		`corte` = '$new_corte'
		WHERE `id` = '1';";
		$comentario="actualizar el numero de corte";
		 $this->realizaConsulta($sentencia,$comentario);
		return $corte;
    }
    function venta_producto($id_ini, $id_fin,$nombre){
    	$total=0;
			$sentencia = "SELECT SUM(cantidad) AS cantidad FROM concepto WHERE ticket >= $id_ini AND ticket <= $id_fin AND nombre  = '$nombre'";
			$comentario="Obtener el total del  producto vendido";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total=$fila['cantidad'];
			}
			if($total>0){

			}else{
				$total=0;
			}
			return $total;
    }
    function cantidad_dinero($id_ini, $id_fin){
    		$this->total_efectivo=0;
			$this->total_tarjeta=0;
			$this->total_cortesia=0;
			$sentencia = "SELECT SUM(total) AS total , SUM(tarjeta) AS tarjeta , SUM(descuento) AS descuento FROM ticket WHERE id >= $id_ini AND id <= $id_fin";
			$comentario="Obtener el total de dinero ingresado";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$this->total_efectivo=$fila['total']-$fila['tarjeta']-$fila['descuento'];
				$this->total_tarjeta=$fila['tarjeta'];
				$this->total_cortesia=$fila['descuento'];
			}

    	}
    	function cantidad_horas($id_ini, $id_fin){
    		$total=0;
			$sentencia = "SELECT SUM(total) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 5";
			$comentario="Obtener el total del  de hospedaje";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total=$fila['total'];
			}
			if($total>0){

			}else{
				$total=0;
			}
			return $total;
    	}
    	function cantidad_personas($id_ini, $id_fin){
    		$total=0;
			$sentencia = "SELECT SUM(total) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 4";
			$comentario="Obtener el total del  de hospedaje";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total=$fila['total'];
			}
			if($total>0){

			}else{
				$total=0;
			}
			return $total;
    	}
		function cantida_renta_cortesias($tarifa){
			$total=0;
			$sentencia = "SELECT SUM(cantidad) AS total FROM cortesia WHERE estado = 0 AND tarifa  = $tarifa";
			$comentario="Obtener el total del  de hospedaje";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total=$fila['total'];
			}
			if($total>0){

			}else{
				$total=0;
			}
			return $total;


		}
		function cantida_renta($id_ini, $id_fin,$tarifa){

			$total=0;
			$sentencia = "SELECT SUM(cantidad) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 1 AND categoria = $tarifa";
			$comentario="Obtener el total del  de hospedaje";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total=$fila['total'];
			}
			if($total>0){

			}else{
				$total=0;
			}
			return $total;
		}
		function cantida_renta_total($id_ini, $id_fin){

			$total=0;
			$sentencia = "SELECT cantidad FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 1";
			//echo $sentencia;
			$comentario="Obtener el total del  de hospedaje";
			$consulta= ConexionMYSql::realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total++;
			}
			if($total>0){

			}else{
				$total=0;
			}
			return $total;
		}
		function cantida_hospedaje($id_ini, $id_fin,$tarifa){

			$total=0;
			$sentencia = "SELECT SUM(cantidad) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 3 AND categoria = $tarifa";
			$comentario="Obtener el total del  de hospedaje";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total=$fila['total'];
			}
			if($total>0){

			}else{
				$total=0;
			}
			return $total;
		}
		function total_renta($id_ini, $id_fin,$tarifa){

			$total=0;
			$sentencia = "SELECT SUM(total) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 1 AND categoria = $tarifa";
			$comentario="Obtener el total del  de hospedaje";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total=$fila['total'];
			}
			if($total>0){

			}else{
				$total=0;
			}
			return $total;
		}
		function total_hospe($id_ini, $id_fin,$tarifa){

			$total=0;
			$sentencia = "SELECT SUM(total) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 3 AND categoria = $tarifa";
			$comentario="Obtener el total del  de hospedaje";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total=$fila['total'];
			}
			if($total>0){

			}else{
				$total=0;
			}
			return $total;
		}
		function total_restaurante($id_ini, $id_fin,$tarifa){

			$total=0;
			$sentencia = "SELECT SUM(total) AS total  FROM concepto  WHERE ticket >= $id_ini AND ticket <=$id_fin AND tipocargo = 2 AND categoria = $tarifa";
			$comentario="Obtener el total del  de hospedaje";
			$consulta= $this->realizaConsulta($sentencia,$comentario);
			while ($fila = mysqli_fetch_array($consulta))
			{
				$total=$fila['total'];
			}
			if($total>0){

			}else{
				$total=0;
			}
			return $total;
		}
		function cambiar_estado_ticket($id_ini, $id_fin){
			$sentencia = "UPDATE `ticket` SET
			`estado` = '1'
			WHERE `id` >= '$id_ini' AND `id` <= '$id_fin';";
			$comentario="Cambiar el estado de los tickets";
			 $this->realizaConsulta($sentencia,$comentario);
		}
		function cambiar_estado_gastos(){
			$sentencia = "UPDATE `gasto` SET
			`estado` = '1'
			WHERE `estado` = '0';";
			$comentario="Cambiar el estado de los gastos";
			 $this->realizaConsulta($sentencia,$comentario);
		}
		function cambiar_estado_cortesias(){
			$sentencia = "UPDATE `cortesia` SET
			`estado` = '1'
			WHERE `estado` = '0';";
			$comentario="Cambiar el estado de los gastos";
			 $this->realizaConsulta($sentencia,$comentario);
		}
		function guardar_corte($etiqueta,$total,$efectivo,$tarjeta,$descuento,$cuartos,$hospedaje,$restaurante,$personas,$horas,$monedas,$billete_20,$billete_50,$billete_100,$billete_200,$billete_500,$billete_1000,$diferiencia,$id_ini, $id_fin){
			$sentencia = "INSERT INTO `corte` (`estado`, `etiqueta`, `total`, `efectivo`,`tarjeta`, `descuento`, `cuartos`, `hospedaje`, `restaurante`, `personas`, `horas`, `monedas`, `billete_20`, `billete_50`, `billete_100`, `billete_200`, `billete_500`, `billete_1000`, `diferiencia`,`tiket_ini`, `tiket_fin`)
				VALUES ('0', '$etiqueta', '$total', '$efectivo', '$tarjeta','$descuento', '$cuartos', '$hospedaje', '$restaurante', '$personas','$horas', '$monedas', '$billete_20', '$billete_50', '$billete_100', '$billete_200', '$billete_500', '$billete_1000', '$diferiencia', '$id_ini', '$id_fin' );";
			$comentario="Guardar corte";
			$this->realizaConsulta($sentencia,$comentario);

		}
  }
?>
