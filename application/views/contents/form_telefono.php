<div>
    <?php echo validation_errors(); ?>
    <h4>Cliente: <?= $cliente ?></h4>
    <form action="<?php echo base_url(); ?>index.php/ControladorCliente/guardarNumeroTelefono" method="post">
        <table>
            <tr>
                <td>Tipo telefono:</td>
                <td>
                    <select name="tipo_telefono">
                        <?php foreach ($tipos as $tipo) { ?>
                            <option value="<?php echo $tipo['ID_TIPO_TELF']; ?>"><?php echo $tipo['NOMBRE_TIPO_TELF']; ?></option>
                            <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Numero de telefono:</td>
                <td><input type="text" name="telefono"></td>
            </tr>
            <tr>
                <td>Detalles:</td>
                <td><textarea name="detalles_telefono"></textarea></td>
            </tr>
        </table>
        <input type="submit" value="Guardar">
    </form>
</div>