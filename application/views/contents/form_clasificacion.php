<div>
	<form action="<?php echo base_url(); ?>index.php/ControladorProveedor/registrarGrupo" method="post">
		<h3>Registro de nuevo grupo</h3>
		<table>
			<tr>
				<td>Nombre del grupo: </td>
				<td><input type="text" name="nombre_grupo"></td>
			</tr>
			<tr>
				<td>Descripcion: </td>
				<td><textarea name="descripcion_grupo"></textarea></td>
			</tr>
		</table>
		<input type="submit" value="Guardar">
	</form>
	<?php echo validation_errors() ?>;
</div>