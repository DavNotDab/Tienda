
<h2>Crear Categor&iacute;a</h2>

<div class="form_content">
    <form action="<?=base_url?>Categoria/save" method="post" class="form">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required class="input_field">
        <br>
        <?php echo $error ?? "" ?>
        <input type="submit" value="Guardar" class="submit_registro">
    </form>
</div>