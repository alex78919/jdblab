<label>Filtrar productos por:</label>
<select id="input-categoria">
    <option value="-1">Todos</option>
    <?php foreach($categorias as $categoria){?>
        <option value="<?php echo $categoria['ID_CATEGORIA'];?>"><?php echo $categoria['NOMBRE_CATEGORIA'];?></option>
    <?php }?>
</select>
<input type="text" id="input-productos">
<div id="proforma-productos">
    <table>
        <tr>
            <th>Seleccionar</th>
            <th>Codigo</th>
            <th>Producto</th>
            <th>Precio</th>
        </tr>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td><input type="checkbox" value="<?php echo $item['ID_PRODUCTO']; ?>"></td>
                <td>
                    <?= $item['CODIGO_PRODUCTO']; ?>
                </td>
                <td>
                    <?= $item['NOMBRE_PRODUCTO']; ?>
                </td>
                <td>
                    <?= $item['PRECIO_PRODUCTO']; ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
