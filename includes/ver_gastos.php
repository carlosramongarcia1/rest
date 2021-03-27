<?php
  date_default_timezone_set('America/Mexico_City');
	include ("clase_gastos.php");
	$gasto = NEW Gastos();

	echo ' <div class="container-fluid">

          <div class="row">
          <h2>Gastos en turno</h2>
           <div class="col-sm-12">
          ';
          $gasto-> ver_gastos_activos();

  echo  '
      </div>
      <div class="row">
       <div class="col-sm-4">
      ';
          
?>
