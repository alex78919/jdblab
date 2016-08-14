<div class="centrando">
	<h3>Lista de Clientes</h3>
	<input type="text" class="textbox-large" name="busqueda_cliente">
	<table id="tabla_clientes">
		<tr class="row-th">
			<th>Cliente</th>
			<th>Mas detalles</th>
		</tr>
		<?php foreach($clientes as $cliente) { ?>
		<tr>
			<td>
				<?php echo ucfirst($cliente['NOMBRES_PERSONA']) . " " . 
				ucfirst($cliente['APELLIDO_P_PERSONA']) . " " . ucfirst($cliente['APELLIDO_M_PERSONA']); ?>
			</td>
			<td>
				<form action="<?php echo base_url(); ?>index.php/ControladorCliente/detallesCliente" method="post">
					<input type="hidden" name="id_cliente_detalle" value="<?php echo $cliente['ID_PERSONA'] ?>">
					<input type="submit" class="botones" value="Mas Informacion">
				</form>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>