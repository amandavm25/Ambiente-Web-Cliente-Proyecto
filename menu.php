<?php
session_start();
require_once 'conexion.php'; // ← Esta línea es esencial

if (!isset($_SESSION['cliente_nombre'])) {
    header("Location: login.php");
    exit;
}
$nombreCliente = $_SESSION['cliente_nombre'];

try {
    $db = Database::connect();
    $stmt = $db->query("SELECT * FROM productos");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error al obtener productos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú del Restaurante - Mamalila</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <header class="p-3 bg-primary text-white d-flex justify-content-between align-items-center flex-wrap">
    <div class="text-center w-100 mb-2">
        <h1 class="m-0">Menú del Restaurante</h1>
        <a href="pedido.html" class="btn btn-light mt-2">Realizar Pedido</a>
    </div>
    <div class="text-end w-100">
        <span class="me-3 fw-semibold">Bienvenid@ <?= htmlspecialchars($nombreCliente) ?></span>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>
</header>

    <main class="container mt-4">
        <section id="menu-section">
            <h2 class="mb-4">Explora nuestros platos disponibles</h2>
            <div id="menu-list" class="row">
                <?php foreach ($productos as $producto): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <?php if (!empty($producto['imagen'])): ?>
                                <img src="img/<?= htmlspecialchars($producto['imagen']) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                                <p class="card-text"><strong>₡<?= number_format($producto['precio']) ?></strong></p>
                                <a href="#" class="btn btn-success">Agregar al pedido</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer class="text-center p-3 bg-dark text-light mt-4">
        <p>&copy; 2025 🥘 Mamalila - Sabores Caseros con Amor. Todos los derechos reservados.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>