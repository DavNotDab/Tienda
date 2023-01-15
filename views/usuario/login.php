
<?php if (!isset($_SESSION["identity"])): ?>
    <h1>Iniciar Sesi&oacute;n</h1>
    <div class="form_content">
        <form action="<?=base_url?>Usuario/login" method="post" class="form">
            <label for="email">Email:</label>
            <input type="email" name="data[email]" id="email" required class="input_field">
            <br>
            <label for="password">Contrase&ntilde;a:</label>
            <input type="password" name="data[password]" id="password" required class="input_field">
            <br>
            <p class="error"><?= $error ?? ""?></p>
            <br>
            <input type="submit" value="Iniciar Sesión" class="submit_login">
        </form>
    </div>
<?php else: ?>
    <h2><?= $_SESSION["identity"]->nombre ?> <?= $_SESSION["identity"]->apellidos ?></h2>
<?php endif; ?>
