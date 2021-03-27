<?php
  date_default_timezone_set('America/Mexico_City');
  require('../fpdf/fpdf.php');
  include_once("clase_inventario.php");
  $inv = NEW Inventario(0);
  $consulta=$inv->mostrar_a_surtir_pdf();
  /*$pdf = new FPDF('P','cm',array(7,100));
  $pdf->Cell(4,.6,"hole",1,0,'L');
  while ($fila = mysqli_fetch_array($consulta))
  {
    //$pdf->Cell(4,.6,$fila['nombre'],1,0,'L');
  }
  $pdf->Output("Resurtido.pdf","I");*/
  $pdf = new FPDF('P','cm',array(7,100));
  $pdf->AddPage();
  $x=.5;
  $y=0;
  $pdf->SetXY($x, $y);
  $pdf->SetFont('Arial','B',14);

  $y = $y+0.6;
  $pdf->SetXY($x, $y);
  $pdf->Cell(1.5,1,"Resurtido ".date("m.d.y"),0,1);

  $pdf->SetFont('Arial','B',12);

  $y = $y+1;
  $pdf->SetXY($x, $y);
  $pdf->Cell(4,.6,"Nombre",1,0);
  $pdf->Cell(1.5,.6,"Cant.",1,1);

  $pdf->SetFont('Arial','',12);
  while ($fila = mysqli_fetch_array($consulta))
  {
    $y = $y+0.6;
    $pdf->SetXY($x, $y);
    $pdf->Cell(4,.6,$fila['nombre'],1,0);
    $pdf->Cell(1.5,.6,$fila['cantidad'],1,1);
    $inventario=$inv->cantidad_inventario($fila['id']);
    $inventario=$inventario+$fila['cantidad'];
    $inv->editar_cantidad_inventario($fila['id'],$inventario);
    $inv->editar_cantidad_resurtido($fila['ID']);
  }
  $pdf->Output("Resurtido.pdf","I");
?>
