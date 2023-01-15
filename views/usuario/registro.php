
<h1>Registrar un nuevo usuario</h1>

<?php use Utils\Utils; ?>

<?php if (isset($_SESSION["register"]) && $_SESSION["register"] == "complete"): ?>
    <div class="alert alert-success" role="alert">
        Registro completado correctamente
    </div>
<?php elseif (isset($_SESSION["register"]) && $_SESSION["register"] == "failed"): ?>
    <div class="alert alert-danger" role="alert">
        Registro fallido, introduce bien los datos
    </div>
<?php endif; ?>
<?php Utils::deleteSession("register"); ?>

<div class="form_content">
    <form action="<?=base_url?>Usuario/registro" method="post" class="form">
        <label for="nombre">Nombre:</label>
        <input type="text" name="data[nombre]" id="nombre" required class="input_field">
        <br>
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="data[apellidos]" id="apellidos" required class="input_field">
        <br>
        <label for="email">Email:</label>
        <input type="email" name="data[email]" id="email" required class="input_field">
        <br>
        <label for="password">Contrase&ntilde;a:</label>
        <input type="password" name="data[password]" id="password" required class="input_field">
        <br>

        <?= $error ?? "" ?>
        <input type="submit" value="Registrarse" class="submit_registro">
    </form>
</div>