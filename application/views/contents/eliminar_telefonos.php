<div>
	<h4>Cliente: <?= $cliente['nombres'] . " " . $cliente['apellido_p'] . " " . $cliente['apellido_m']; ?></h4>
	<table>
		<?php foreach($cliente['telefonos'] as $telefono) { ?>
			<tr>
				<td><?= $telefono['NUMERO_TELEFONO'] ?></td>	
				<td>
					<a href="<?php echo base_url(); ?>index.php/ControladorCliente/eliminarTelefono/<?php echo $telefono['ID_TELEFONO']?>">Eliminar</a>
				</td>
			</tr>
		<?php }?>
	</table>
</div>