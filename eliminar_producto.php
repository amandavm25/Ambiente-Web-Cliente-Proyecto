<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $conn = Database::connect();
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$_POST['id']]);

    // Redirigir al dashboard luego de eliminar
    header("Location: dashboard_negocio.php");
    exit;
} else {
    echo "Solicitud inválida";
}