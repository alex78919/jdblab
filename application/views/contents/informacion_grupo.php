<div>
	<ul class="sub-menu-lista">
		<li>
			<a id="act-modal-grupos" href="#">Asignar miembros</a>
		</li>
	</ul>
	<br class="clear">
	<table>
		<tr>
			<td>Nombre del grupo: </td>
			<td><?php echo $grupo['nombre']; ?></td>
		</tr>
		<tr>
			<td>Descripcion: </td>
			<td><?php echo $grupo['descripcion']; ?></td>
		</tr>
	</table>
	<h4>Proveedores asignados a este grupo</h4>
	<table>
		<?php foreach ($grupo['miembros_grupo'] as $proveedor): ?>
			<tr>
				<td>
					<a href="<?php echo base_url(); ?>index.php/ControladorProveedor/detallesProveedor/<?php echo $proveedor->ID_PROVEEDOR; ?>"><?php echo ucfirst($proveedor->NOMBRE_PROVEEDOR); ?></a>	
				</td>
				<td>
					<a href="<?php echo base_url(); ?>index.php/ControladorProveedor/eliminarMiembro/<?php echo $proveedor->ID_PROVEEDOR; ?>">Eliminar</a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
</div>