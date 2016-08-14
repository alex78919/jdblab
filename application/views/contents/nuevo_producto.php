<div class="centrando">
	<form action="<?php echo base_url(); ?>index.php/ControladorProducto/registrarProducto" method="post" enctype="multipart/form-data">
		<table>
			<tr>
				<td>Código producto:</td>
				<td><input type="text" class="textbox" name="codigo_producto"></td>
			</tr>
			<tr>
				<td>Nombre producto:</td>
				<td><input type="text" class="textbox" name="nombre_producto"></td>
			</tr>
			<tr>
				<td>Precio:</td>
				<td><input type="text" class="textbox" name="precio_producto"></td>
			</tr>
			<tr>
				<td>Descripcion:</td>
				<td><textarea class="textbox" name="descripcion_producto"></textarea></td>
			</tr>
			<tr>
				<td>Imagen producto</td>
				
				<td><input type="file" name="upload_imagen"/></td>
			</tr>
		</table>
		<input type="submit" class="botones" value="Registrar">
	</form>
<?php echo validation_errors(); ?>
</div>