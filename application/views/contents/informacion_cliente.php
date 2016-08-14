<div>
	<ul class="sub-menu-lista">
		<li>
			<a href="<?php echo base_url(); ?>index.php/ControladorCliente/vistaEdicion">Editar</a>
		</li>
		<li>
			<a href="#">Proformas cliente</a>
			<ul>
				<li>
					<a href="<?php echo base_url(); ?>index.php/ControladorProforma/cargarVistaNuevaProforma/<?php echo $cliente['id']; ?>">Iniciar proforma</a>
					<li>
						<a href="<?php echo base_url(); ?>index.php/ControladorCliente/mostrarProformas/">Ver proformas</a>
					</li>		
				</li>
			</ul>
		</li>
		<li>
			<a href="#">Telefonos</a>
			<ul>
				<li>
					<a href="<?php echo base_url(); ?>index.php/ControladorCliente/cargarFormTelefono">Agregar telefono</a>
				</li>
				<li>
					<a href="<?php echo base_url(); ?>index.php/ControladorCliente/cargarEliminarTelefono">Eliminar telefonos</a>
				</li>	
			</ul>
		</li>
	</ul>
	<br class="clear">
	<table>
		<tr>
			<td>NIT/CI:</td>
			<td>
				<?php echo $cliente['nit_cliente']; ?>
			</td>
		</tr>
		<tr>
			<td>Cliente:</td>
			<td>
				<?php echo ucfirst($cliente['nombres']) . " " . ucfirst($cliente['apellido_p']) . 
				" " . ucfirst($cliente['apellido_m']); ?>
			</td>
		</tr>
		<tr>
			<td>Direccion:</td>
			<td>
				<p class="direccion"><?php echo $cliente['direccion'] ?></p>
			</td>
		</tr>
		<tr>
			<td>Ciudad:</td>
			<td>
				<?php echo $cliente['ciudad']['nombre'] ?>
			</td>
		</tr>
		<tr>
			<td>Profesion:</td>
			<td>
				<?php echo $cliente['profesion']['nombre'] ?>
			</td>
		</tr>
		<tr>
			<td>Institucion al que pertenece:</td>
			<td>
				<?php echo $cliente['institucion']['nombre'] ?>
			</td>
		</tr>
		<tr>
			<td>Cargo que ocupa:</td>
			<td>
				<?php echo $cliente['cargo']['nombre'] ?>
			</td>
		</tr>
	</table>
	<h4>Telefonos</h4>
	<table>
		<tr>
			<th>Numero</th>
			<th>Tipo</th>
			<th>Descripcion</th>
		</tr>
		<?php foreach ($cliente['telefonos'] as $telefono): ?>
		<tr>
			<td><?php echo $telefono['NUMERO_TELEFONO']; ?></td>
			<td><?php echo $telefono['NOMBRE_TIPO_TELF']; ?></td>
			<td><?php echo $telefono['DESCRIPCION_TELEFONO']; ?></td>
		</tr>
		<?php endforeach ?>
	</table>
	<h4>Emails</h4>
	<table>
		<tr>
			<th>Email</th>
			<th>Descripcion</th>
		</tr>
		<?php foreach ($cliente['emails'] as $email): ?>
		<tr>
			<td><?php echo $email['NOMBRE_EMAIL']; ?></td>
			<td><?php echo $email['DESC_EMAIL']; ?></td>
		</tr>
		<?php endforeach ?>
	</table>
</div>