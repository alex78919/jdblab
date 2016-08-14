<div>
	<form action="<?php echo base_url(); ?>index.php/ControladorProveedor/registrarProveedor" method="post">
		<table>
			<tr>
				<td>Nombre proveedor:</td>
				<td><input type="text" name="nombre_proveedor" value="<?php echo set_value('nombre_proveedor'); ?>"></td>
			</tr>
			<tr>
				<td>Descripcion:</td>
				<td><textarea name="descripcion_proveedor"></textarea><?php echo set_value('descripcion_proveedor'); ?></td>
			</tr>
			<tr>
				<td>Direccion:</td>
				<td><textarea name="direccion_proveedor"><?php echo set_value('direccion_proveedor'); ?></textarea></td>
			</tr>
			<tr>
				<td>Telefono:</td>
				<td><input type="text" name="telefono_proveedor" value="<?php echo set_value('telefono_proveedor'); ?>"></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><input type="text" name="email_proveedor" value="<?php echo set_value('email_proveedor'); ?>"></td>
			</tr>
		</table>
		<input type="submit" value="Guardar">
		<?php echo validation_errors(); ?>
	</form>
</div>