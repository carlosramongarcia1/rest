<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  /**
   *
   */
  class Inventario extends ConexionMYSql
  {

    function __construct()
    {
      # code...
    }
    function mostrar_comanda(){
      $sentencia = "SELECT * FROM concepto WHERE ticket = 0";
      $comentario="Mostrar los conceptos sin ticket";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cantidad=0;
      $total=0;
      echo '<ul class="list-group">';
      while ($fila = mysqli_fetch_array($consulta))
      {
        if(($cantidad%2)==0){
          echo '<a href="#" class="list-group-item list-group-item-success" onclick="herramienta_comanda('.$fila['id'].')">
            <h5 class="list-group-item-heading">'.$fila['cantidad'].' - '.$fila['nombre'].' - $'.$fila['precio'].' </h5>
            <p class="list-group-item-text">Total: $'.$fila['total'].' </p>
          </a>';
        }else{
          echo ' <a href="#" class="list-group-item list-group-item-info" onclick="herramienta_comanda('.$fila['id'].')">
            <h5 class="list-group-item-heading">'.$fila['cantidad'].' - '.$fila['nombre'].' - $'.$fila['precio'].' </h5>
            <p class="list-group-item-text"> Total: $'.$fila['total'].' </p>
          </a>';
        }
        $total=$total+$fila['total'];
        $cantidad++;
      }

      /*if($cantidad<12){
        for ($i = $cantidad; $i <= 13; $i++) {
            echo '<div class="panel-body"></div>';
        }
      }*/
      echo '</ul>';
      if($cantidad>0){

        echo '<div class="panel-body">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-2">
          Total: $'.$total.'
        </div>
        <div class="col-sm-4">
          <button type="button" id="boton_cobrar" class="btn btn-danger btn-block" onclick="cobrar('.$total.')">Cobrar</button>
        </div>

        </div>';
      }

    }
    function borrar_comanda($id){
      $sentencia = "DELETE FROM `concepto`
        WHERE ((`id` = '$id'));";
      $comentario="Borrar comanda";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function agregar_a_comanda($id){
      $cantidad=0;
      $total = 0;
      $precio = 0;
      $sentencia = "SELECT  * FROM concepto WHERE id = $id LIMIT  1 ";
      $comentario="Obtener la informacion del concepto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))

      {
        $cantidad=$fila['cantidad'];
        $total=$fila['total'];
        $precio=$fila['precio'];
      }
      $cantidad=$cantidad+1;
      $total =$total+$precio;

      $sentencia = "UPDATE `concepto` SET
      `cantidad` = '$cantidad',
      `total` = '$total'
      WHERE `id` = '$id';";
      $comentario="Actualizar comanda";
      $consulta= $this->realizaConsulta($sentencia,$comentario);

    }
    function mostar_info_comanda($id){
      $sentencia = "SELECT  * FROM concepto WHERE id = $id LIMIT  1 ";
      $comentario="Mostrar los productos a surtir";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo ' <a href="#" class="list-group-item">
          <h5 class="list-group-item-heading">'.$fila['cantidad'].' - '.$fila['nombre'].' - $'.$fila['precio'].' </h5>
          <p class="list-group-item-text"> Total: $'.$fila['total'].' </p>
        </a>';
      }
    }
    function borrar_producto($id_producto){
      $sentencia = "DELETE FROM `producto`
      WHERE ((`id` = '$id_producto'));";
      $comentario="Borrando producto dentro de la base de datos ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function guardar_producto($nombre,$categoria,$precio,$precio_compra,$inventario,$stock,$bodega_inventario,$bodega_stock,$clabe){
      $sentencia = "INSERT INTO `producto` (`nombre`, `categoria`, `precio`, `precio_compra`, `inventario`, `stock`, `bodega_inventario`, `bodega_stock`, `clabe`, `historial`)
                          VALUES ('$nombre', '$categoria', '$precio', '$precio_compra', '$inventario', '$stock', '$bodega_inventario', '$bodega_stock', '$clabe', '0');";
      $comentario="Guardar producto dentro de la base de datos ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function editar_producto($id,$nombre,$categoria,$precio,$precio_compra,$inventario,$stock,$bodega_inventario,$bodega_stock,$clabe){
      $sentencia = "UPDATE `producto` SET
          `nombre` = '$nombre',
          `categoria` = '$categoria',
          `precio` = '$precio',
          `precio_compra` = '$precio_compra',
          `inventario` = '$inventario',
          `stock` = '$stock',
          `bodega_inventario` = '$bodega_inventario',
          `bodega_stock` = '$bodega_stock',
          `clabe` = '$clabe'
          WHERE `id` = '$id';";
        echo $sentencia ;
      $comentario="Editar producto dentro de la base de datos ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function mostrar_a_surtir_pdf(){
      $contador=0;
      $sentencia = "SELECT * ,surtir.id AS ID FROM surtir LEFT JOIN producto ON surtir.producto = producto.id  WHERE surtir.estado =0 ORDER BY surtir.producto";
      $comentario="Mostrar los productos a surtir";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      return $consulta;
    }
    function mostrar_a_surtir(){
      $contador=0;
      $sentencia = "SELECT * ,surtir.id AS ID FROM surtir LEFT JOIN producto ON surtir.producto = producto.id  WHERE surtir.estado =0 ORDER BY surtir.producto";
      $comentario="Mostrar los productos a surtir";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '<div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Borrar</th>
            </tr>
          </thead>
          <tbody>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        $contador++;
        echo '<tr>
        <td>'.$fila['nombre'].'</td>
        <td>'.$fila['cantidad'].'</td>
        <td><button class="btn-danger" onclick="borrar_inventario_surtir('.$fila['ID'].')"><span class="glyphicon glyphicon-trash"></span> Borrar</button></td>
      </tr>';
    }//<td><button onclick="agargar_conceptos_inventario('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Concepto</button></td>
      if($contador>0){
        echo '<tr>
        <td></td>
        <td></td>
        <td><button class="btn-primary btn-lg" onclick="aplicar_inventario_surtir()"><span class="glyphicon glyphicon-ok"></span> surtir</button></td>
      </tr>';
      }
        echo '</table>
          </div>';
    }
    function mostrar_surtir(){
      $sentencia = "SELECT  producto.id ,producto.nombre ,producto.precio,producto.precio_compra,producto.inventario,producto.stock,producto.bodega_inventario,producto.bodega_stock,producto.historial,producto.clabe,categoria_inventario.nombre AS categoria
      FROM producto
      LEFT JOIN  categoria_inventario ON producto.categoria =  categoria_inventario.id ORDER BY categoria_inventario.id ,producto.nombre;";
      $comentario="Mostrar las categorias para el inventairo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cantidad=0;
      //se recibe la consulta y se convierte a arreglo
      echo '<input type="text" id="busqueda" onkeyup="buscar_surtir()" class="color_black">';
      echo '<div class="table-responsive" id="tabla_surtir">
        <table class="table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Categoria</th>
              <th>Stock</th>
              <th>Inventario</th>
              <th>Faltante</th>
              <th>Faltante</th>
              <th></th>
            </tr>
          </thead>
          <tbody>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        $faltante=$fila['stock']-$fila['inventario'];
        if($faltante<=0){
          $faltante=0;
        }
        $cantidad++;
        echo '<tr>
        <td>'.$fila['nombre'].'</td>
        <td>'.$fila['categoria'].'</td>
        <td>'.$fila['stock'].'</td>
        <td>'.$fila['inventario'].'</td>
        <td>'.$faltante.'</td>
      <td><input type="nombre" class="color_black" value = "'.$faltante.'" id="cantidad'.$fila['id'].'"></td>
        <td><button class="btn-success" onclick="inventario_surtir('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span>Guardar</button></td>
      </tr>';
    }


        echo '</table>
          </div>';

    }
    function mostrar_surtir_busqueda($a_buscar){
      $sentencia = "SELECT  producto.id ,producto.nombre ,producto.precio,producto.precio_compra,producto.inventario,producto.stock,producto.bodega_inventario,producto.bodega_stock,producto.historial,producto.clabe,categoria_inventario.nombre AS categoria
      FROM producto
      LEFT JOIN  categoria_inventario ON producto.categoria =  categoria_inventario.id  WHERE producto.nombre LIKE '%$a_buscar%' ORDER BY categoria_inventario.id ,producto.nombre;";
      $comentario="Mostrar las categorias para el inventairo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cantidad=0;
      //se recibe la consulta y se convierte a arreglo
      echo '<div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Categoria</th>
              <th>Stock</th>
              <th>Inventario</th>
              <th>Faltante</th>
              <th>Faltante</th>
              <th></th>
            </tr>
          </thead>
          <tbody>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        $faltante=$fila['stock']-$fila['inventario'];
        if($faltante<=0){
          $faltante=0;
        }
        $cantidad++;
        echo '<tr>
        <td>'.$fila['nombre'].'</td>
        <td>'.$fila['categoria'].'</td>
        <td>'.$fila['stock'].'</td>
        <td>'.$fila['inventario'].'</td>
        <td>'.$faltante.'</td>
      <td><input type="nombre" class="color_black" value = "'.$faltante.'" id="cantidad'.$fila['id'].'"></td>
        <td><button class="btn-success" onclick="inventario_surtir('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span>Guardar</button></td>
      </tr>';
    }


        echo '</table>
          </div>';

    }
    function guardar_surtir($producto,$cantidad){
      $tiempo=time();
      $sentencia = "INSERT INTO `surtir` (`fecha`, `producto`, `cantidad`, `estado`)
      VALUES ('$tiempo', '$producto', '$cantidad', '0');";
      $comentario="guardar la cantidad a surtir";
      $consulta= $this->realizaConsulta($sentencia,$comentario);

    }
    function borrar_surtir($id){
      $sentencia = "DELETE FROM `surtir`
      WHERE ((`id` = '$id'));";
      $comentario="borrar cantidad a surtir";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //echo $sentencia;
    }
    function mostrar(){
      $cantidad=0;
      $sentencia = "SELECT  producto.id ,producto.nombre ,producto.precio,producto.precio_compra,producto.inventario,producto.stock,producto.bodega_inventario,producto.bodega_stock,producto.historial,producto.clabe,categoria_inventario.nombre AS categoria
      FROM producto
      LEFT JOIN  categoria_inventario ON producto.categoria =  categoria_inventario.id ORDER BY categoria_inventario.id ,producto.nombre;";
      $comentario="Mostrar las categorias para el inventairo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '
       <input type="text" id="busqueda" onkeyup="buscar_inventario()" class="color_black">
      <div class="table-responsive" id="tabla_inventario">
        <table class="table">
          <thead>


            <tr>
              <th>Nombre</th>
              <th>Categoria</th>
              <th>Precio Venta</th>
              <th>Precio Compra</th>
              <th>Stock</th>
              <th>Inventario</th>
              <th>Bodega Stock</th>
              <th>Bodega Inventario</th>
              <th>Clave SAT</th>
              <th>Faltante</th>
              <th>Historial</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Borrar</th>
            </tr>
          </thead>
          <tbody>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        $cantidad++;
        $faltante=$fila['stock']-$fila['inventario'];
        if($faltante<=0){
          $faltante=0;
        }
        echo '<tr>
        <td>'.$fila['nombre'].'</td>
        <td>'.$fila['categoria'].'</td>
        <td>$'.$fila['precio'].'</td>
        <td>$'.$fila['precio_compra'].'</td>
        <td>'.$fila['stock'].'</td>
        <td>'.$fila['inventario'].'</td>
        <td>'.$fila['bodega_stock'].'</td>
        <td>'.$fila['bodega_inventario'].'</td>
        <td>'.$fila['clabe'].'</td>
        <td>'.$faltante.'</td>
        <td>'.$fila['historial'].'</td>
        <td><button class=" btn-warning"  onclick="editar_inventario('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>

        <td><button class="btn-danger" onclick="borrar_inventario('.$fila['id'].' ,1)"><span class="glyphicon glyphicon-edit"></span> Borrar</button></td>
      </tr>';
    }//<td><button onclick="agargar_conceptos_inventario('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Concepto</button></td>

        echo '</table>
          </div>';

    }
    function buscar($a_buscar){
      $cantidad=0;
      $sentencia = "SELECT  producto.id ,producto.nombre ,producto.precio,producto.precio_compra,producto.inventario,producto.stock,producto.bodega_inventario,producto.bodega_stock,producto.historial,producto.clabe,categoria_inventario.nombre AS categoria
      FROM producto
      LEFT JOIN  categoria_inventario ON producto.categoria =  categoria_inventario.id WHERE producto.nombre LIKE '%$a_buscar%' ORDER BY categoria_inventario.id ,producto.nombre ;";
      $comentario="Mostrar las categorias para el inventairo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '
        <table class="table">
          <thead>


            <tr>
              <th>Nombre</th>
              <th>Categoria</th>
              <th>Precio Venta</th>
              <th>Precio Compra</th>
              <th>Stock</th>
              <th>Inventario</th>
              <th>Bodega Stock</th>
              <th>Bodega Inventario</th>
              <th>Clave SAT</th>
              <th>Faltante</th>
              <th>Historial</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Borrar</th>
            </tr>
          </thead>
          <tbody>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        $cantidad++;
        $faltante=$fila['stock']-$fila['inventario'];
        if($faltante<=0){
          $faltante=0;
        }
        echo '<tr>
        <td>'.$fila['nombre'].'</td>
        <td>'.$fila['categoria'].'</td>
        <td>$'.$fila['precio'].'</td>
        <td>$'.$fila['precio_compra'].'</td>
        <td>'.$fila['stock'].'</td>
        <td>'.$fila['inventario'].'</td>
        <td>'.$fila['bodega_stock'].'</td>
        <td>'.$fila['bodega_inventario'].'</td>
        <td>'.$fila['clabe'].'</td>
        <td>'.$faltante.'</td>
        <td>'.$fila['historial'].'</td>
        <td><button class=" btn-warning"  onclick="editar_inventario('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>

        <td><button class="btn-danger" onclick="borrar_inventario('.$fila['id'].' ,1)"><span class="glyphicon glyphicon-edit"></span> Borrar</button></td>
      </tr>';
    }//<td><button onclick="agargar_conceptos_inventario('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Concepto</button></td>

        echo '</table>
         ';

    }
    function cancelado_restaurente($pedido,$cancelo){
      $tiempo=time();
      $sentencia = "INSERT INTO `restaurante_cancelado` (`fecha`, `pedido`, `cancelo`)
      VALUES ('$tiempo', '$pedido', '$cancelo');";
      $comentario="guardar la cancelacion de restaurante";
      $consulta= $this->realizaConsulta($sentencia,$comentario);

    }
    function saber_ultimo_pedido($hab_mov){
      $sentencia = "SELECT id FROM pedido WHERE mov = $hab_mov AND estado = 0 LIMIT 1";
      $comentario="Mostrar los productos por restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $pedido=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $pedido=$fila['id'];
      }
      return $pedido;
    }
    function aplicar_cancela_rest($pedido_id){
      $sentencia = "UPDATE `pedido` SET
      `estado` = '2'
      WHERE `id` = '$pedido_id';";
      $comentario="aplicar la cancelacion del pedido";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function precio_rest($id){
      $sentencia = "SELECT precio FROM producto WHERE id = $id LIMIT 1";
      //echo $sentencia;
      $comentario="obtener el total del pedido";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $precio=0;
      //echo $sentencia."</br>";
      while ($fila = mysqli_fetch_array($consulta))
      {
        $precio=$fila['precio'];
      }

      return $precio;
    }
    function saber_total_pedido($mov){
      $sentencia = "SELECT * ,perdido_rest.id AS ID FROM pedido LEFT JOIN perdido_rest ON pedido.id=perdido_rest.pedido  WHERE pedido.mov = $mov AND pedido.estado =0";
      //echo $sentencia;
      $comentario="obtener el total del pedido";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $total=0;

      while ($fila = mysqli_fetch_array($consulta))
      {
        $precio=$this->precio_rest($fila['producto']);
        $subtotal=$precio*$fila['cantidad'];
        $total=$total+$subtotal;
      }
      return $total;
    }
    function saber_pedido_rest($mov){
      $sentencia = "SELECT * ,perdido_rest.id AS ID ,pedido.id AS ped FROM pedido LEFT JOIN perdido_rest ON pedido.id=perdido_rest.pedido  WHERE pedido.mov = $mov AND pedido.estado =0";
      $comentario="obtener el total del pedido";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      return $consulta;
    }
    function cambiar_estado_pedido($id){
      $sentencia = "UPDATE `pedido` SET
      `estado` = '2'
      WHERE `id` = '$id';";
      echo $sentencia;
      $comentario="Cambiar el estado del pedido";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      return $consulta;
    }
    function obtener_nombre($id){
      $sentencia = "SELECT nombre FROM producto WHERE id = $id";
      //echo $sentencia;
      $comentario="obtener nombre del producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $nombre=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $nombre=$fila['nombre'];
      }
      return $nombre;
    }
    function obtener_precio($id){
      $sentencia = "SELECT precio FROM producto WHERE id = $id";
      //echo $sentencia;
      $comentario="obtener precio del producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $precio=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $precio=$fila['precio'];
      }
      return $precio;
    }
    function obtener_categoria($id){
      $sentencia = "SELECT categoria FROM producto WHERE id = $id";
      //echo $sentencia;
      $comentario="obtener la categoria del producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $categoria=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $categoria=$fila['categoria'];
      }
      return $categoria;
    }
    function saber_pedido($mov,$producto){
      $sentencia = "SELECT * FROM perdido_rest WHERE movimiento = $mov AND producto = $producto AND estado =0  LIMIT 1";
      //echo $sentencia;
      $comentario="Mostrar los productos por restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $pedido=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $pedido=$fila['id'];
      }
      return $pedido;
    }
    function saber_cantidad_pedido($producto){
      $sentencia = "SELECT cantidad FROM perdido_rest WHERE id = $producto LIMIT 1";
      //echo $sentencia;
      $comentario="Mostrar los productos por restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cantidad=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $cantidad=$fila['cantidad'];
      }
      return $cantidad;
    }
    function agregar_producto_apedido($mov,$producto,$hab){
      $pedido=$this->saber_pedido($mov,$producto);
      if($pedido==0){
        $sentencia = "INSERT INTO `perdido_rest` (`estado`, `movimiento`, `producto`, `cantidad`)
        VALUES ('0', '$mov', '$producto', '1');";
        $comentario="Agregar producto a pedido de restaurante";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }else{
        $cantidad= $this->saber_cantidad_pedido($pedido);
        $cantidad++;
        $sentencia = "UPDATE `perdido_rest` SET
        `cantidad` = '$cantidad'
        WHERE `id` = '$pedido';";
        $comentario="Modificar la cantidad de productos en el pedido";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //echo "Es producto ya existe";
      }

    }
    function eliminar_producto_apedido($producto){
      $sentencia = "DELETE FROM `perdido_rest`
      WHERE ((`id` = '$producto'));";
      $comentario="Eliminar pedido de restaurante";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function eliminar_producto_apedido_hospe($producto){
      $sentencia = "DELETE FROM `perdido_rest`
      WHERE ((`id` = '$producto'));";
      $comentario="Eliminar pedido de restaurante";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function mostar_pedido_mov_hospe($mov,$hab){
      $sentencia = "SELECT * , perdido_rest.id AS ID FROM perdido_rest INNER JOIN producto ON perdido_rest.producto = producto.id WHERE perdido_rest.movimiento =$mov AND perdido_rest.estado = 0";
      $comentario="Mostrar los productos por restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cunt=0;
      $total=0;
      echo '<div class="row pedido_restaurante color_black" >';
        echo '<div class="col-sm-2">';
          echo 'Cantidad';
        echo '</div>';
        echo '<div class="col-sm-4">';
          echo 'Nombre';
        echo '</div>';
        echo '<div class="col-sm-2">';
          echo 'Precio';
        echo '</div>';
        echo '<div class="col-sm-2">';
            echo 'Total';
        echo '</div>';
        echo '<div class="col-sm-2">';

        echo '</div>';
      echo '</div>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        $total=$total+($fila['precio']*$fila['cantidad']);
        $cunt++;
        echo '<div class="row pedido_restaurante color_black" >';
          echo '<div class="col-sm-2">';
            echo $fila['cantidad'];
          echo '</div>';
          echo '<div class="col-sm-4">';
            echo $fila['nombre'];
          echo '</div>';
          echo '<div class="col-sm-2">';
            echo '$'.$fila['precio'];
          echo '</div>';
          echo '<div class="col-sm-2">';
            echo '$'.($fila['precio']*$fila['cantidad']);
          echo '</div>';
          echo '<div class="col-sm-2">';
            echo '<button onclick="eliminar_producto_pedido_hospe('.$mov.','.$fila['ID'].','.$hab.')" type="button" class="btn btn-warning" >Quitar</button>';
          echo '</div>';
        echo '</div>';
      }
      if($cunt>0){
        echo '<div class="row pedido_restaurante color_black" >';

          echo '<div class="col-sm-2">';

          echo '</div>';
          echo '<div class="col-sm-4">';

          echo '</div>';
          echo '<div class="col-sm-2">';

          echo '</div>';
          echo '<div class="col-sm-2">';
            echo '$'.$total;
          echo '</div>';
          echo '<div class="col-sm-2">';

          echo '</div>';

        echo '</div>';
        echo '<div class="row boton_restaurante" >';

            echo '<input type="text" id="comentario_rest" placeholder="Comentario" class="btn-block">';

        echo '</div>';

        echo '<div class="row boton_restaurante" >';

            echo '<button onclick="pedir_rest_hospe('.$mov.','.$hab.')" type="button" class="btn btn-success btn-block">Pedir</button>';

        echo '</div>';
      }
    }
    function mostar_pedido_mov($mov,$hab){
      $sentencia = "SELECT * , perdido_rest.id AS ID FROM perdido_rest INNER JOIN producto ON perdido_rest.producto = producto.id WHERE perdido_rest.movimiento =$mov AND perdido_rest.estado = 0";
      $comentario="Mostrar los productos por restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cunt=0;
      $total=0;
      echo '<div class="row pedido_restaurante color_black" >';
        echo '<div class="col-sm-2">';
          echo 'Cantidad';
        echo '</div>';
        echo '<div class="col-sm-4">';
          echo 'Nombre';
        echo '</div>';
        echo '<div class="col-sm-2">';
          echo 'Precio';
        echo '</div>';
        echo '<div class="col-sm-2">';
            echo 'Total';
        echo '</div>';
        echo '<div class="col-sm-2">';

        echo '</div>';
      echo '</div>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        $total=$total+($fila['precio']*$fila['cantidad']);
        $cunt++;
        echo '<div class="row pedido_restaurante color_black" >';
          echo '<div class="col-sm-2">';
            echo $fila['cantidad'];
          echo '</div>';
          echo '<div class="col-sm-4">';
            echo $fila['nombre'];
          echo '</div>';
          echo '<div class="col-sm-2">';
            echo '$'.$fila['precio'];
          echo '</div>';
          echo '<div class="col-sm-2">';
            echo '$'.($fila['precio']*$fila['cantidad']);
          echo '</div>';
          echo '<div class="col-sm-2">';
            echo '<button onclick="eliminar_producto_pedido('.$mov.','.$fila['ID'].','.$hab.')" type="button" class="btn btn-warning" >Quitar</button>';
          echo '</div>';
        echo '</div>';
      }
      if($cunt>0){
        echo '<div class="row pedido_restaurante color_black" >';

          echo '<div class="col-sm-2">';

          echo '</div>';
          echo '<div class="col-sm-4">';

          echo '</div>';
          echo '<div class="col-sm-2">';

          echo '</div>';
          echo '<div class="col-sm-2">';
            echo '$'.$total;
          echo '</div>';
          echo '<div class="col-sm-2">';

          echo '</div>';

        echo '</div>';
        echo '<div class="row boton_restaurante" >';

            echo '<input type="text" id="comentario_rest" placeholder="Comentario" class="btn-block">';

        echo '</div>';

        echo '<div class="row boton_restaurante" >';

            echo '<button onclick="pedir_rest('.$mov.','.$hab.')" type="button" class="btn btn-success btn-block">Pedir</button>';

        echo '</div>';
      }
    }
    function mostar_producto_busqueda($hab_id,$busqueda){
      $sentencia = "SELECT * FROM producto WHERE nombre LIKE '%$busqueda%' ORDER BY categoria, nombre";
      $comentario="Mostrar los productos por restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cunt=0;
      echo '<div class="container color_black" >
            <table class="table">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Precio</th>
                  <th>Stock</th>
                  <th>Herramientas</th>
                </tr>
              </thead>
              <tbody>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '<tr>
            <td>'.$fila['nombre'].'</td>
            <td>'.$fila['precio'].'</td>
            <td>'.$fila['stock'].'</td>
            <td><button type="button" class="btn btn-primary btn-md" onclick="cargar_producto_rest('.$hab_id.','.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> Seleccionar</button></td>
          </tr>  ';
       /*

         echo '<button type="button" class="btn btn-success btn-md" onclick="cargar_producto_rest('.$hab_id.','.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> '.$fila['nombre'].'</button>';

       */
      }
      echo '</tbody>
          </table>
        </div>;';
    }
    function mostar_producto_categoria_hospe($hab_id,$categoria){
      $sentencia = "SELECT * FROM producto WHERE categoria = $categoria";
      $comentario="Mostrar los productos por restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cunt=0;
      while ($fila = mysqli_fetch_array($consulta))
      {

        if ($categoria%2==0){
          echo '<div class="col-md-4 col-lg-2 Alin-center boton-rest ">';
          echo '<button type="button" class="btn btn-success btn-md" onclick="cargar_producto_rest_hospe('.$hab_id.','.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> '.$fila['nombre'].'</button>';
          echo '</div>';
        }else{
          echo '<div class="col-md-4 col-lg-2  Alin-center boton-rest ">';
          echo '<button type="button" class="btn btn-primary btn-md" onclick="cargar_producto_rest_hospe('.$hab_id.','.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> '.$fila['nombre'].'</button>';
          echo '</div>';
        }
                $cunt++;
      }
      if($cunt==0){
        echo "No encotramos productos";
      }
    }

    function mostar_producto_categoria($categoria){
      $sentencia = "SELECT * FROM producto WHERE categoria = $categoria";
      $comentario="Mostrar los productos por restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cunt=0;
      echo '<div class="color_black" >
            <table class="table">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Precio</th>
                  <th>Stock</th>
                  <th>Herramientas</th>
                </tr>
              </thead>
              <tbody>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '<tr>
            <td>'.$fila['nombre'].'</td>
            <td>'.$fila['precio'].'</td>
            <td>'.$fila['stock'].'</td>
            <td><button type="button" data-dismiss="modal" class="btn btn-primary btn-md" onclick="cargar_comanda('.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> Seleccionar</button></td>
          </tr>  ';

      }
      echo '</tbody>
          </table>
        </div>;';

    }
    function mostar_producto($busqueda){
      $sentencia = "SELECT * FROM producto WHERE nombre LIKE '%$busqueda%'";
      $comentario="Mostrar los productos por restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cunt=0;
      echo '<div class="color_black" >
            <table class="table">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Precio</th>
                  <th>Stock</th>
                  <th>Herramientas</th>
                </tr>
              </thead>
              <tbody>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '<tr>
            <td>'.$fila['nombre'].'</td>
            <td>'.$fila['precio'].'</td>
            <td>'.$fila['stock'].'</td>
            <td><button type="button" data-dismiss="modal" class="btn btn-primary btn-md" onclick="cargar_comanda('.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> Seleccionar</button></td>
          </tr>  ';

      }
      echo '</tbody>
          </table>
        </div>;';

    }
    function cantidad_inventario($producto){
      $sentencia = "SELECT inventario FROM producto WHERE id = $producto LIMIT 1 ";
      $comentario="Mostrar inventario de un producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $inventario=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $inventario=$fila['inventario'];
      }
      return $inventario;
    }
    function cantidad_historial($producto){
      $sentencia = "SELECT historial FROM producto WHERE id = $producto LIMIT 1 ";
      $comentario="Mostrar historial de un producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $historial=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        $historial=$fila['historial'];
      }
      return $historial;
    }
    function editar_cantidad_resurtido($producto){
      $sentencia = "UPDATE `surtir` SET
      `estado` = '1'
      WHERE `id` = '$producto';";
      $comentario="Mostrar la cantidad de resurtido";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function editar_cantidad_inventario($producto, $cantidad){
      $sentencia = "UPDATE `producto` SET
        `inventario` = '$cantidad'
        WHERE `id` = '$producto';";
      $comentario="Mostrar historial de un producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function editar_cantidad_historial($producto, $cantidad){

      $sentencia = "UPDATE `producto` SET
        `historial` = '$cantidad'
        WHERE `id` = '$producto';";
      $comentario="Mostrar historial de un producto";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    function catgoria_restaurente_hospe($hab_id){
      $sentencia = "SELECT * FROM categoria_inventario ORDER BY nombre";
      $comentario="Mostrar las categorias en el restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cunt=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        if ($cunt%2==0){
          echo '
            <div class="col-sm-2 margen_inf">

                <button type="button" class="btn btn-success btn-md" onclick="bucar_categoria_rest_hospe('.$hab_id.','.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> '.$fila['nombre'].'</button>
            </div>';
          }else{
            echo '
              <div class="col-sm-2 margen_inf">

                  <button type="button" class="btn btn-primary btn-md" onclick="bucar_categoria_rest_hospe('.$hab_id.','.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> '.$fila['nombre'].'</button>
              </div>';
          }

                $cunt++;
      }
    }
    function catgoria(){
      $sentencia = "SELECT * FROM categoria_inventario ORDER BY nombre";
      $comentario="Mostrar las categorias en el restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $cunt=0;
      while ($fila = mysqli_fetch_array($consulta))
      {
        if ($cunt%2==0){
          echo '
            <div class="col-md-4 col-lg-4 margen_inf">
                <a href="#caja_herramientas" data-toggle="modal">
                  <button type="button" class="btn btn-success btn-block btn-lg" onclick="mostrar_categoria('.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> '.$fila['nombre'].'</button>
                </a>
            </div>';
          }else{
            echo '
              <div class="col-md-4 col-lg-4 margen_inf">
                  <a href="#caja_herramientas" data-toggle="modal">
                    <button type="button" class="btn btn-primary btn-block btn-lg" onclick="mostrar_categoria('.$fila['id'].' )"><span class="glyphicon glyphicon-cutlery"></span> '.$fila['nombre'].'</button>
                  </a>
              </div>';
          }

                $cunt++;
      }
    }
    function id_mysql_pedido(){
      $id=0;
      $sentencia = "SELECT id FROM pedido ORDER BY id DESC LIMIT 1";
      $comentario="Recojer el id del pedido anterior";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           $id= $fila['id'];
      }
      return $id;
    }
    function pedir_rest($recepcion,$mov,$comentarios,$nombre){
      $timepo=date("Y-m-d H:i");
      $sentencia = "INSERT INTO `pedido` (`recepcion`, `tiempo`, `mov`, `comentarios`, `hab`)
        VALUES ('$recepcion', '$timepo', '$mov', '$comentarios', '$nombre');";
      $comentario="Mostrar las categorias en el restaurente";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      $MYSql_id=$this->id_mysql_pedido();
      return $MYSql_id;
    }
    function editar_pedido($pedido,$mov){
      $sentencia = "UPDATE `perdido_rest` SET
      `estado` = '1',
      `pedido` = '$pedido'
      WHERE `movimiento` = '$mov' AND `estado` = '0';";
      $comentario="Editar los conceptos del pedido del restaurante";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
  }
  /**
   *
   */
  class Producto extends ConexionMYSql
  {
    public $id;
    public $nombre;
    public $categoria;
    public $precio;
    public $precio_compra;
    public $inventario;
    public $stock;
    public $bodega_inventario;
    public $bodega_stock;
    public $clabe;
    public $historial;
    public $sub_id =array();
    public $sub_producto=array();
    public $sub_cantidad =array();
    public $sub_nombre=array();
    public $contador;


    function __construct($id_producto)
    {
      $sentencia = "SELECT  producto.id ,producto.nombre ,producto.precio,producto.precio_compra,producto.inventario,producto.stock,producto.bodega_inventario,producto.bodega_stock,producto.historial,producto.clabe,categoria_inventario.nombre AS categoria
      FROM producto
      LEFT JOIN  categoria_inventario ON producto.categoria =  categoria_inventario.id
      WHERE producto.id= $id_producto
      ORDER BY categoria_inventario.id ,producto.nombre
      LIMIT 1;";
      //echo $sentencia;
      $comentario="Mostrar producto del inventario";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $this->id =$fila['id'];
        $this->nombre =$fila['nombre'];
        $this->categoria=$fila['categoria'];
        $this->precio=$fila['precio'];
        $this->precio_compra=$fila['precio_compra'];
        $this->inventario=$fila['inventario'];
        $this->stock=$fila['stock'];
        $this->bodega_inventario=$fila['bodega_inventario'];
        $this->bodega_stock=$fila['bodega_stock'];
        $this->clabe=$fila['clabe'];
        $this->historial=$fila['historial'];
        $this->sub_producto($id_producto);
      }
    }
    function sub_producto($id_producto){
      $this->contador=0;
      $sentencia = "SELECT * FROM sub_producto LEFT JOIN producto ON sub_producto.sub_producto = producto.id WHERE sub_producto.producto =$id_producto";
      //echo $sentencia;
      $comentario="Mostrar producto del inventario";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $this->sub_id[$this->contador] =$fila['id'];
        $this->sub_producto[$this->contador]=$fila['sub_producto'];
        $this->sub_cantidad[$this->contador]=$fila['cantidad'];
        $this->sub_nombre[$this->contador]=$fila['nombre'];
        $this->contador++;
      }
    }
  }

  class Categoria extends ConexionMYSql
  {

    function __construct()
    {

    }
    function mostrar_inventario(){
      $sentencia = "SELECT * FROM categoria_inventario ORDER BY nombre";
      $comentario="Mostrar las categorias para el inventairo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo

      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '  <option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
      }

    }
    function mostrar_inventario_editar($categoria){
      $sentencia = "SELECT * FROM categoria_inventario ORDER BY nombre";
      $comentario="Mostrar las categorias para el inventairo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo

      while ($fila = mysqli_fetch_array($consulta))
      {
        if($fila['nombre']==$categoria){
          echo '  <option value="'.$fila['id'].'" selected>'.$fila['nombre'].'</option>';
        }else{
          echo '  <option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
        }

      }

    }
    function mostrar(){
      $sentencia = "SELECT * FROM categoria_inventario ORDER BY nombre";
      $comentario="Mostrar las categorias para el inventairo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '<div class="table-responsive">
        <table class="table">
          <thead>
            <tr>

              <th>Nombre</th>
              <th><span class="glyphicon glyphicon-cog"></span> Ajustes</th>

            </tr>
          </thead>
          <tbody>';
          echo '<tr>


            <td><input type="text" class ="color_black" id="nombre_categoria" placeholder="Nombre" pattern="[a-z]{1,15}" ></td>
            <td><button class="btn-info" onclick="guardar_cetogoria_inventario()"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button></td>
        </tr>';
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '<tr>

        <td>'.$fila['nombre'].'</td>
        <td><button class="btn-danger">Editar</button></td>
      </tr>';
      }
        echo '</table>
          </div>';
    }
    function guardar($nombre){
      $sentencia = "INSERT INTO `categoria_inventario` (`nombre`)
      VALUES ('$nombre');";
      $comentario="guardar categoria para el inventairo";
      $this->realizaConsulta($sentencia,$comentario);
    }
  }
?>
