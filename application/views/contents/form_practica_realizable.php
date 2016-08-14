<div>
	<h3>Producto: <?= $producto['id'] ?></h3>
	<h4>Agregar practica realizable</h4>
	<form action="<?php echo base_url(); ?>index.php/ControladorProducto/registrarPracticaRealizable" method="post">
		<textarea class="textbox" name="practica_realizable"></textarea>
		<input type="submit" value="Guardar">
	</form>
</div>