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
    SELECT p.id, p.cantidad, p.fecha, prod.nombre AS producto
    FROM pedidos p
    JOIN productos prod ON p.producto_id = prod.id
    WHERE p.cliente_nombre = ?
    ORDER BY p.fecha DESC
");
$stmt->execute([$cliente]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pedidos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Historial de Pedidos</h1>

        <form method="post" class="mb-4">
            <div class="row g-2">
                <div class="col-md-8">
                    <input type="text" name="cliente_nombre" class="form-control" placeholder="Ingresa tu nombre" required value="<?= htmlspecialchars($cliente) ?>">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">Buscar</button>
                </div>
            </div>
        </form>

        <?php if (!empty($pedidos)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $index => $pedido): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($pedido['producto']) ?></td>
                            <td><?= $pedido['cantidad'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($pedido['fecha'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($cliente): ?>
            <div class="alert alert-warning">No hay pedidos registrados para <strong><?= htmlspecialchars($cliente) ?></strong>.</div>
        <?php endif; ?>

        <a href="menu.php" class="btn btn-link mt-3">⬅ Volver al Menú</a>
    </div>
</body>
</html>