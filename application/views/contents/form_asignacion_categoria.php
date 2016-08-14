<div>
	<h4>Asignar a categoria producto: <?= $nombre_producto ?></h4>
	<h5>Elegir categorias a asignar</h5>
	<form>
		<table>
			<?php foreach ($categorias as $categoria): ?>
				<tr>
					<td><?= $categoria['NOMBRE_CATEGORIA'] ?></td>
					<td><input type="checkbox" value="<?php echo $categoria['ID_CATEGORIA']; ?>"></td>
				</tr>	
			<?php endforeach ?>
		</table>
		<input type="submit" value="Guardar">
	</form>
</div>