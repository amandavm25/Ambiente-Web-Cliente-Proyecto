<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php');
    exit;
}

$db = Database::connect();
$cliente = $_SESSION['cliente_nombre'];

$stmt = $db->prepare("
    SELECT p.fecha, p.cantidad, prod.nombre AS producto
    FROM pedidos p
    JOIN productos prod ON p.producto_id = prod.id
    WHERE p.cliente_nombre = ?
    ORDER BY p.fecha DESC
    LIMIT 3
");
$stmt->execute([$cliente]);
$ultimos_pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resumen del Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Resumen del Cliente</h1>

        <form method="post" class="mb-4">
            <div class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="cliente_nombre" class="form-control" placeholder="Escribe tu nombre" required value="<?= htmlspecialchars($cliente) ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Ver resumen</button>
                </div>
            </div>
        </form>

        <?php if (!empty($cliente)): ?>
            <div class="alert alert-success">
                ¡Hola, <strong><?= htmlspecialchars($cliente) ?></strong>! Aquí están tus últimos pedidos:
            </div>

            <?php if (!empty($ultimos_pedidos)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ultimos_pedidos as $pedido): ?>
                            <tr>
                                <td><?= htmlspecialchars($pedido['producto']) ?></td>
                                <td><?= $pedido['cantidad'] ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning">No encontramos pedidos recientes a tu nombre.</div>
            <?php endif; ?>
        <?php endif; ?>

        <a href="menu.php" class="btn btn-link mt-3">⬅ Volver al Menú</a>
        <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
    </div>
</body>
</html>