<?php
    echo '
    <div class="panel panel-default">
        <div class="panel-heading">
            Seleccione la cantidad de ingredientes que tiene tu producto
        </div>
    <div class="panel-body">
        <div class="form-group">
            <label for="sel1">Cantidad de ingredientes:</label>
            <select class="form-control" id="cantidad" onchange="cantidad_ingredientes()">';
                for($x=0; $x<=30; $x++){
                    echo '<option value="'.$x.'" >'.$x.'</option>';
                
                }
            echo '</select>
            <br>
        </div>   
    </div>';
?>