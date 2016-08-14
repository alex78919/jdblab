<div>
	<h3><?php echo $producto['nombre']; ?></h3>
	<form action="<?php echo base_url(); ?>index.php/ControladorProducto/operacionesProducto" method="post">
		<textarea name="practica_producto"></textarea>
		<input type="hidden"  name="opcion_producto" value="guardar_practicas">
		<input type="hidden" name="id_producto" value="<?php echo $producto['id']; ?>">
		<input type="submit" value="Agregar">
	</form>
	<?php echo validation_errors(); ?>
</div>