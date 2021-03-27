<?php
  //error_reporting(E_ALL);
  //ini_set('display_errors', '1');
  date_default_timezone_set('America/Mexico_City');
  require('../fpdf/fpdf.php');
  include_once("clase_corte_info.php");
  include_once("clase_configuracion.php");

  $confi=NEW Configuracion();
  $ini_ticket=$_GET['ticket_ini'];
  $fin_ticket=$_GET['ticket_fin'];
  $inf = NEW Corte_info($ini_ticket,$fin_ticket);
  $corte=$inf->obtener_corte();
  $pdf = new FPDF();
  $x=7;
  $y=5;
  $total_hospedaje=0;
  $total=0;
  $suma_cuartos=0;
  $suma_cortesias=0;
  $total_cuartos_hospedaje=0;
  $suma_cuartos_hospedaje=0;
  $total_restaurante=0;
  $pdf->SetFont('Times','',14);
  $pdf->AddPage();
  $pdf->SetXY($x, $y);
  $pdf->Cell(193,7,$confi->nombre.' Corte # '.$corte.'   '.date("Y-m-d H:i:s") . ' Tickets ' .$inf->ticket_primero_etiqueta . ' - '.$inf->ticket_fin_etiqueta,1,1,'C');

  $y = $y+9;
  //$x=$x+1;
    $pdf->SetXY($x, $y);
    $pdf->SetFont('Times','',12);
    $pdf->Cell(100,5,'Detalles',1,1,'C');
    $y = $y+5;
    $pdf->SetXY($x, $y);
    $pdf->SetFont('Times','',10);
    $pdf->Cell(80,5,'Trabajador ',1,0,'C');
    $pdf->Cell(20,5,'Total',1,0,'C');
    $pdf->SetFont('Times','',9);
    $cantidad=count($inf->trabajor);
    for($z =0 ; $z<$cantidad; $z++){
        $y = $y+5;
        $pdf->SetXY($x, $y);
        $pdf->Cell(80,5,$inf->trabajor[$z],1,0,'C');
        $pdf->Cell(20,5,'$'.$inf->hab_total[$z],1,0,'C');
        $total=$total+$inf->hab_total[$z];
    }
    $y = $y+5;
    $pdf->SetXY($x, $y);
    $pdf->SetFont('Times','',10);
    $pdf->Cell(80,5,' ',0,0,'C');
    $pdf->Cell(20,5,'$'.$total,1,1,'C');
    $y = $y+8;



  /*$pdf->SetXY($x, $y);
  $pdf->SetFont('Times','',12);
  $pdf->Cell(100,5,'Restaurante',1,1,'C');
  //$y = $y+5;

  $total_restaurante=0;
  $pdf->SetFont('Times','',9);
  for($z =0 ; $z<$cantidad; $z++){
      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(60,5,$inf->tipo_restaurante[$z],1,0,'C');
      $pdf->Cell(40,5,'$'.$inf->total_restaurante[$z],1,1,'R');
       $total_restaurante=$total_restaurante+$inf->total_restaurante[$z];
  }
  $y = $y+5;
  $pdf->SetXY($x, $y);
  $pdf->Cell(60,5,'',0,0,'C');
  $pdf->Cell(40,5,'$'.$total_restaurante,1,1,'R');

*/
/*$y = $y+9;
$pdf->SetXY($x, $y);
$pdf->SetFont('Times','',12);
$pdf->Cell(100,5,'Restaurante',1,1,'C');
//$y = $y+5;
$cantidad=count($inf->tipo_restaurante);
$total_restaurante=0;
$pdf->SetFont('Times','',9);
for($z =0 ; $z<$cantidad; $z++){
    $y = $y+5;
    $pdf->SetXY($x, $y);
    $pdf->Cell(60,5,$inf->tipo_restaurante[$z],1,0,'C');
    $pdf->Cell(40,5,'$'.$inf->total_restaurante[$z],1,1,'R');
     $total_restaurante=$total_restaurante+$inf->total_restaurante[$z];
}
$y = $y+5;
$pdf->SetXY($x, $y);
$pdf->Cell(60,5,'',0,0,'C');
$pdf->Cell(40,5,'$'.$total_restaurante,1,1,'R');
*/
  $x=110;
  $y=14;

  $pdf->SetXY($x, $y);
  $pdf->SetFont('Times','',12);
  $pdf->Cell(90,7,'Totales',1,1,'C');
  $y = $y+7;
  $cantidad=count($inf->tipo_restaurante);
  $pdf->SetFont('Times','',9);
  //$y = $y+.4;
  $total_globales=0;

  $pdf->SetXY($x, $y);
  $pdf->Cell(50,5,'Total',1,0,'C');
  $pdf->Cell(40,5,'$'.$total,1,1,'R');


  $y = $y+7;
  $pdf->SetXY($x, $y);
  $pdf->SetFont('Times','',12);
  $pdf->Cell(90,7,'Desgloce en sistema',1,1,'C');
  $y = $y+7;

  $pdf->SetFont('Times','',9);
  //$y = $y+.4;
  $pdf->SetXY($x, $y);
  $pdf->Cell(50,5,'Efectivo',1,0,'C');
  $pdf->Cell(40,5,'$'.$inf->total_efectivo,1,1,'R');
  $y = $y+5;
  $pdf->SetXY($x, $y);
  $pdf->Cell(50,5,'Tarjeta',1,0,'C');
  $pdf->Cell(40,5,'$'.$inf->total_tarjeta,1,1,'R');
  $y = $y+5;
  $pdf->SetXY($x, $y);
  $pdf->Cell(50,5,'Cortesia',1,0,'C');
  $pdf->Cell(40,5,'$'.$inf->total_cortesia,1,1,'R');
  $y = $y+5;
  $pdf->SetXY($x, $y);
  $pdf->Cell(50,5,'Gastos',1,0,'C');
  $pdf->Cell(40,5,'$'.$inf->total_gastos,1,1,'R');


  $y = $y+7;
  $pdf->SetXY($x, $y);
  $pdf->SetFont('Times','',12);
  $pdf->Cell(90,7,'Desgloce en caja',1,1,'C');
  $y = $y+7;
  $pdf->SetFont('Times','',9);

      $pdf->SetXY($x, $y);
      $pdf->Cell(40,5,'Monedas',1,0,'C');
      $pdf->Cell(25,5,$_GET['monedas'],1,0,'C');
      $total_monedas=$_GET['monedas']*1;
      $pdf->Cell(25,5,'$'.$total_monedas,1,1,'R');

      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(40,5,'Billetes de $20',1,0,'C');
      $pdf->Cell(25,5,$_GET['pesos20'],1,0,'C');
      $total_pesos20=$_GET['pesos20']*20;
      $pdf->Cell(25,5,'$'.$total_pesos20,1,1,'R');

      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(40,5,'Billetes de $50',1,0,'C');
      $pdf->Cell(25,5,$_GET['pesos50'],1,0,'C');
      $total_pesos50=$_GET['pesos50']*50;
      $pdf->Cell(25,5,'$'.$total_pesos50,1,1,'R');

      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(40,5,'Billetes de $100',1,0,'C');
      $pdf->Cell(25,5,$_GET['pesos100'],1,0,'C');
      $total_pesos100=$_GET['pesos100']*100;
      $pdf->Cell(25,5,'$'.$total_pesos100,1,1,'R');

      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(40,5,'Billetes de $200',1,0,'C');
      $pdf->Cell(25,5,$_GET['pesos200'],1,0,'C');
      $total_pesos200=$_GET['pesos200']*200;
      $pdf->Cell(25,5,'$'.$total_pesos200,1,1,'R');

      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(40,5,'Billetes de $500',1,0,'C');
      $pdf->Cell(25,5,$_GET['pesos500'],1,0,'C');
      $total_pesos500=$_GET['pesos500']*500;
      $pdf->Cell(25,5,'$'.$total_pesos500,1,1,'R');

      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(40,5,'Billetes de $1000',1,0,'C');
      $pdf->Cell(25,5,$_GET['pesos1000'],1,0,'C');
      $total_pesos1000=$_GET['pesos1000']*1000;
      $pdf->Cell(25,5,'$'.$total_pesos1000,1,1,'R');

      $total_desgloce=$total_pesos1000+$total_pesos500+$total_pesos200+$total_pesos100+$total_pesos50+$total_pesos20+$total_monedas;

      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(40,5,'',1,0,'C');
      $pdf->Cell(25,5,'Total Desgloce',1,0,'C');
      $pdf->Cell(25,5,'$'.$total_desgloce,1,1,'R');

      $y = $y+7;
      $pdf->SetXY($x, $y);
      $pdf->SetFont('Times','',12);
      $pdf->Cell(90,5,'Diferiencia',1,1,'C');
      $pdf->SetFont('Times','',9);


      $diferen =$total_desgloce-($inf->total_efectivo-$inf->total_gastos);
      if($diferen>=0){
        $sobrante=$diferen;
        $faltante=0;
      }else{
        $sobrante=0;
        $faltante=$diferen*-1;
      }

      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(45,5,'Sobrante',1,0,'C');
      $pdf->Cell(45,5,'$'.$sobrante,1,1,'R');

      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(45,5,'faltante',1,0,'C');
      $pdf->Cell(45,5,'$'.$faltante,1,1,'R');

  $y = $y+7;
  $pdf->SetXY($x, $y);
  $pdf->SetFont('Times','',12);
  $pdf->Cell(90,5,'Gastos',0,1,'C');
  //$y = $y+5;

  $pdf->SetFont('Times','',9);
  $cantidad=count($inf->gasto_nombre);

  $total_gast=0;
  for($z =0 ; $z<$cantidad; $z++){
      $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(50,5,$inf->gasto_nombre[$z],1,0,'C');
      $pdf->Cell(40,5,'$'.$inf->gasto_venta[$z],1,1,'R');
      $total_gast=$total_gast+$inf->gasto_venta[$z];
  }
  $y = $y+5;
      $pdf->SetXY($x, $y);
      $pdf->Cell(50,5,'Total ',1,0,'C');
      $pdf->Cell(40,5,'$'.$total_gast,1,1,'R');


  $pdf->AddPage();
  $x=7;
  $y=5;
  $pdf->SetFont('Times','',14);
  $pdf->SetXY($x, $y);
  $pdf->Cell(193,7,$confi->nombre.' Corte # '.$corte.'   '.date("Y-m-d H:i:s") . ' Tickets ' .$inf->ticket_primero_etiqueta . ' - '.$inf->ticket_fin_etiqueta,1,1,'C');
  $y = $y+9;

  $pdf->SetXY($x, $y);
  $pdf->SetFont('Times','',12);
  $pdf->Cell(100,5,'Ventas Restaurante',1,1,'C');
  $y = $y+5;
  $pdf->SetXY($x, $y);
  $pdf->SetFont('Times','',8);
  $pdf->Cell(40,4.5,'Producto',1,0,'C');
  $pdf->Cell(20,4.5,'Stock',1,0,'C');
  $pdf->Cell(20,4.5,'Venta',1,0,'C');
  $pdf->Cell(20,4.5,'Comp.',1,1,'C');

  $cantidad=count($inf->producto_nombre);
  for($z =0 ; $z<$cantidad; $z++){
      if($inf->producto_venta[$z]>0){
        $y = $y+4.5;
        $pdf->SetXY($x, $y);
        $pdf->Cell(40,4.5,$inf->producto_nombre[$z],1,0,'C');
        $pdf->Cell(20,4.5,$inf->producto_inventario[$z],1,0,'C');
        $pdf->Cell(20,4.5,$inf->producto_venta[$z],1,0,'C');
        $pdf->Cell(20,4.5,'',1,1,'R');
      }
  }



  $inf->cambiar_estado_gastos();
  $inf->guardar_corte($corte,$total_globales,$inf->total_efectivo,$inf->total_tarjeta,$inf->total_cortesia,$total,$total_hospedaje,$total_restaurante,$inf->total_personas,$inf->total_horas,$total_monedas,$total_pesos20,$total_pesos50,$total_pesos100,$total_pesos200,$total_pesos500,$total_pesos1000,$diferen, $ini_ticket,$fin_ticket);
  $inf->cambiar_estado_ticket($ini_ticket,$fin_ticket);
  //$inf->cambiar_estado_cortesias();
  $pdf->Output("../corte/corte_caja$corte.pdf","F");
  //$pdf->Output("../corte/corte_caja$corte.pdf","I");
?>
