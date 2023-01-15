
<h1>Gestionar productos</h1>

<a href="<?=base_url?>Producto/crear">Crear producto</a>

<table>
    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
        <th>PRECIO</th>
        <th>STOCK</th>
    </tr>
    <?php if (isset($productos)): ?>

        <?php while ($prod = $productos->fetch(PDO::FETCH_OBJ)): ?>
            <tr>
                <td><?= $prod->id ?></td>
                <td><?= $prod->nombre ?></td>
                <td><?= $prod->precio ?></td>
                <td><?= $prod->stock ?></td>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
</table>
