<div>
	<ul class="sub-menu-lista">
		<li>
			<a id="act-modal-proveedores" href="#">Agregar a grupos</a>
		</li>
	</ul>
	<br class="clear">
	<table>
		<tr>
			<td>Proveedor: </td>
			<td><?= $proveedor['nombre'] ?></td>
		</tr>
		<tr>
			<td>Descripcion del proveedor: </td>
			<td><?= $proveedor['descripcion'] ?></td>
		</tr>
		<tr>
			<td>Direccion: </td>
			<td><?= $proveedor['direccion'] ?></td>
		</tr>
	</table>
	<h4>Telefonos</h4>
	<table>
		<tr>
			<th>Numero</th>
			<th>Tipo</th>
			<th>Descripcion</th>
		</tr>
		<?php foreach ($proveedor['telefonos'] as $telefono): ?>
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
		<?php foreach ($proveedor['emails'] as $email): ?>
		<tr>
			<td><?php echo $email['NOMBRE_EMAIL']; ?></td>
			<td><?php echo $email['DESC_EMAIL']; ?></td>
		</tr>
		<?php endforeach ?>
	</table>
	<h4>Grupos al que pertenece este proveedor</h4>
	<ul>
		<?php foreach ($proveedor['grupos'] as $grupo): ?>
			<li><?php echo $grupo['NOMBRE_CLASIFICACION']; ?></li>
		<?php endforeach ?>
	</ul>
</div>
<div id="modal-proveedores">
	<input type="text" id="proveedores-texto">
	<br class="clear">
</div>