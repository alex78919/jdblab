<div class="centrando">
	<ul class="sub-menu-lista">
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/operacionesProducto/<?php echo $producto['id']; ?>/editar">Editar</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/operacionesProducto/<?php echo $producto['id']; ?>/agregar_componente">Añadir componente</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/formPracticaRealizable">Añadir practica realizable</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/formAsignacion">Asignar a categoria</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/formActualizarFoto/<?php echo $producto['id']; ?>">Actualizar foto</a></li>
	</ul>
	<br class="clear">	
	<h3>Detalles del producto</h3>
	<img class="imagen-producto-detalle" src="<?php echo base_url(); ?>fotos_productos/<?php echo $producto['ruta_imagen'];?>">
	<table id="tabla-inf-prod">
		<tr>
			<td>Codigo:</td>
			<td><?php echo strtoupper($producto['codigo']); ?></td>
		</tr>
		<tr>
			<td>Nombre:</td>
			<td><?php echo ucfirst($producto['nombre']); ?></td>
		</tr>
		<tr>
			<td>Descripcion:</td>
			<td>
				<p class="parrafo-detalle"><?php echo ucfirst($producto['descripcion']); ?></p>
			</td>
		</tr>
		<tr>
			<td>Precio:</td>
			<td><?php echo $producto['precio']; ?></td>
		</tr>
	</table>
	<br class="clear">	
	<h3>Practicas realizables</h3>
	<table>
		<tr>
			<th>Practica realizable</th>
			<th>Opciones</th>
		</tr>
		<?php foreach($producto['practicas'] as $practica) {?>
			<tr>
				<td><?php echo ucfirst($practica['DESCRIPCION_PRACTICA']);?></td> 
				<td>
					<a href="<?php echo base_url(); ?>index.php/ControladorProducto/formEdicionPractica/<?= $practica['ID_PRACTICA'] ?>">Editar</a>
					<a href="<?php echo base_url(); ?>index.php/ControladorProducto/eliminarPractica/<?= $practica['ID_PRACTICA'] ?>">Eliminar</a>
				</td>
			</tr>
		<?php }?>	
	</table>
	<h3>Componentes</h3>
	<table>
		<tr>
			<th>Componente</th>
			<th>Cantidad</th>
			<th>Opciones</th>
		</tr>
		<?php foreach($producto['componentes'] as $componente) {?>
			<tr>
				<td><?php echo ucfirst($componente['ESPECIFICACION_COMPONENTE']);?></td>
				<td><?php echo $componente['NUMERO_COMPONENTES'];?></td>
				<td><a href="<?php echo base_url(); ?>index.php/ControladorProducto/formEdicionComponente/<?php echo $componente['ID_COMPONENTE'];?>">Editar</a></td>
				<td><a href="<?php echo base_url(); ?>index.php/ControladorProducto/eliminarComponente/<?php echo $componente['ID_COMPONENTE'];?>">Eliminar</a></td>
			</tr>
		<?php }?>	
	</table>	
</div>

