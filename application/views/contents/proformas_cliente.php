<div>
	<h5>Proformas Cliente: <?= $cliente['nombres'] ?></h5>
	<table>
		<tr>
			<th>Fecha</th>
			<th>N° de proforma</th>
			<th>Opciones</th>
		</tr>
		<?php foreach($proformas as $proforma) {?>
			<tr>
				<td><?php echo $proforma['FECHA_PROFORMA'];?></td>	
				<td><?php echo $proforma['NUMERO_PROFORMA'];?></td>	
				<td>
					<a href="<?php echo base_url(); ?>index.php/ControladorProforma/detallesProforma/<?php echo $proforma['ID_PROFORMA'];?>">Detalles proforma</a>
				</td>
			</tr>
		<?php }?>
	</table>
</div>