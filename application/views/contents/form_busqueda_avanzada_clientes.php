<div>
    <form action="<?php echo base_url(); ?>index.php/ControladorCliente/mostrarBusquedaSegmentada" method="post">
        <label>Buscar por:</label>
        <select name="opcion" id="opcion-busqueda-avanzada">
            <option value="ciudad">Ciudad</option>
            <option value="profesion">Profesion</option>
            <option value="cargo">Cargo</option>
            <option value="institucion">Institucion</option>
        </select>
        <label>Parametro:
            <select id="opcion-seleccionada" name="filtro">
                <?php foreach ($ciudades as $ciudad) { ?>
                    <option value="<?php echo $ciudad['ID_CIUDAD']; ?>"><?php echo $ciudad['NOMBRE_CIUDAD']; ?></option>
                    <?php } ?>
                </select>
            </label>
            <label>Cliente: <input type="text" name="filtro_cliente"></label>
            <input type="submit" value="Buscar">
        </form>
        <br class="clear">
        <?php if (isset($busqueda)) { ?>
            <table>
                <tr class="row-th">
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Direccion</th>
                    <th>Mas detalles</th>
                </tr>
                <?php foreach ($clientes as $cliente) { ?>
                    <tr>
                        <td>
                            <?php
                            echo ucfirst($cliente['NOMBRES_CLIENTE']) . " " .
                            ucfirst($cliente['APELLIDO_P_CLIENTE']) . " " . ucfirst($cliente['APELLIDO_M_CLIENTE']);
                            ?>
                        </td>
                        <td>
            <?php echo $cliente['EMAIL_CLIENTE']; ?>
                        </td>
                        <td>
                            <p class="direccion"><?php echo $cliente['DIRECCION_CLIENTE']; ?></p>	
                        </td>
                        <td>
                            <form action="<?php echo base_url(); ?>index.php/ControladorCliente/detallesCliente" method="post">
                                <input type="hidden" name="id_cliente_detalle" value="<?php echo $cliente['ID_CLIENTE'] ?>">
                                <input type="submit" class="botones" value="Mas Informacion">
                            </form>
                        </td>
                    </tr>
            <?php } ?>
            </table>
            <?php echo $this->pagination->create_links(); ?>	
    <?php } ?>
</div>