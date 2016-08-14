<div>
	<table>
		<?php foreach ($grupos as $grupo): ?>
			<tr>
				<td><?php echo ucfirst($grupo->NOMBRE_CLASIFICACION); ?></td>
				<td>
					<a href="<?php echo base_url(); ?>index.php/ControladorProveedor/detallesGrupo/<?php echo $grupo->ID_CLASIFICACION ?>">Detalles</a>
				</td>
			</tr>
		<?php endforeach ?>
	</table>
</div>