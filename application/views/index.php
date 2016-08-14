<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Backend JDBLAB</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.12.3.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/main.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ajax_object.js"></script>
    </head>
    <body>
        <header>
            <h2 id="banner">JDBLAB Administracion</h2>
        </header>
    <content>
        <?= $menu_lateral ?>
        
        <div id="central">
            <?= $contenido ?>   
        </div>
    </content>
</body>
</html>