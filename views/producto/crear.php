
<h2>Crear producto</h2>

<?php if (isset($categorias)) : ?>

<div class="form_content">
    <form action="<?=base_url?>Producto/save" method="post" class="form" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" name="data[nombre]" id="nombre" required class="input_field">
        <br>
        <label for="categoria">Categor&iacute;a:</label>
        <select name="data[categoria]" id="categoria" required class="input_field">
            <?php while ($cat = $categorias->fetch(PDO::FETCH_OBJ)): ?>
                <option value="<?=$cat->id?>"><?=$cat->nombre?></option>
            <?php endwhile; ?>
            <br>
        </select>
        <label for="descripcion">Descripci&oacute;n:</label>
        <textarea name="data[descripcion]" id="descripcion" cols="50" rows="5" required class="input_field" placeholder="Descripción..."></textarea>
        <br>
        <label for="precio">Precio:</label>
        <input type="number" name="data[precio]" id="precio" step="0.01" required class="input_field">
        <br>
        <label for="stock">Stock:</label>
        <input type="number" name="data[stock]" id="stock" required class="input_field">
        <br>
        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen" required class="input_field">
        <br>
        <span class="error"><?= $error ?? "" ?></span>
        <input type="submit" value="Guardar" class="submit_registro">
    </form>
</div>

<?php else: ?>

<h2>No hay categor&iacute;as, <a href="<?=base_url?>Categoria/save">cree una</a> antes de añadir productos</h2>

<?php endif; ?>
