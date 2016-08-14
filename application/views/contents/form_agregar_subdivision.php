<div>
    <h4>Categoria: <?= $categoria['NOMBRE_CATEGORIA'] ?></h4>
    <form action="<?php echo base_url(); ?>index.php/ControladorCategoria/agregarSubdivision/<?= $categoria['ID_CATEGORIA'] ?>" method="post">
        <ul>
        <?php foreach ($subCategorias as $key => $subCategoria) { $i = 0; ?>
        	<li><input type="checkbox" name="<?php echo $i; ?>"><?= $subCategoria['NOMBRE_CATEGORIA'] ?></li>
        <?php } ?>
        </ul>
        <input type="submit" value="Registrar">
    </form>
</div>