<?php
    include_once("clase_corte_info.php");
    include_once("clase_ticket.php");
    $info_ticket=NEW Ticket();
    $inf = NEW Corte_info( $info_ticket->ticket_ini(),$info_ticket->ticket_fin());
  echo '<div class="container-fluid">
    <div class="row">
      <div class="col-sm-4">
        <h2>Corte</h2>
      </div>
      <div class="col-sm-4">';
      echo 'Tickets '.$inf->ticket_primero_etiqueta.' - ' .$inf->ticket_fin_etiqueta;
      echo '</div>
      <div class="col-sm-4"> 
        <button type="button" class="btn btn-danger" onclick="ver_cortes()" >Hacer Corte</button>
      </div>
      </div>
    <div class="row texto_doble">
    <div class="col-sm-4">
    <div class="panel panel-success">
      <div class="panel-heading">Detalle de venta</div>
      <div class="panel-body color_black">';
      $cantidad=count($inf->producto_nombre);
      for($z =0 ; $z<$cantidad; $z++){
        if($z ==0){
          echo '<table class="table ">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
            </tr>
          </thead>';
        }
          if($inf->producto_venta[$z]>0){

            if(($z%2)==0){
              echo '<tr class="info">';
            }else{
                echo '<tr class="active">';
            }
            echo '

              <td>'.$inf->producto_nombre[$z].'</td>
              <td>'.$inf->producto_venta[$z].'</td>
            </tr>
            ';
          }

      }
      echo '
        </tbody>
      </table>
      ';
    echo   '</div>
    </div>
  </div>';

          $cantidad=count($inf->trabajor);
          $total=0;
          for($z =0 ; $z<$cantidad; $z++){
            
             $total=$total+$inf->hab_total[$z];
            
          }
          echo '
            
      <div class="col-sm-4">
        <div class="panel panel-success">
          <div class="panel-heading">Gastos</div>
          <div class="panel-body color_black">';
            $cantidad=count($inf->gasto_nombre);
              $total_gast=0;
            for($z =0 ; $z<$cantidad; $z++){
              if($z ==0){
                echo '<table class="table ">
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Pago</th>
                  </tr>
                </thead>';
              }
              if(($z%2)==0){
                echo '<tr class="info">';
              }else{
                  echo '<tr class="active">';
              }
              echo '

                <td>'.$inf->gasto_nombre[$z].'</td>
                <td>$'.$inf->gasto_venta[$z].'</td>
              </tr>
              ';
              $total_gast=$total_gast+$inf->gasto_venta[$z];
            }
            echo '
              <tr class="warning">
                <td></td>
                <td>$'.$total_gast.'</td>
              </tr>
              </tbody>
            </table>
            ';
          echo '</div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel panel-success">
          <div class="panel-heading">Totales</div>
          <div class="panel-body color_black">';

                echo '<table class="table ">
                      <tr class="warning">
                        <td>Total</td>
                        <td>$'.$total.'</td>
                       </tr>
                      <tr class="info">
                        <td>Efectivo</td>
                        <td>$'.$inf->total_efectivo.'</td>
                       </tr>
                       <tr class="active">
                         <td>Tarjeta</td>
                         <td>$'.$inf->total_tarjeta.'</td>
                        </tr>
                      <tr class="info">
                        <td>Cortesia</td>
                        <td>$'.$inf->total_cortesia.'</td>
                       </tr>
                       <tr class="active">
                         <td>Gastos</td>
                         <td>$'.$inf->total_gastos.'</td>
                        </tr>
                        </tbody>
                      </table>
                      ';
          echo '</div>
        </div>
      </div>
      </div>
      
    </div>';
?>
