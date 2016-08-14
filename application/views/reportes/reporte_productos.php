<?php
header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=millonarios_fc.doc");
 header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<?php foreach ($productos as $producto): ?>
		<h5><?= strtoupper($producto['codigo']) . " " . ucfirst($producto['nombre'])?> </h5>
		<img src="/fotos_productos/<?= $producto['ruta_imagen'] ?>">
		<?php echo $producto['ruta_imagen']; ?>
		<p><?= $producto['descripcion'] ?></p>
		<ul>
		<?php foreach ($producto['practicas'] as $practica): ?>
			<li><?= $practica['DESCRIPCION_PRACTICA'] ?></li>				
		<?php endforeach ?>	
		</ul>
		<br>
		<ul>
		<?php foreach ($producto['componentes'] as $componente): ?>
			<li><?= $componente['ESPECIFICACION_COMPONENTE'] ?></li>				
		<?php endforeach ?>	
		</ul>
	<?php endforeach ?>
</body>
</html>
	