<?php
require_once 'conexion.php';

$db = Database::connect();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    // Verificar que los campos no estén vacíos
    if (!empty($nombre) && !empty($correo) && !empty($contrasena)) {
        // Verificar si el correo ya está registrado
        $stmt = $db->prepare("SELECT id FROM clientes WHERE correo = ?");
        $stmt->execute([$correo]);

        if ($stmt->rowCount() > 0) {
            $mensaje = '⚠️ Este correo ya está registrado.';
        } else {
            // Encriptar la contraseña y guardar el usuario
            $hashed = password_hash($contrasena, PASSWORD_DEFAULT);
            $insert = $db->prepare("INSERT INTO clientes (nombre, correo, contrasena) VALUES (?, ?, ?)");
            $insert->execute([$nombre, $correo, $hashed]);

            $mensaje = '✅ Registro exitoso. Ahora puedes iniciar sesión.';
        }
    } else {
        $mensaje = '❗ Por favor completa todos los campos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Registro de Cliente</h1>

        <?php if ($mensaje): ?>
            <div class="alert alert-info"><?= $mensaje ?></div>
        <?php endif; ?>

        <form method="post" class="card p-4">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico:</label>
                <input type="email" name="correo" id="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Registrarse</button>
        </form>

        <p class="mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>