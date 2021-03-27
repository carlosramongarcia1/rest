<?php
  date_default_timezone_set('America/Mexico_City');
include_once("clase_inventario.php");
$categoria = NEW Categoria(0);
  echo '
    <div class="container">

        <div class="form-group">
        <label for="nombre">
          Producto:
        </label>
        <input class="form-control" type="text"  id="nombre"  placeholder="Nombre del Producto" autofocus/>
        </div>
        <div class="form-group">
        <label for="categoria">Categoria</label>
          <select class="form-control" id="categoria">';
          $categoria->mostrar_inventario();

      echo '</select>
        </div>
        <div class="form-group">
        <label for="precio">
          Precio :
        </label>
        <input class="form-control" type="number" id="precio_antes" placeholder="Precio de Venta"/>
      </div>
        <div class="form-group">
          <label for="precio_venta">
            Precio de Venta:
          </label>
          <input class="form-control" type="number" id="precio_venta" placeholder="Precio de Venta" disabled/>
        </div>
        <div class="form-group">
        <label for="porcentage_precio_venta">
          Porcentage:
        </label>
        <input class="form-control" type="number" id="porcentage_precio_venta"  onkeyup="hacer_calculo_porcentage_inv()"  placeholder="Porcentage de Precio de Venta"/ >
      </div>
        <div class="form-group">
          <label for="precio_compra">
            Precio de Compra:
          </label>
          <input class="form-control" type="number" id="precio_compra" placeholder="Precio de Compra"/>
        </div>
        <div class="form-group">
          <label for="stock">
            Stock:
          </label>
          <input class="form-control" type="number" id="stock" placeholder="Stock"/>
        </div>
        <div class="form-group">
          <label for="inventario">
            Inventario:
          </label>
          <input class="form-control" type="number" id="inventario" placeholder="Inventario"/>
        </div>
        <div class="form-group">
          <label for="stock">
            Bodega Stock:
          </label>
          <input class="form-control" type="number" id="bodega_stock" placeholder="Bodega Stock"/>
        </div>
        <div class="form-group">
          <label for="inventario">
            Bodega Inventario:
          </label>
          <input class="form-control" type="number" id="bodega_inventario" placeholder="Bodega Inventario"/>
        </div>
        <div class="form-group">
          <label for="clave">
            Clave SAT:
          </label>
          <input class="form-control" type="number" id="clave" placeholder="Clave SAT"/>
        </div>
        <input type="submit" class="btn btn-block btn-default btn-lg" value="Guardar" onclick="guardar_producto()">
    </div> </br><s';
?>
