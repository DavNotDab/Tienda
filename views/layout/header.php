<?php
use Models\Categoria;
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tienda</title>
    <link rel="stylesheet" href="<?=base_url?>styles/style.css">
</head>
<body>
<!-- HEADER -->
<header id="header">
    <div id="logo">
        <img src="<?=base_url?>images/camiseta.png" alt="Camiseta Logo">
        <a href="<?=base_url?>">
            Tienda de Camisetas
        </a>
    </div>
    <nav>
        <ul>
            <?php if (isset($_SESSION["identity"])): ?>
                <li><a href="<?=base_url?>Usuario/logout">Cerrar Sesi&oacute;n</a></li>
                <li><a href="<?=base_url?>Pedido/misPedidos">Mis Pedidos</a></li>
                <?php if (isset($_SESSION["admin"])): ?>
                    <li><a href="<?=base_url?>Categoria/index">Gestionar Categor&iacute;as</a></li>
                    <li><a href="<?=base_url?>Producto/index">Gestionar Productos</a></li>
                    <li><a href="<?=base_url?>Pedido/gestion">Gestionar Pedidos</a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="<?=base_url?>Usuario/login">Iniciar Sesi&oacute;n</a></li>
                <li><a href="<?=base_url?>Usuario/registro">Registrarse</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php $categorias = Categoria::obtenerCategorias(); ?>
    <nav id="menu_cat">
        <ul>
            <?php while ($cat = $categorias->fetch(PDO::FETCH_OBJ)): ?>
                <li><a href="<?=base_url?>Categoria/ver&id=<?=$cat->id?>"><?=$cat->nombre?></a></li>
            <?php endwhile; ?>
        </ul>
    </nav>
        <ul>
            <li><a href="<?=base_url?>Carrito/ver">Carrito <?php if (isset($_SESSION["carrito"])) echo "(".count($_SESSION['carrito']["productos"]).")";?></a></li>
        </ul>
</header>