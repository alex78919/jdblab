<div>
	<label>Cliente: <?php echo ucfirst($cliente['nombres']) . " " . ucfirst($cliente['apellido_p']) . " " . ucfirst($cliente['apellido_m']); ?></label>
	<form action="<?php echo base_url(); ?>index.php/ControladorProforma/registrarProforma" id="proforma_productos" method="post">
		<table id="tabla-nueva-proforma">
			<tr>
				<th>Codigo</th>
				<th>Producto</th>
				<th>Cantidad</th>
				<th>Precio unitario</th>
				<th>Subtotales</th>
			</tr>
		</table>
		<label id="total-importe"></label>
		<br class="clear">
		<input type="hidden" name="guardar_datos_proforma" id="datos_proforma">
		<input type="hidden" name="id_cliente" value="<?php echo $cliente['id']; ?>">
		<ul>
			<li><input type="button" id="agregar_items_proforma" value="Añadir productos"></li>
			<li><input type="button" id="enviar_proforma" value="Guardar proforma"></li>
		</ul>
	</form>
	<div id="proforma">
		<?= $plantilla_productos ?>
	</div>
</div>