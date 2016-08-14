<div>
	<ul>
		<li>
			<a href="<?php echo base_url(); ?>index.php/ControladorProforma/exportarProforma/<?php echo $proforma['ID_PROFORMA'];?>/1">Exportar proforma JDBLAB
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>index.php/ControladorProforma/exportarProforma/<?php echo $proforma['ID_PROFORMA'];?>/2">Exportar proforma LABOFISI
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>index.php/ControladorProforma/exportarProforma/<?php echo $proforma['ID_PROFORMA'];?>/3">Exportar proforma LATEC
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>index.php/ControladorProforma/exportarProforma/<?php echo $proforma['ID_PROFORMA'];?>/4">Exportar proforma TECNOEQUIP
			</a>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>index.php/ControladorProforma/exportarProformaDetallada/<?php echo $proforma['ID_PROFORMA'];?>">Exportar proforma detallada
			</a>
		</li>
	</ul>
	<h3>Proformas Cliente: <?php echo $nombre_cliente; ?></h3>
	<table>
		<tr>
			<td>Numero de proforma: </td>
			<td><?php echo $proforma['NUMERO_PROFORMA']; ?></td>
		</tr>
		<tr>
			<td>Fecha proforma:</td>
			<td><?php echo $proforma['FECHA_PROFORMA']; ?></td>
		</tr>
	</table>
	<h3>Detalle de productos:</h3>	
	<table>
		<tr>
			<th>Codigo</th>
			<th>Producto</th>
			<th>Cantidad</th>
			<th>Precio</th>
			<th>Totales</th>
		</tr>
		<?php foreach ($productos as $producto) { ?>
			<tr>
				<td><?= strtoupper($producto['CODIGO_PRODUCTO'])?></td>
				<td><?= ucfirst($producto['NOMBRE_PRODUCTO'])?></td>
				<td><?= $producto['CANTIDAD_PRODUCTO']?></td>
				<td><?= $producto['PRECIO_VENTA']?></td>
				<td><?= $producto['CANTIDAD_PRODUCTO'] * $producto['PRECIO_VENTA']; ?></td>				
			</tr>
		<?php }?>

	</table>
	<h4>Total : <?php echo $total; ?></h4>
</div>