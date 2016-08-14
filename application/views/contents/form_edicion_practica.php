<div>
	<h3>Producto: <?= $nombre_producto ?></h3>
	<h4>Edicion de practica realizable</h4>
	<form action="<?php echo base_url(); ?>index.php/ControladorProducto/guardarEdicionPractica/<?= $practica['ID_PRACTICA'] ?>" method="post">
		<textarea name="practica_realizable"><?php echo $practica['DESCRIPCION_PRACTICA']; ?></textarea>
		<input type="submit" value="Guardar">
	</form>
	<?php echo validation_errors(); ?>
</div>