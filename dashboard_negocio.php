<?php
require_once 'Producto.php';
$producto = new Producto();
$productos = $producto->obtenerTodos();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard - Negocio</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <header class="text-center p-3 bg-primary text-white">
            <h1>Dashboard del Negocio</h1>
        </header>
        <main class="container mt-4">
            <h2>Lista de Productos</h2>
            <table class="table table-striped">
                <thead>
                    <tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Imagen</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><?= htmlspecialchars($p['nombre']) ?></td>
                            <td>₡<?= $p['precio'] ?></td>
                            <td><img src="<?= $p['imagen'] ?>" width="50"></td>
                            <td>
                                <form method="post" action="eliminar_producto.php" onsubmit="return confirm('¿Deseas eliminar el producto?');">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="crear_producto_form.html" class="btn btn-success">Agregar Nuevo Producto</a>
        </main>
    </body>
</html>