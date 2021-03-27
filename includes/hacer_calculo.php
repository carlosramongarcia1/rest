<?php
    echo '
    <div class="panel panel-default">
        <div class="panel-heading">
            Ingrese las porciones de cada ingrediente
        </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="sel1">Lista de ingredientes:</label>';
            echo '<div class="row">
                <div class="col-sm-2">Nombre</div>
                <div class="col-sm-2">Cantidad antes preparar</div>
                <div class="col-sm-2">Cantidad despues preparar</div>
                <div class="col-sm-2">Precio</div>
                <div class="col-sm-1">Cantidad P/Porcion</div>
                <div class="col-sm-1">Total ingrediente</div>
                <div class="col-sm-1">Porsiones</div>
                <div class="col-sm-1">Merma</div>
                </div>
                </br>';
            for ($x=1; $x<=$_GET['cantidad']; $x++){
                echo '<div class="row">
                <div class="col-sm-2"> 
                    <input type="text" class="form-control" id="nombre'.$x.'" placeholder="nombre del producto '.$x.'"  onkeyup="hacer_calculo('.$_GET['cantidad'].')">
                </div>
                <div class="col-sm-2">
                    <input type="number" class="form-control" id="antes'.$x.'" placeholder="antes del producto '.$x.'"  onkeyup="hacer_calculo('.$_GET['cantidad'].')">
                </div>
                <div class="col-sm-2">
                    <input type="number" class="form-control" id="despues'.$x.'" placeholder="despues del producto '.$x.'"  onkeyup="hacer_calculo('.$_GET['cantidad'].')">
                </div>
                <div class="col-sm-2">
                    <input type="number" class="form-control" id="precio'.$x.'" placeholder="precio del producto '.$x.'" onkeyup="hacer_calculo('.$_GET['cantidad'].')">
                </div>
                <div class="col-sm-1">
                    <input type="number" class="form-control" id="cantidad_producto'.$x.'" placeholder="cantidad del producto '.$x.'" onkeyup="hacer_calculo('.$_GET['cantidad'].')">
                </div>
                <div class="col-sm-1">
                    <input type="number" class="form-control" id="total'.$x.'" placeholder="Total" onkeyup="hacer_calculo('.$_GET['cantidad'].')" disabled>
                </div>
                <div class="col-sm-1">
                    <input type="number" class="form-control" id="porcion'.$x.'" placeholder="porciones" onkeyup="hacer_calculo('.$_GET['cantidad'].')" disabled>
                </div>
                <div class="col-sm-1">
                    <input type="number" class="form-control" id="merma'.$x.'" placeholder="Merma"  onkeyup="hacer_calculo('.$_GET['cantidad'].')" disabled>
                </div>
                </div><br>';
            }

            echo '<div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-2"></div>
                <div class="col-sm-2"></div>
                <div class="col-sm-2"></div>
                <div class="col-sm-1"></div>
                <div class="col-sm-1"> <input type="number" class="form-control" id="supertotal" placeholder="Total" disabled> </div>
                <div class="col-sm-1"><input type="number" class="form-control" id="porcentaje" placeholder="Porcentage"  onkeyup="hacer_calculo_porcentage('.$_GET['cantidad'].')"></div>
                <div class="col-sm-1"><input type="number" class="form-control" id="totalporcen" placeholder="Total + Porcentage" disabled> </div>
                </div>
                </br>';
           echo  '<br>
        </div>   
    </div>';
?>