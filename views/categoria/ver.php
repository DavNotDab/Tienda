
<?php if(isset($categoria)) : ?>

<h1>Productos en la categor&iacute;a <?=$categoria->nombre?></h1>

<table>
    <tr>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Imagen</th>
        <th></th>
    </tr>
    <?php if (isset($productos)): ?>

        <?php while ($prod = $productos->fetch(PDO::FETCH_OBJ)): ?>
            <tr>
                <td><?= $prod->nombre;?></td>
                <td><?= $prod->precio;?>€</td>
                <td><img src="../images/<?= $prod->imagen;?>" alt="producto" class="imagen"> </td>
                <td><a href="<?= base_url ?>Carrito/addProducto&id=<?= $prod->id;?>">Comprar</a></td>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
</table>

<?php else: ?>

<h1>No hay categor&iacute;as, <a href="<?=base_url?>Categoria/save">cree una</a> antes de añadir productos</h1>

<?php endif; ?>
