<?php
  include_once ('clase_inventario.php');
  include_once ('clase_usuario.php');

  $inve = NEW Inventario();
  $usua = NEW Usuario(0);
  echo '
    <div class="row">
      <div class="col-sm-12" >

        <div class="panel panel-primary">
          <div class="panel-heading alinear_centro">Caja</div>
          <div class="panel-body">
          <div class="row">
            <div class="col-sm-6" >
              <div class="panel panel-default">
                <div class="panel-heading alinear_centro">Caja</div>
                  </br>
                  <div class="col-sm-8" >
                    <input type="text" class="form-control" id="busqueda" placeholder="Buscar" autofocus>
                  </div>

                  <div class="col-sm-4" >

                      <button type="button" class="btn btn-info btn-block" onclick="buscar_producto()">Buscar</button>

                  </div>
                  </br>
                  </br>
                  <div id="comanda">
                ';
                $inve->mostrar_comanda();

                echo '</div>

              </div>
            </div>
            <div class="col-sm-6" >
            <div class="row">
              <div class="col-sm-12" >
                <div class="panel panel-default">
                  <div class="panel-heading alinear_centro">Categorias</div>
                  <div class="panel-body">';
                    $inve->catgoria();
                  echo '</div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12" >
                <div class="panel panel-default">
                  <div class="panel-heading alinear_centro">Pago</div>
                  <div class="panel-body">
                    <div class="row">

                      <div class="col-sm-4" >
                        <label for="sel1">Forma de Pago:</label>
                        <select class="form-control" id="f_pago">
                          <option value="1">Efectivo</option>
                          <option value="2">Tarjeta</option>
                          <option value="3">Cortesia</option>
                        </select>
                      </div>
                     
                      <div class="col-sm-4" >
                          <label for="sel1">Pago:</label>
                          <input type="number" class="form-control" id="pago" placeholder="Pago">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-sm-12" >
                <div class="panel panel-default">
                  <div class="panel-heading alinear_centro">Categorias</div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-sm-2 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="sumar(7)">7</button>
                      </div>
                      <div class="col-sm-2 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="sumar(8)">8</button>
                      </div>
                      <div class="col-sm-2 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="sumar(9)">9</button>
                      </div>
                    </div>
                    </br>
                    <div class="row">
                      <div class="col-sm-2 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="sumar(4)">4</button>
                      </div>
                      <div class="col-sm-2 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="sumar(5)">5</button>
                      </div>
                      <div class="col-sm-2 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="sumar(6)">6</button>
                      </div>
                    </div>
                    </br>
                    <div class="row">
                      <div class="col-sm-2 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="sumar(1)">1</button>
                      </div>
                      <div class="col-sm-2 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="sumar(2)">2</button>
                      </div>
                      <div class="col-sm-2 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="sumar(3)">3</button>
                      </div>
                    </div>
                    </br>
                    <div class="row">
                      <div class="col-sm-4 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="sumar(0)">0</button>
                      </div>
                      <div class="col-sm-2 margen_inf">
                        <button type="button" class="btn btn-warning btn-lg btn-block" onclick="limipar()">Borar</button>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>


            </div>
          </div>

          </div>
        </div>
      </div>

    </div>
  ';
?>
