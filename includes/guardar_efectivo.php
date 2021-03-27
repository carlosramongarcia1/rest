<?php
  date_default_timezone_set('America/Mexico_City');
  include ("clase_ticket.php");
  include_once("clase_configuracion.php");
  $info_ticket=NEW Ticket();
  $confi=NEW Configuracion();
  $info_ticket->ticket_fin() - $info_ticket->ticket_ini();

echo '
  <div class="container texto_entrada">
  <h2 class="texto_entrada" >Efectivo:<label id="mostrar_total" >$0</label></h2>
      <div class="form-group">
        <label for="monedas">
          Monedas:
        </label>
        <input class="form-control" type="number"  id="monedas"  onKeyUp="calcular_total()" placeholder="Cantidad en monedas"/>
      </div>
      <div class="form-group">
        <label for="20_pesos">
          Billete de 20$:
        </label>
        <input class="form-control" type="number"  id="20_pesos"  onKeyUp="calcular_total()" placeholder="Cantidad en billetes de 20$"/>
      </div>
      <div class="form-group">
        <label for="50_pesos">
          Billete de 50$:
        </label>
        <input class="form-control" type="number"  id="50_pesos"   onKeyUp="calcular_total()" placeholder="Cantidad en billetes de 50$"/>
      </div>
      <div class="form-group">
        <label for="100_pesos">
          Billete de 100$:
        </label>
        <input class="form-control" type="number"  id="100_pesos"  onKeyUp="calcular_total()" placeholder="Cantidad en billetes de 100$"/>
      </div>
      <div class="form-group">
        <label for="200_pesos">
          Billete de 200$:
        </label>
        <input class="form-control" type="number"  id="200_pesos"  onKeyUp="calcular_total()" placeholder="Cantidad en billetes de 200$"/>
      </div>
      <div class="form-group">
        <label for="500_pesos">
          Billete de 500$:
        </label>
        <input class="form-control" type="number"  id="500_pesos"  onKeyUp="calcular_total()" placeholder="Cantidad en billetes de 500$"/>
      </div>
      <div class="form-group">
        <label for="1000_pesos">
          Billete de 1000$:
        </label>
        <input class="form-control" type="number"  id="1000_pesos"  onKeyUp="calcular_total()" placeholder="Cantidad en billetes de 1000$"/>
      </div>';

      if($info_ticket->ticket_fin() >= $info_ticket->ticket_ini()){
         echo '
         <input type="submit" class="btn btn-block btn-default btn-lg" value="Realizar Corte" onclick="realiza_corte('. $info_ticket->ticket_ini().','. $info_ticket->ticket_fin().','.$confi->corte.')">';
      }
      echo '
  </div> </br>';
?>
