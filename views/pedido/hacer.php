
<?php if (isset($_SESSION["carrito"])) : ?>

<div class="info_carrito">
    <h3>Resumen del pedido:</h3>
    <h3>Nº de art&iacute;culos: <b><?= $_SESSION["carrito"]["total_unidades"]?></b></h3>
    <h3>Subtotal: <b><?= $_SESSION["carrito"]["total"]?>€</b></h3>
    <h3>Env&iacute;o: <b>3,99€</b></h3>
    <hr>
    <h2>Total: <b><?= $_SESSION["carrito"]["total"] + 3.99?>€</b></h2>
</div>

<div class="form_content">
    <h2>Direcci&oacute;n de env&iacute;o:</h2>
    <form action="<?=base_url?>Pedido/save" method="post" class="form">
        <label for="direccion">Calle y nº:</label>
        <input type="text" name="data[direccion]" id="direccion" required class="input_field">
        <br>
        <label for="direccion2">Escalera, Piso, Puerta:</label>
        <input type="text" name="data[direccion2]" id="direccion2" class="input_field">
        <br>
        <label for="localidad">Localidad:</label>
        <input type="text" name="data[localidad]" id="localidad" required class="input_field">
        <br>
        <label for="provincia">Provincia:</label>
        <input type="text" name="data[provincia]" id="provincia" required class="input_field">
        <br>
        <span class="error"><?= $error ?? "";?></span>
        <input type="submit" value="Hacer pedido" class="submit">
    </form>
</div>

<?php else: ?>

<h2>Error, el carrito no puede estar vac&iacute;o. <a href="<?=base_url?>">Contin&uacute;e comprando</a></h2>

<?php endif; ?>
