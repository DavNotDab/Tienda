
<?php if(!isset($error)) : ?>
    <h1>Productos del pedido:</h1>

    <table>
        <tr>
            <th>Producto</th>
            <th>Imagen</th>
            <th>Precio</th>
            <th>Unidades</th>
            <th>Subtotal</th>
        </tr>
        <?php if (isset($productos)): ?>
            <?php $total = 0; ?>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $producto["nombre"];?></td>
                    <td><img src="../images/<?=$producto["imagen"]?>" alt="imagen <?=$producto["nombre"]?>" class="imagen"></td>
                    <td><?= $producto["precio"];?>€</td>
                    <td><?= $producto["unidades"];?></td>
                    <td><?= $producto["precio"] * $producto["unidades"];?>€</td>
                </tr>
                <?php $total += $producto["precio"] * $producto["unidades"];?>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <h3>Valor total del pedido: <?=$total ?? ""?>€</h3>
<?php else: ?>
    <h1>ERROR: <?=$error?></h1>
<?php endif; ?>
