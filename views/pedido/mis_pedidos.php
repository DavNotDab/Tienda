
<?php if(!isset($error)) : ?>
    <h1>Tus pedidos:</h1>

    <table>
        <tr>
            <th>Fecha</th>
            <th>Coste</th>
            <th>Estado</th>
            <th></th>
        </tr>
        <?php if (isset($pedidos)): ?>
            <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido->fecha;?></td>
                    <td><?= $pedido->coste;?>€</td>
                    <td><?= $pedido->estado;?></td>
                    <td><a href="<?= base_url ?>Pedido/ver&id=<?= $pedido->id;?>">Detalles...</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
<?php else: ?>
    <h1>ERROR: <?=$error?></h1>
<?php endif; ?>
