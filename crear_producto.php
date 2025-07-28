<?php
require_once 'Producto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? '';
    $imagen = $_POST['imagen'] ?? '';

    if ($nombre && $precio && $imagen) {
        $producto = new Producto();
        if ($producto->crear($nombre, $precio, $imagen)) {
            echo json_encode(['success' => true, 'message' => 'Producto creado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear el producto']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}