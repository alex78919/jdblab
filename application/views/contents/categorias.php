<div class="centrando">
	<h4>Nivel: <?php echo gettype($nodo) == "string" ? $nodo: $nodo['NOMBRE_CATEGORIA'];?></h4>

	<?php if(gettype($nodo) == "array") {?>
		<ul>
			<li>
				<a href="<?php echo base_url(); ?>index.php/ControladorCategoria/formAgregarSubdivisiones/<?= $nodo['ID_CATEGORIA'] ?>">Agregar Subdivision</a>
			</li>
		</ul>	
	<?php }?>
	
	<ul>
		<?php foreach($categorias as $categoria) {?>
		<li><a href="<?= base_url(); ?>index.php/ControladorCategoria/verCategoria/<?= $categoria['ID_CATEGORIA']; ?>"><?php echo $categoria['NOMBRE_CATEGORIA']; ?></a></li>
		<?php } ?>
	</ul>
</div>