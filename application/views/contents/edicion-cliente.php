<form action="<?php echo base_url(); ?>index.php/ControladorCliente/guardarEdicion" method="post">
        <?php echo validation_errors(); ?>
        <table>
            <tr>
                <td>NIT/CI:</td>
                <td><input type="text" class="textbox" name="nit_cliente" value="<?php echo $cliente['nit_cliente']; ?>"></td>
            </tr>
            <tr>
                <td>Nombres:</td>
                <td><input type="text" class="textbox" name="nombre_cliente" value="<?php echo $cliente['nombres']; ?>"></td>
            </tr>
            <tr>
                <td>Apellido paterno:</td>
                <td><input type="text" class="textbox" name="app_cliente" value="<?php echo $cliente['apellido_p']; ?>"></td>
            </tr>
            <tr>
                <td>Apellido materno:</td>
                <td><input type="text" class="textbox" name="apm_cliente" value="<?php echo $cliente['apellido_m']; ?>"></td>
            </tr>
            <tr>
                <td>Direccion:</td>
                <td><textarea class="textbox" name="direc_cliente"><?php echo $cliente['direccion']; ?></textarea></td>
            </tr>
            <tr>
                <td>Ciudad:</td>
                <td>
                    <select class="textbox" name="ciudad">
                    <option value="-2"></option>
                    <?php foreach($ciudades as $ciudad) { 
                        if($cliente['ciudad']['id'] == $ciudad['ID_CIUDAD']) { ?>
                            <option selected="1" value="<?php echo $ciudad['ID_CIUDAD']; ?>"><?php echo $ciudad['NOMBRE_CIUDAD']; ?></option>  
                        <?php } else {?>
                            <option value="<?php echo $ciudad['ID_CIUDAD']; ?>"><?php echo $ciudad['NOMBRE_CIUDAD']; ?></option>      
                        <?php }?>    
                    <?php }?>
                    </select>    
                </td>
            </tr>
            <tr>
                <td>Institucion a la que pertenece:</td>
                <td>
                    <select class="textbox" name="institucion">
                        <option value="-2"></option>
                    <?php foreach($instituciones as $institucion) { 
                        if($cliente['institucion']['id'] == $institucion['ID_INSTITUCION']) { ?>
                            <option selected="1" value="<?php echo $institucion['ID_INSTITUCION']; ?>"><?php echo $institucion['NOMBRE_INSTITUCION']; ?></option> 
                        <?php } else {?>
                            <option value="<?php echo $institucion['ID_INSTITUCION']; ?>"><?php echo $institucion['NOMBRE_INSTITUCION']; ?></option>
                        <?php }?>    
                    <?php }?>
                    </select>    
                </td>
            </tr>       
            <tr>
                <td>Cargo que ocupa en la institucion:</td>
                <td>
                    <select class="textbox" name="cargo">
                        <option value="-2"></option>
                    <?php foreach($cargos as $cargo) { 
                        if($cliente['cargo']['id'] == $cargo['ID_CARGO']) { ?>
                            <option selected="1" value="<?php echo $cargo['ID_CARGO']; ?>"><?php echo $cargo['NOMBRE_CARGO']; ?></option> 
                        <?php } else {?>
                            <option value="<?php echo $cargo['ID_CARGO']; ?>"><?php echo $cargo['NOMBRE_CARGO']; ?></option> 
                        <?php }?>    
                    <?php }?>
                    </select>    
                </td>
            </tr>    
            <tr>
                <td>Profesion:</td>
                <td>
                    <select class="textbox" name="profesion">
                        <option value="-2"></option>
                    <?php foreach($profesiones as $profesion) { 
                        if($cliente['profesion']['id'] == $profesion['ID_PROFESION']) { ?>
                            <option selected="1" value="<?php echo $profesion['ID_PROFESION']; ?>"><?php echo $profesion['NOMBRE_PROFESION']; ?></option> 
                        <?php } else {?>
                            <option value="<?php echo $profesion['ID_PROFESION']; ?>"><?php echo $profesion['NOMBRE_PROFESION']; ?></option> 
                        <?php }?>    
                    <?php }?>
                    </select>    
                </td>
            </tr>        
	</table>
    <input type="submit" value="Guardar">
</form>
