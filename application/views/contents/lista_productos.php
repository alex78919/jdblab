<div>
	<form action="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarBusqueda" method="post">
		<input type="text" class="textbox-large" name="busqueda_productos">
		<input type="submit" class="botones" value="Buscar">
	</form>
	<ul id="alfabetico">
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarProductos">Todos</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/a">A</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/B">B</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/c">C</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/d">D</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/e">E</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/f">F</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/g">G</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/h">H</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/i">I</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/j">J</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/k">K</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/l">L</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/m">M</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/n">N</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/ñ">Ñ</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/o">O</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/p">P</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/q">Q</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/r">R</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/s">S</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/t">T</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/u">U</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/v">V</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/w">W</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/x">X</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/y">Y</a></li>
		<li><a href="<?php echo base_url(); ?>index.php/ControladorProducto/mostrarAlfabeticamente/z">Z</a></li>
	</ul>
	<br class="clearfix">
	<table>
		<tr>
			<th>Codigo</th>	
			<th>Imagen</th>
			<th>Nombre</th>
			<th>Opciones</th>
		</tr>
		
		<?php foreach($productos as $producto) {?>
		<tr>
			<td>
				<?php echo strtoupper($producto['CODIGO_PRODUCTO']);?>
			</td>
			<td>
				<img class="imagen-producto" src="<?php echo base_url(); ?>fotos_productos/<?php echo $producto['RUTA_IMAGEN'];?>">
			</td>
			<td>
				<?php echo ucfirst($producto['NOMBRE_PRODUCTO']);?>
			</td>
			<td>
				<a href="<?php echo base_url();?>index.php/ControladorProducto/vistaProducto/<?php echo $producto['ID_PRODUCTO'];?>">Ver producto</a> 
			</td>
		</tr>	
		<?php }?>
	</table>
	<?php echo $this->pagination->create_links(); ?>
</div>