<div>
	<h3>Creacion de subdivision</h3>
	<label>Categoria superior</label>
	<form action="<?php echo base_url(); ?>index.php/ControladorCategoria/agregarSubdivision" method="post">
		<select id="selectS" name="id_superior">
		<?php foreach ($categorias as $categoria): ?>
			<option value="<?= $categoria['ID_CATEGORIA'] ?>"><?= $categoria['NOMBRE_CATEGORIA'] ?></option>		
		<?php endforeach ?>
		</select>
		<label>Agregar categoria a la categoria superior</label>
		<select id="selectI" name="id_inferior">
		<?php foreach ($subCategorias as $subCategoria): ?>
			<option value="<?= $subCategoria['ID_CATEGORIA'] ?>"><?= $subCategoria['NOMBRE_CATEGORIA'] ?></option>		
		<?php endforeach ?>
		</select>
		<input type="submit" value="Guardar">
	</form>
</div>