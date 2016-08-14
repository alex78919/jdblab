<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Backend JDBLAB</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/login.css">
    </head>
    <body>
        <header>
            <h2 id="banner">JDBLAB Inicio de sesion</h2>
        </header>
    <content>
        <?php echo form_open("/ControladorPrincipal/iniciarSesion");?>
            <table>
                <tr>
                    <td><label>Nombre de usuario: </label></td>
                    <td><input type="text" class="textbox" name="nombre_usuario"></td>
                </tr>
                <tr>
                    <td><label>Clave: </label></td>
                    <td><input type="password" class="textbox" name="clave_usuario"></td>
                </tr>
                <tr>
                    <td><input type="submit" class="botones" value="Acceder"></td>
                </tr>
                
            </table>

        </form>
    </content>
</body>
</html>