
<h1>Carrito</h1>

<?php if (isset($errorStock)): ?>
    <h2 class="error">Error al realizar el pedido. No hay stock suficiente </h2>
<?php else: ?>

    <?php if (isset($productos)): ?>
        <?php if (count($productos) > 0): ?>
            <div class="carrito">
                <div class="contentCarrito">
                    <table class="tablaCarrito">
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Unidades</th>
                            <th>Subtotal</th>
                            <th>Eliminar</th>
                        </tr>
                        <?php $total = 0; $total_unidades = 0; ?>
                        <?php foreach($productos as $prod): ?>
                            <?php $subtotal = $prod->precio * $prod->unidades; ?>
                            <?php $total += $subtotal; $total_unidades += $prod->unidades; ?>
                            <tr>
                                <td><img src="../images/<?= $prod->imagen ?>" alt="producto" class="imagen"> </td>
                                <td><?= $prod->nombre;?></td>
                                <td><?= $prod->precio;?>€</td>
                                <td>
                                    <a href="<?=base_url?>Carrito/addProducto&id=<?=$prod->id?>">+</a>
                                    <?= $prod->unidades;?>
                                    <a href="<?=base_url?>Carrito/removeProducto&id=<?=$prod->id?>">-</a>
                                </td>
                                <td><?= $subtotal;?>€</td>
                                <td><a href="<?=base_url?>Carrito/deleteProducto&id=<?=$prod->id?>">Eliminar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="finalCarrito">
                    <a href="<?=base_url?>Carrito/delete">Borrar Carrito</a>
                    <h3>Total: <?= $total;?>€</h3>
                    <button type="button" onclick="location.href='<?=base_url?>Pedido/save'">Hacer pedido</button>
                </div>
                <p class="error"><?=$_SESSION["errorIdentity"] ?? "";?></p>
            </div>
        <?php else: ?>
            <h1>No hay productos en el carrito</h1>
        <?php endif; ?>
    <?php else: ?>

    <h1 class="error">Se ha producido un error</h1>

    <?php endif; ?>
<?php endif; ?>
