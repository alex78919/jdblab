<div>
	<h3>Producto: <?= $producto ?></h3>
	<h4>Edicion de componente</h4>
	<form action="<?php echo base_url(); ?>index.php/ControladorProducto/guardarEdicionComponente/<?= $componente['ID_COMPONENTE'] ?>" method="post">
		<table>
			<tr>
				<td>Especificacion componente:</td>
				<td><textarea name="componente"><?php echo $componente['ESPECIFICACION_COMPONENTE']; ?></textarea></td>
			</tr>
			<tr>
				<td>Cantidad componentes:</td>
				<td><input type="number" name="cantidad" value="<?php echo $componente['NUMERO_COMPONENTES']; ?>"></td>
			</tr>
		</table>
		<input type="submit" value="Guardar">
	</form>
	<?php echo validation_errors(); ?>
</div>