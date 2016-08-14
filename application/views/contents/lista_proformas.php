<div>

    <table>
        <tr>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Numero de proforma</th>
            <th>Opciones</th>
        </tr>
        <?php foreach ($proformas as $proforma) { ?>
            <tr>
                <td><?php echo $proforma['FECHA_PROFORMA'] ?></td>
                <td><?php echo ucfirst($proforma['NOMBRES_CLIENTE']) . " " . ucfirst($proforma['APELLIDO_P_CLIENTE']) . " " . ucfirst($proforma['APELLIDO_M_CLIENTE']); ?></td>
                <td><?php echo $proforma['NUMERO_PROFORMA'] ?></td>
                <td><a href="#">Detalles</a></td>
            </tr>
            <?php } ?>
    </table>
</div>