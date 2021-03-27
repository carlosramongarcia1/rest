var x;
var intervalo=1000;
var error=0;
var corte=0;
x=$(document);
x.ready(inicio);

function inicio(){
	var x=$("#login");
	x.click(evaluar);
}
function sabersession(){
	var id=localStorage.getItem("id");
	if(id==null){
		$('#entrada_formulario').show();
	}else{
		id=parseInt(id);
		if(id>0){
			document.location.href='inicio.php';

		}
	}
}
function sabernosession(){
	var id=localStorage.getItem("id");

	if(id==null){
		document.location.href='index.php';
	}else{
		id=parseInt(id);
		if(id>0){
			$("#area_trabajo").load("includes/area_de_trabajo.php?id="+id);
			$(".menu").load("includes/menu.php?id="+id);
			mostrar_citas_recientes();
			//alert("Dentro");
			//$(".area_trabajo").load("includes/area_de_trabajo.php?id="+id);
		}
		else{
			document.location.href='index.php';
		}
	}
}
function cantidad_ingredientes(){
	var cantidad= encodeURI($("#cantidad").val());
	$("#area_trabajo").load("includes/hacer_calculo.php?cantidad="+cantidad);
	//alert(cantidad);
}
function hacer_calculo_porcentage(cantidad){
	var supertotal = $("#supertotal").val();
	var porcentaje = ($("#porcentaje").val()/100);
	var super_total=supertotal * (1+porcentaje);
	$("#totalporcen").val(super_total);
	//alert("  "+super_total);

}
function hacer_calculo_porcentage_inv(){
	var precio_venta = $("#precio_antes").val();
	var porcentaje = ( $("#porcentage_precio_venta").val()/100);
	var valor =  precio_venta*(1+porcentaje);
	$("#precio_venta").val(valor);
	//$("#supertotal").val(valor);
}
function hacer_calculo(cantidad){
	var supertotal=0;
	var antes = new Array(cantidad);
	var despues = new Array(cantidad);
	var precio = new Array(cantidad);
	var cantidad_producto = new Array(cantidad);
	var total = new Array(cantidad);
	var merma = new Array(cantidad);
	var porcion = new Array(cantidad);
	for (var i = 1; i <= cantidad; i++) {
		antes[i] = $("#antes"+i).val();
		despues[i] = $("#despues"+i).val();
		precio[i] = $("#precio"+i).val();
		cantidad_producto[i] = $("#cantidad_producto"+i).val();

		

		
		if(antes[i].length<=0) {
			antes[i]=0;
			
		}
		if(despues[i].length<=0) {
			despues[i]=0;
			
		}
		if(precio[i].length<=0) {
			precio[i]=0;
			
		}
		if(cantidad_producto[i].length<=0) {
			cantidad_producto[i]=0;
			
		}
		
		merma[i] = antes[i] - despues[i];
		if(merma[i]<=0){
			merma[i]=0;
		}
		porcion[i] = despues[i]/cantidad_producto[i];
		if(porcion[i]<=0){
			porcion[i]=0;
		}
		total[i]=precio[i]/porcion[i];
		if(total[i]<=0){
			total[i]=0;
		}
		supertotal=supertotal+total[i];
		$("#total"+i).val(total[i]);
		$("#porcion"+i).val(porcion[i]);
		$("#merma"+i).val(merma[i]);
		//alert(antes[i]);
	 }
	 $("#supertotal").val(supertotal);
	//alert(cantidad);

}
function evaluar(){
	var user=$("#user").val();
	var pass=$("#pass").val();
	var datos = {
		  "usuario": user,
		  "password": pass,
		};
	 $.ajax({
		  async:true,
		  type: "POST",
		  dataType: "html",
		  contentType: "application/x-www-form-urlencoded",
		  url:"includes/evaluar.php",
		  data:datos,
		  beforeSend:inicioEnvio,
		  success:recibir,
			//success:problemas_hab,
		  timeout:5000,
		  error:problemas
		});
	return false;
}
function inicioEnvio(){

  $("#renglon_entrada_mensaje").html('<strong id="mensaje_error" class="alert alert-info"><span class="glyphicon glyphicon-resize-small"></span> Estamos evaluando datos</strong>');
}
function problemas(){

  $("#renglon_entrada_mensaje").html('<strong id="mensaje_error" class="alert alert-danger" ><span class="glyphicon glyphicon-wrench"></span> Problemas en el servidor.</strong>');
}
function recibir(datos){
	//$("#renglon_entrada_mensaje").html(datos);
	var id=parseInt(datos);
	if(id>=1){
		localStorage.setItem("id",id);
		document.location.href='inicio.php';
	}else{
		$("#renglon_entrada_mensaje").html('<strong id="mensaje_error" class="alert alert-warning"><span class="glyphicon glyphicon-remove"></span> Creo que has escrito mal tu usuario o contraseña </strong>');
	}
}
function salirsession(){
	localStorage.removeItem('id');
	document.location.href='index.php';
}
function usiario(){
	alert("Menu de usuario");
}
function  ver_alerta_citas(){
	$("#area_trabajo").load("includes/ver_alerta_citas.php");
}
function calcular_precio(){
	$("#area_trabajo").load("includes/calcular_precio.php");
}
function ver_usuarios(){
	$("#area_trabajo").load("includes/ver_usuarios.php");
}
function agregar_usuarios(){
	$("#area_trabajo").load("includes/agregar_usuarios.php");
}
function agregar_inventario(){
	$("#area_trabajo").load("includes/guardar_inventario.php");
}
function ver_inventario(){
	$("#area_trabajo").load("includes/ver_inventario.php");
}
function ver_cetogoria_inventario(){
	$("#area_trabajo").load("includes/ver_cetogoria_inventario.php");
}
function editar_inventario(id){
	$("#area_trabajo").load("includes/editar_inventario.php?id="+id);
}
function surtir_inventario(){
	$("#area_trabajo").load("includes/surtir_inventario.php");
}
function ver_precorte(){
	$("#area_trabajo").load("includes/ver_precorte.php");
}
function ver_cortes_hechos(){
	$("#area_trabajo").load("includes/ver_cortes_hechos.php");
}
function ver_gastos(){
	$("#area_trabajo").load("includes/ver_gastos.php");
}
function ver_citas(){
	$("#area_trabajo").load("includes/ver_citas.php");
}
function aplicar_inventario_surtir(){
	 ver_inventario();
	window.open("includes/surtir_inventario_ver.php", "Diseño Web", "width=800, height=400");

}
function citas_mostrar_info(id,fecha,trabajador){
	$("#section").load("includes/citas_mostrar_info.php?fecha="+fecha+"&trabajador="+trabajador+"&id="+id);
}
function citas_asignar(fecha,trabajador){
	//alert("dentro");
	$("#section").load("includes/citas_asignar.php?fecha="+fecha+"&trabajador="+trabajador);
}
function guardar_agendar(tiempo,trabajador){
	var cliente=encodeURI($("#cliente").val());
	var telefono=encodeURI($("#telefono").val());
	var email=encodeURI($("#email").val());
	var cantidad_tiempo=$("#cantidad_tiempo").val();
	var titulo=encodeURI($("#titulo").val());
	var descripcion=encodeURI($("#descripcion").val());

	if((cliente.length>0)&&(telefono.length>0)&&(email.length>0)){
		$('#buscar_cliente').hide();
		$("#section").load("includes/guardar_agendar.php?tiempo="+tiempo+"&trabajador="+trabajador+"&cliente="+cliente+"&telefono="+telefono+"&email="+email+"&cantidad_tiempo="+cantidad_tiempo+"&titulo="+titulo+"&descripcion="+descripcion);
	}else{
		alert("Datos Imcompletos");
	}
}
function cambio_fecha(trabajador){
	var tiempo=$("#tiempo").val();

	$("#area_trabajo").load("includes/ver_citas.php?tiempo="+tiempo+"&trabajador="+trabajador);
}
function cambio_trabajador(trabajador){
	var tiempo=$("#tiempo").val();

	$("#area_trabajo").load("includes/ver_citas.php?tiempo="+tiempo+"&trabajador="+trabajador);
}
function buscar_inventario(){
	var busqueda=$("#busqueda").val();
	$("#tabla_inventario").load("includes/busqueda_inbentario.php?busqueda="+busqueda);
}
function buscar_surtir(){
	var busqueda=$("#busqueda").val();
	$("#tabla_surtir").load("includes/busqueda_surtir.php?busqueda="+busqueda);
}
function borrar_gasto(id){

		var datos = {
		  "id": id,
		};
	 $.ajax({
		  async:true,
		  type: "POST",
		  dataType: "html",
		  contentType: "application/x-www-form-urlencoded",
		  url:"includes/borrar_gasto.php",
		  data:datos,
		  beforeSend:loaderbar,
		  //success:problemas_hab,
		  success:ver_gastos,
		  timeout:5000,
		  error:problemas
		});
	return false;
}
function guardar_gasto(){
	var nombre=$("#gasto_nombre").val();
	var total=$("#gasto_total").val();
	var id=localStorage.getItem("id");
	if(total>0){
		var datos = {
		  "nombre": nombre,
		  "total": total,
		  "id": id,
		};
	 $.ajax({
		  async:true,
		  type: "POST",
		  dataType: "html",
		  contentType: "application/x-www-form-urlencoded",
		  url:"includes/guardar_gasto.php",
		  data:datos,
		  beforeSend:loaderbar,
		  //success:problemas_hab,
		  success:ver_gastos,
		  timeout:5000,
		  error:problemas
		});
	return false;
	}else{
		alert("Cantidad insuficiente");
	}
}
function borrar_inventario_surtir(id){
		var datos = {
				"producto": id,
			};
		$.ajax({
			  async:true,
			  type: "POST",
			  dataType: "html",
			  contentType: "application/x-www-form-urlencoded",
			  url:"includes/borrar_inventario_surtir.php",
			  data:datos,
				beforeSend:loaderbar,
			  success:surtir_inventario,
			  //success:problemas_hab,
			  timeout:4000,
			  error:problemas_hab
			});
		return false;
}
function inventario_surtir(producto){
	var cant= "cantidad"+producto;
  var cantidad_producto= document.getElementById(cant).value;
	if(cantidad_producto>0){
		var datos = {
				"producto": producto,
			  "cantidad_producto": cantidad_producto,
			};
		$.ajax({
			  async:true,
			  type: "POST",
			  dataType: "html",
			  contentType: "application/x-www-form-urlencoded",
			  url:"includes/inventario_surtir.php",
			  data:datos,
				beforeSend:loaderbar,
			  success:surtir_inventario,
			  //success:problemas_hab,
			  timeout:4000,
			  error:problemas_hab
			});
		return false;
	}else{
		alert("Cantidad insuficiente");
	}
}
function borrar_inventario(id,nombre){

	var r = confirm("¿Realmente desea borrar "+nombre+" del inventario?");
	if (r == true) {
		var datos = {
					"id": id,
				};
			$.ajax({
					async:true,
					type: "POST",
					dataType: "html",
					contentType: "application/x-www-form-urlencoded",
					url:"includes/borrando_inventario.php",
					data:datos,
					beforeSend:loaderbar,
					success:ver_inventario,
					timeout:5000,
					error:problemas_hab
				});
			return false;
	}


}
function editar_producto(id){
	var nombre= document.getElementById("nombre").value;
	var categoria= document.getElementById("categoria").value;
	var precio_venta= document.getElementById("precio_venta").value;
	var precio_compra= document.getElementById("precio_compra").value;
	var stock= document.getElementById("stock").value;
	var inventario= document.getElementById("inventario").value;
	var bodega_stock= document.getElementById("bodega_stock").value;
	var bodega_inventario= document.getElementById("bodega_inventario").value;
	var clave= document.getElementById("clave").value;

	if(nombre.length >0 &&  precio_venta >0 &&  precio_compra >0 &&  stock >0 &&  inventario >0 &&  bodega_stock >=0 &&  bodega_inventario >=0){
		var datos = {
				"id": id,
			  "nombre": nombre,
			  "categoria": categoria,
				"precio_venta": precio_venta,
				"precio_compra": precio_compra,
				"stock": stock,
				"inventario": inventario,
				"bodega_stock": bodega_stock,
				"bodega_inventario": bodega_inventario,
				"clave": clave,
			};
		$.ajax({
			  async:true,
			  type: "POST",
			  dataType: "html",
			  contentType: "application/x-www-form-urlencoded",
			  url:"includes/aplicar_editar_producto.php",
			  data:datos,
				beforeSend:loaderbar,
			  success:ver_inventario,
				//success:problemas_hab,
			  timeout:5000,
			  error:problemas_hab
			});
		return false;
	}else{
		alert("Campos incompletos");
	}
}
function guardar_usuario(){
	var usuario= document.getElementById("usuario").value;
	var contrasena= document.getElementById("contrasena").value;
	var recontrasena= document.getElementById("recontrasena").value;
	var nivel= document.getElementById("nivel").value;


	if(usuario.length >0 && contrasena.length >0){
		if(contrasena == recontrasena){
			var datos = {
				  "usuario": usuario,
					"contrasena": contrasena,
					"recontrasena": recontrasena,
					"nivel": nivel,
				};
			$.ajax({
				  async:true,
				  type: "POST",
				  dataType: "html",
				  contentType: "application/x-www-form-urlencoded",
				  url:"includes/guardar_usuario.php",
				  data:datos,
					beforeSend:loaderbar,
				  success:ver_usuarios,
				  timeout:5000,
				  error:problemas_hab
				});
			return false;
		}else{
			alert("Las contraseñas no coinciden");
		}

	}else{
		alert("Campos incompletos");
	}
}
function loaderbar(){
	$("#area_trabajo").load("includes/barra_progreso.php");
}
function problemas_hab(datos){
	alert("Ocurrio algun error en el proceso.  Inf: "+datos.toString());
}
function borrar_usuario(id){
	var r = confirm("¿Borrar Usuario?");
	if (r == true) {
		var datos = {
				"id": id,
			};
		$.ajax({
				async:true,
				type: "POST",
				dataType: "html",
				contentType: "application/x-www-form-urlencoded",
				url:"includes/borrar_usuario.php",
				data:datos,
				beforeSend:loaderbar,
				success:ver_usuarios,
				timeout:5000,
				error:problemas_hab
			});
		return false;
	}
}
function guardar_cetogoria_inventario(){
	var categoria=$("#nombre_categoria").val();
	if(categoria.length>1){
		var datos = {
		  "categoria": categoria,
		};
	$.ajax({
		  async:true,
		  type: "POST",
		  dataType: "html",
		  contentType: "application/x-www-form-urlencoded",
		  url:"includes/guardar_cetogoria_inventario.php",
		  data:datos,
			beforeSend:loaderbar,
		  success:ver_cetogoria_inventario,
		  timeout:5000,
		  error:problemas_hab
		});
	return false;
	}else{
		alert("Sin informacion a guardar ");
	}
}
function guardar_producto(){
	var nombre= document.getElementById("nombre").value;
	var categoria= document.getElementById("categoria").value;
	var precio_venta= document.getElementById("precio_venta").value;
	var precio_compra= document.getElementById("precio_compra").value;
	var stock= document.getElementById("stock").value;
	var inventario= document.getElementById("inventario").value;
	var bodega_stock= document.getElementById("bodega_stock").value;
	var bodega_inventario= document.getElementById("bodega_inventario").value;
	var clave= document.getElementById("clave").value;

	if(nombre.length >0 &&  precio_venta >0 &&  precio_compra >0 &&  stock >0 &&  inventario >0 &&  bodega_stock >=0 &&  bodega_inventario >=0){
		var datos = {
			  "nombre": nombre,
			  "categoria": categoria,
				"precio_venta": precio_venta,
				"precio_compra": precio_compra,
				"stock": stock,
				"inventario": inventario,
				"bodega_stock": bodega_stock,
				"bodega_inventario": bodega_inventario,
				"clave": clave,
			};
		$.ajax({
			  async:true,
			  type: "POST",
			  dataType: "html",
			  contentType: "application/x-www-form-urlencoded",
			  url:"includes/guardar_producto.php",
			  data:datos,
				beforeSend:loaderbar,
			  success:ver_inventario,
			  timeout:5000,
			  error:problemas_hab
			});
		return false;
	}else{
		alert("Campos incompletos");
	}

}
function buscar_cliente(fecha,trabajador){
	var busqueda=encodeURI($("#cliente").val());

	$("#buscar_cliente").load("includes/busqueda_cliente.php?busqueda="+busqueda+"&fecha="+fecha+"&trabajador="+trabajador);
}
function agendar(cliente, tiempo,trabajador){
	var cantidad_tiempo=$("#cantidad_tiempo").val();
	var titulo=encodeURI($("#titulo").val());
	var descripcion=encodeURI($("#descripcion").val());
	if((titulo.length>0)&&(descripcion.length>0)){
		//$('#buscar_cliente').modal('hide');
		$('#buscar_cliente').hide();
		$("#section").load("includes/agendar_citas.php?tiempo="+tiempo+"&trabajador="+trabajador+"&cliente="+cliente+"&cantidad_tiempo="+cantidad_tiempo+"&titulo="+titulo+"&descripcion="+descripcion);
	}else{
		alert("Falta ingresar algun campo");
	}

}
function eliminar_cita(id){
	var r = confirm("¿Esta seguro de eliminar la cita?");
	if (r == true) {
	  $("#section").load("includes/eliminar_cita.php?id="+id);
	}
}
function agregar_cliente(tiempo,trabajador){
	$("#buscar_cliente").load("includes/agregar_cliente.php?tiempo="+tiempo+"&trabajador="+trabajador);
}
function mostrar_categoria(categoria){
	$("#mostrar_herramientas").load("includes/busqueda_categoria.php?categoria="+categoria);

	//alert("Categoria "+ categoria);
}
function cargar_comanda(id){
	$("#comanda").load("includes/cargar_comanda.php?id="+id);
}
function agregar_comanda(id){
	$("#comanda").load("includes/agregar_comanda.php?id="+id);
}
function borrar_comanda(id){
	$("#comanda").load("includes/borrar_comanda.php?id="+id);
}
function buscar_producto(){
	var busqueda=encodeURI($("#busqueda").val());
	if(busqueda.length >0){
		$("#caja_herramientas").modal();
		$("#mostrar_herramientas").load("includes/busqueda_producto.php?busqueda="+busqueda);
		$("#busqueda").val("");
	}
}
function herramienta_comanda(comanda){
	$("#caja_herramientas").modal();
	$("#mostrar_herramientas").load("includes/herramienta_comanda.php?comanda="+comanda);
	//$("#busqueda").val("");
}
function cobrar(total){

	var id=localStorage.getItem("id");
	var pago=$("#pago").val();
	var f_pago=$("#f_pago").val();
	var barbero=$("#barbero").val();
	//var f_pago=$("#f_pago").val();
	if(isNaN(pago)){
		pago=0;
	}
	if(pago>=total){
			$('#boton_cobrar').hide();
			$("#area_trabajo").load("includes/cobrar_ticket.php?total="+total+"&pago="+pago+"&f_pago="+f_pago+"&barbero="+barbero+"&id="+id);
	}else{
		alert("Pago insuficiente");
	}

}
function limipar(){
	$("#pago").val("");
}
function sumar(cantidad){
	var pago=$("#pago").val();
	if(isNaN(pago)){
		pago=0;
	}
	//alert("pago");
//	var total = cantidad.concat(pago);
	if(pago==0){
		cantidad = cantidad;
	}else{
		cantidad = pago+cantidad;
	}

	$("#pago").val(cantidad);
}

function ver_cortes(){
	$("#area_trabajo").load("includes/guardar_efectivo.php");
}
function calcular_total(){
	var monedas=$("#monedas").val();
	var pesos20=$("#20_pesos").val();
	var pesos50=$("#50_pesos").val();
	var pesos100=$("#100_pesos").val();
	var pesos200=$("#200_pesos").val();
	var pesos500=$("#500_pesos").val();
	var pesos1000=$("#1000_pesos").val();
	if(isNaN(monedas)){
		monedas=0;
	}else{
		monedas=monedas*1;
	}
	if(isNaN(pesos20)){
		pesos20=0;
	}
	else{
		pesos20=pesos20*1;
	}
	if(isNaN(pesos50)){
		pesos50=0;
	}
	else{
		pesos50=pesos50*1;
	}
	if(isNaN(pesos100)){
		pesos100=0;
	}
	else{
		pesos100=pesos100*1;
	}
	if(isNaN(pesos200)){
		pesos200=0;
	}
	else{
		pesos200=pesos200*1;
	}
	if(isNaN(pesos500)){
		pesos500=0;
	}
	else{
		pesos500=pesos500*1;
	}
	if(isNaN(pesos1000)){
		pesos1000=0;
	}else{
		pesos1000=pesos1000*1;
	}
	var total = monedas+(pesos20*20)+(pesos50*50)+(pesos100*100)+(pesos200*200)+(pesos500*500)+(pesos1000*1000);
	$("#mostrar_total").html('$'+total);
	//alert("Carculando Total: "+total );
}
function realiza_corte(ticket_ini,ticket_fin,tipo){

	var monedas=$("#monedas").val();
	var pesos20=$("#20_pesos").val();
	var pesos50=$("#50_pesos").val();
	var pesos100=$("#100_pesos").val();
	var pesos200=$("#200_pesos").val();
	var pesos500=$("#500_pesos").val();
	var pesos1000=$("#1000_pesos").val();
	if(isNaN(monedas)){
		monedas=0;
	}else{
		monedas=monedas*1;
	}
	if(isNaN(pesos20)){
		pesos20=0;
	}
	else{
		pesos20=pesos20*1;
	}
	if(isNaN(pesos50)){
		pesos50=0;
	}
	else{
		pesos50=pesos50*1;
	}
	if(isNaN(pesos100)){
		pesos100=0;
	}
	else{
		pesos100=pesos100*1;
	}
	if(isNaN(pesos200)){
		pesos200=0;
	}
	else{
		pesos200=pesos200*1;
	}
	if(isNaN(pesos500)){
		pesos500=0;
	}
	else{
		pesos500=pesos500*1;
	}
	if(isNaN(pesos1000)){
		pesos1000=0;
	}else{
		pesos1000=pesos1000*1;
	}
	var total = monedas+(pesos20*20)+(pesos50*50)+(pesos100*100)+(pesos200*200)+(pesos500*500)+(pesos1000*1000);
	//$("#mostrar_total").html('$'+total);
	if(total>0){
		var r = confirm("Total:"+total+" Realizar corte? ");

		if (r == true) {
			$("#area_trabajo_menu").load("includes/barra_progreso.php");
			window.open("includes/corte_grande.php?monedas="+monedas+"&pesos20="+pesos20+"&pesos50="+pesos50+"&pesos100="+pesos100+"&pesos200="+pesos200+"&pesos500="+pesos500+"&pesos1000="+pesos1000+"&ticket_fin="+ticket_fin+"&ticket_ini="+ticket_ini, "Diseño Web", "width=1000, height=500");
			setTimeout(mostrar_corte, 7000);
		}
	}else{
		alert("Efectivo no registrado");
	}
}
function mostrar_corte(){
	salirsession();
	window.open("includes/mostraruitimocorte.php", "Diseño Web", "width=1000, height=500");
}
function mostrar_corte_hecho(id){
	window.open("corte/corte_caja"+id+".pdf", "Diseño Web", "width=1000, height=500");
}
function mostrar_citas_recientes(){
	//alert("evaluando citas ");
	$("#alerta_citas").load("includes/alerta_citas.php");

	setTimeout('mostrar_citas_recientes()',100000);

}
