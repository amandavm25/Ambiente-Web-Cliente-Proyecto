<?php
session_start();
require_once 'conexion.php';

$db = Database::connect();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    if (!empty($correo) && !empty($contrasena)) {
        $stmt = $db->prepare("SELECT * FROM negocios WHERE correo = ?");
        $stmt->execute([$correo]);
        $negocio = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($negocio && password_verify($contrasena, $negocio['contrasena'])) {
            $_SESSION['negocio_id'] = $negocio['id'];
            $_SESSION['negocio_nombre'] = $negocio['nombre'];
            exit;
        } else {
            $mensaje = '❌ Correo o contraseña incorrectos.';
        }
    } else {
        $mensaje = '⚠️ Por favor completa todos los campos.';
    }
}
?>



