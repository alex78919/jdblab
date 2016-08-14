<form action="<?php echo base_url(); ?>index.php/ControladorCliente/guardarEdicion" method="post">
	<table>
		<?php $i = 1; foreach($cliente['telefonos'] as $telefono) {?>
			<tr>
				<td><?php echo "Telefono " . $i . ":"; ?></td>
				<td><input type="text" value="<?php echo $telefono; ?>"></td>
			</tr>
		<?php } ?>
	</table>
	<input type="hidden" name="tipo_edicion" value="telefonos">
</form>