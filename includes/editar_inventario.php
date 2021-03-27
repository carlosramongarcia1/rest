<?php
  date_default_timezone_set('America/Mexico_City');
include_once("clase_inventario.php");
$categoria = NEW Categoria(0);
$producto = NEW Producto($_GET['id']);
  echo '
    <div class="container">
        <div class="form-group">
        <label for="nombre">
          Producto:
        </label>
        <input class="form-control" type="text"  id="nombre"  value="'.$producto->nombre.'"/>
        </div>
        <div class="form-group">
        <label for="categoria">Categoria</label>
          <select class="form-control" id="categoria">';
          $categoria->mostrar_inventario_editar($producto->categoria);

      echo '</select>
        </div>
        <div class="form-group">
          <label for="precio_venta">
            Precio de Venta:
          </label>
          <input class="form-control" type="number" id="precio_venta" value="'.$producto->precio.'"/>
        </div>
        <div class="form-group">
          <label for="precio_compra">
            Precio de Compra:
          </label>
          <input class="form-control" type="number" id="precio_compra" value="'.$producto->precio_compra.'"/>
        </div>
        <div class="form-group">
          <label for="stock">
            Stock:
          </label>
          <input class="form-control" type="number" id="stock" value="'.$producto->stock.'"/>
        </div>
        <div class="form-group">
          <label for="inventario">
            Inventario:
          </label>
          <input class="form-control" type="number" id="inventario" value="'.$producto->inventario.'"/>
        </div>
        <div class="form-group">
          <label for="stock">
            Bodega Stock:
          </label>
          <input class="form-control" type="number" id="bodega_stock" value="'.$producto->bodega_stock.'"/>
        </div>
        <div class="form-group">
          <label for="inventario">
            Bodega Inventario:
          </label>
          <input class="form-control" type="number" id="bodega_inventario" value="'.$producto->bodega_inventario.'"/>
        </div>
        <div class="form-group">
          <label for="clave">
            Clave SAT:
          </label>
          <input class="form-control" type="number" id="clave" value="'.$producto->clabe.'"/>
        </div>
        <input type="submit" class="btn btn-block btn-default btn-lg" value="Guardar" onclick="editar_producto('.$_GET['id'].')">
    </div> </br><s';
?>
