<div>
	<h3><?php echo $producto['nombre']; ?></h3>
	<h5>Agregar Componente producto: <?php echo $producto['nombre']?></h5>
	<form action="<?php echo base_url(); ?>index.php/ControladorProducto/agregarComponente" method="post">
		<table>
			<tr>
				<td>Nombre componente:</td>
				<td><input type="text" name="nombre_componente"></td>
			</tr>
			<tr>
				<td>Numero de componentes:</td>
				<td><input type="number" name="cantidad_componente"></td>
			</tr>
		</table>
		<input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
		<input type="submit" value="Agregar">
	</form>
	<?php echo validation_errors(); ?>
</div>