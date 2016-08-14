<div id="cliente" class="centrando">
    <?php echo validation_errors(); ?>
    <h3>Datos Cliente</h3>
    <form action="<?php echo base_url(); ?>index.php/ControladorCliente/validarFormulario" method="post">
        <table>
            <tr>
                <td>NIT/CI:</td>
                <td><input type="text" class="textbox" name="nit_cliente" value="<?php echo set_value('nit_cliente'); ?>"></td>
            </tr>
            <tr>
                <td>Nombres:</td>
                <td><input type="text" class="textbox" name="nombre_cliente" value="<?php echo set_value('nombre_cliente'); ?>"></td>
            </tr>
            <tr>
                <td>Apellido paterno:</td>
                <td><input type="text" class="textbox" name="app_cliente" value="<?php echo set_value('app_cliente'); ?>"></td>
            </tr>
            <tr>
                <td>Apellido materno:</td>
                <td><input type="text" class="textbox" name="apm_cliente" value="<?php echo set_value('apm_cliente'); ?>"></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="text" class="textbox" name="email_cliente" value="<?php echo set_value('email_cliente'); ?>"></td>
            </tr>
            <tr>
                <td>Direccion:</td>
                <td><textarea class="textbox" name="direc_cliente"><?php echo set_value('direc_cliente'); ?></textarea></td>
            </tr>
            <tr>
                <td>Telefono:</td>
                <td><input type="text" class="textbox" name="telf_cliente" value="<?php echo set_value('telf_cliente'); ?>"></td>
            </tr>
            <tr>
                <td>Ciudad:</td>
                <td>
                    <select id="ciudades" class="textbox" name="ciudad_cliente">
                        <option value="-2"></option>
                    	<?php foreach($ciudades as $ciudad) { ?>
                        	<option value="<?php echo $ciudad["ID_CIUDAD"] ?>"><?php echo $ciudad["NOMBRE_CIUDAD"] ?></option> 
                       	<?php } ?>
                       	<option value="-1">Agregar otra ciudad</option>
                    </select>
                </td>
            </tr>
             <tr>
                <td>Institucion al que pertenece:</td>
                <td>
                    <select id="instituciones" class="textbox" name="institucion_cliente">
                        <option value="-2"></option>
                        <?php foreach($instituciones as $institucion) { ?>
                            <option value="<?php echo $institucion['ID_INSTITUCION'] ?>"><?php echo $institucion['NOMBRE_INSTITUCION'] ?></option> 
                        <?php } ?>
                        <option value="-1">Agregar otra institucion</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Cargo que ocupa en la institucion:</td>
                <td>
                    <select id="cargos" class="textbox" name="cargo_cliente">
                        <option value="-2"></option>
                        <?php foreach($cargos as $cargo) { ?>
                            <option value="<?php echo $cargo['ID_CARGO'] ?>"><?php echo $cargo['NOMBRE_CARGO'] ?></option> 
                        <?php } ?>
                        <option value="-1">Agregar otro cargo</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Profesion:</td>
                <td>
                    <select id="profesiones" class="textbox" name="profesion_cliente">
                        <option value="-2"></option>
                        <?php foreach($profesiones as $profesion) { ?>
                            <option value="<?php echo $profesion['ID_PROFESION'] ?>"><?php echo $profesion['NOMBRE_PROFESION'] ?></option> 
                        <?php } ?>
                        <option value="-1">Agregar otra profesion</option>
                    </select>
                </td>
            </tr>
        </table>
        <br class="espaciado">
        <input type="submit" class="botones" value="Registrar">
    </form>
    <div id="ciudad">
	    <label>Nombre de la ciudad:</label>
	    <input type="text" class="textbox" name="inp_ciudad_cliente">	
    </div>
    <div id="cargo">
    	<label>Cargo que ocupa:</label>
    	<input type="text" class="textbox" name="inp_cargo_cliente">
    </div>
    <div id="profesion">
    	<label>Profesion:</label>
    	<input type="text" class="textbox" name="inp_profesion_cliente">
    </div>
    <div id="institucion">
    	<label>Institucion:</label>
    	<input type="text" class="textbox" name="inp_institucion_cliente">
    </div>
</div>
