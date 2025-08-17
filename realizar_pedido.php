<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit;
}

$db = Database::connect();
$cliente = $_SESSION['cliente_nombre'];
$mensaje = '';

// Guardar pedido al enviar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = $_POST['cliente_nombre'] ?? '';
    $producto_id = $_POST['producto_id'] ?? '';
    $cantidad = $_POST['cantidad'] ?? '';

    if (!empty($cliente) && !empty($producto_id) && !empty($cantidad)) {
        $stmt = $db->prepare("INSERT INTO pedidos (cliente_nombre, producto_id, cantidad) VALUES (?, ?, ?)");
        $stmt->execute([$cliente, $producto_id, $cantidad]);
        $mensaje = "✅ Pedido registrado correctamente.";
    } else {
        $mensaje = "❗ Todos los campos son obligatorios.";
    }
}

// Obtener productos para el select
$productos = $db->query("SELECT id, nombre FROM productos")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Realizar Pedido</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Realizar Pedido</h1>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-info"><?= $mensaje ?></div>
        <?php endif; ?>

        <form method="post" class="card p-4">
            <div class="mb-3">
                <label for="cliente_nombre" class="form-label">Nombre del Cliente:</label>
                <input type="text" name="cliente_nombre" id="cliente_nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="producto_id" class="form-label">Producto:</label>
                <select name="producto_id" id="producto_id" class="form-select" required>
                    <option value="">-- Selecciona un producto --</option>
                    <?php foreach ($productos as $producto): ?>
                        <option value="<?= $producto['id'] ?>"><?= htmlspecialchars($producto['nombre']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad:</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" required min="1" value="1">
            </div>

            <button type="submit" class="btn btn-success">Confirmar Pedido</button>
        </form>

        <a href="menu.php" class="btn btn-link mt-3">⬅ Volver al Menú</a>
    </div>
</body>
</html>