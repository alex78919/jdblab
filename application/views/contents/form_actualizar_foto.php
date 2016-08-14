<div>
	<form action="<?php echo base_url(); ?>index.php/ControladorProducto/guardarFoto/" method="post" enctype="multipart/form-data">
		<input type="file" name="foto_producto">	
		<input type="submit" value="Guardar">
	</form>
	<?php echo validation_errors(); ?>
</div>