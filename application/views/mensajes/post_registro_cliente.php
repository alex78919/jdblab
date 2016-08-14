<div>
	<p>Registro guardado!</p>
	<ul>
		<li><a href="<?php echo base_url() ?>">Ir a la pagina de inicio</a></li>
		<li><a href="<?php echo base_url() ?>index.php/ControladorCliente/cargarFormulario">Registrar otro cliente</a></li>
		<li><a href="<?php echo base_url() ?>index.php/ControladorCliente/cargarFormulario">Registrar otro cliente</a></li>
	</ul>
	<form action="<?php echo base_url(); ?>index.php/ControladorCliente/detallesCliente" method="post">
					<input type="hidden" name="id_cliente_detalle" value="<?php echo $id_cliente; ?>">
					<input type="submit" class="botones" value="Ver cliente">
	</form>
</div>