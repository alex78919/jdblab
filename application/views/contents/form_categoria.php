<div>
	<h4>Crear nueva categoria</h4>
	<form action="<?php echo base_url(); ?>index.php/ControladorCategoria/crearCategoria" method="post">
		<table>
			<tr>
				<td>Nombre de la categoria:</td>
				<td><input type="text" name="nombre_categoria"></td>
			</tr>
			<tr>
				<td>Descripcion:</td>
				<td><textarea name="descripcion_categoria"></textarea></td>
			</tr>
		</table>
		<input type="submit" value="Guardar">
	</form>
</div>