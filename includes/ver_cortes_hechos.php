<?php
	date_default_timezone_set('America/Mexico_City');
	include("clase_corte_info.php");
	$corte= NEW  Corte_ver();
	echo ' <div class="container-fluid"> 
          <h2>Corte</h2>';
          $corte->ver_cortes();
  echo  '</div>';
?>
