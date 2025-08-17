<?php
session_start();
require_once 'conexion.php';

$db = Database::connect();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    if (!empty($correo) && !empty($contrasena)) {
        $stmt = $db->prepare("SELECT * FROM clientes WHERE correo = ?");
        $stmt->execute([$correo]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cliente && password_verify($contrasena, $cliente['contrasena'])) {
            // Inicio de sesión exitoso
            $_SESSION['cliente_id'] = $cliente['id'];
            $_SESSION['cliente_nombre'] = $cliente['nombre'];
            header('Location: menu.php');
            exit;
        } else {
            $mensaje = '❌ Correo o contraseña incorrectos.';
        }
    } else {
        $mensaje = '⚠️ Por favor completa todos los campos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Mamalila</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Iniciar Sesión</h1>

        <?php if ($mensaje): ?>
            <div class="alert alert-warning"><?= $mensaje ?></div>
        <?php endif; ?>

        <form method="post" class="card p-4">
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico:</label>
                <input type="email" name="correo" id="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>

        <p class="mt-3">¿No tienes cuenta? <a href="registro_cliente.php">Regístrate aquí</a></p>
    </div>
</body>
</html>