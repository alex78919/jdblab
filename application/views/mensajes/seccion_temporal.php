<div>
	<h4><?= $titulo ?></h4>
	<?php foreach($enlaces as $enlace) { ?>
		<ul>
			<li><a href="<?= $enlace['link'] ?>"><?= $enlace['texto'] ?></a></li>
		</ul>
	<?php }?>
</div>