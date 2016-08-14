<table>
    <?php foreach ($clientes as $cliente) { ?>
        <tr>
            <td>
                <?php
                echo $cliente['NOMBRES_CLIENTE'] . " " . $cliente['APELLIDO_P_CLIENTE'] .
                " " . $cliente['APELLIDO_M_CLIENTE'];
                ?>
            </td>
            <td>
                <?php echo $cliente['EMAIL_CLIENTE']; ?>
            </td>
            <td>
                <?php echo $cliente['DIRECCION_CLIENTE']; ?>
            </td>
        </tr>
    <?php } ?>
</table>