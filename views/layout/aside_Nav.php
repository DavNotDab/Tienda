

<aside class="side_nav">
    <nav class="nav_menu">
        <ul class="links">
            <li><a href="<?=base_url?>Usuario/logout">Cerrar Sesi&oacute;n</a></li>
            <?php if(isset($rol) && $rol == 1) : ?>
                <li><a href="<?=base_url?>zonaAdmin.php">Zona admin</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION["admin"])) : ?>
                <li><a href="<?=base_url?>Usuario/save">Registrar usuario</a></li>
                <li><a href="<?=base_url?>Usuario/mostrarTodos">Ver usuarios</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</aside>
