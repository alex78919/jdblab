<div>
	<ul>
	<?php foreach ($proveedores as $proveedor): ?>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProveedor/detallesProveedor/<?php echo $proveedor['ID_PROVEEDOR']; ?>"><?php echo $proveedor['NOMBRE_PROVEEDOR']; ?></a></li>
	<?php endforeach ?>
	</ul>
</div>