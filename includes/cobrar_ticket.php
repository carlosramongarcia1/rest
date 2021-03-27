<?php
  include_once ('clase_ticket.php');
  $ticket= NEW Ticket();
  switch ($_GET['f_pago']) {
    case 1:
        $pago = $_GET['pago'];
        if($_GET['pago']>$_GET['total']){
          $cambio=$_GET['pago']-$_GET['total'];
        }else{
          $cambio = 0;
        }
        $tarjeta=0;
        $descuento=0;
      break;
    case 2:
        $pago =0;
        $tarjeta=$_GET['total'];
        $cambio = 0;
        $descuento=0;
      break;
    case 3:
        $pago =0;
        $tarjeta=0;
        $cambio = 0;
        $descuento=$_GET['total'];
      break;

  }

  $ticket_id= $ticket->guardar_ticket($_GET['id'],$_GET['barbero'],$_GET['total'],$pago,$cambio,$tarjeta,$descuento);
  $ticket->cambiar_comanda($ticket_id);
  echo '<div class="row">
          <div class="col-sm-12" >
            <div class="panel panel-primary">
              <div class="panel-heading alinear_centro">Caja</div>
                <div class="panel-body">
                <div class="alert alert-success">
                  <strong>Cobro </strong>realizado con exito
                  </div>
                      <a href="inicio.php">
                        <button type="button" class="btn btn-info">Regresar</button>
                      </a>
                </div>
              </div>
            </div>
          </div>
        </div>
  ';
?>
