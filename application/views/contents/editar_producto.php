<div>
	<form action="<?php echo base_url(); ?>index.php/ControladorProducto/guardarEdicion" method="post" enctype="multipart/form-data">
		<table class="centrando">
			<tr>
				<td>Código producto:</td>
				<td><?= $producto['codigo'] ?></td>
			</tr>
			<tr>
				<td>Nombre producto:</td>
				<td><?= $producto['nombre'] ?></td>
			</tr>
			<tr>
				<td>Precio:</td>
				<td><input type="text" class="textbox" name="precio_producto" value="<?= $producto['precio']; ?>"></td>
			</tr>
			<tr>
				<td>Descripcion:</td>
				<td><textarea class="textbox" name="descripcion_producto"><?= $producto['descripcion'] ?></textarea></td>
			</tr>
			<tr>
				<td><input type="submit" value="Guardar"></td>
			</tr>
		</table>
		<input type="hidden" name="id_producto" value="<?php echo $producto['id']; ?>">
	</form>
	<?php echo validation_errors(); ?>
</div>