
<h1>Gestionar categor&iacute;as</h1>

<a href="<?=base_url?>Categoria/crear">Crear categor&iacute;a</a>

<table>
    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
    </tr>
    <?php if (isset($categorias)): ?>

        <?php while ($cat = $categorias->fetch(PDO::FETCH_OBJ)): ?>
            <tr>
                <td><?= $cat->id ?></td>
                <td><?= $cat->nombre ?></td>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
</table>
