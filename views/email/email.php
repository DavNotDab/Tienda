<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmacion de pedido</title>
</head>
<body>
    <h1>Hola <?=$_SESSION["identity"]->nombre?>, tu pedido se ha realizado correctamente</h1>

    <h3>Aqu&iacute; tienes un resumen de tu pedido:</h3>
    <h4>Id del pedido: <?=$_SESSION["IdPedido"]?></h4>

    <table>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Unidades</th>
            <th>Subtotal</th>
        </tr>
        <?php $productos = $_SESSION["carrito"]["productos"]; ?>
        <?php foreach ($productos as $producto) : ?>
            <tr>
                <td><?=$producto->nombre?></td>
                <td><?=$producto->precio?></td>
                <td><?=$producto->unidades?></td>
                <td><?=$producto->precio * $producto->unidades?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h4>Total del pedido: <?=$_SESSION["carrito"]["total"]?></h4>

</body>
</html>