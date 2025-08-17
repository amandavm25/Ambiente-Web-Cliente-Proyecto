<?php
require_once 'conexion.php';

class Producto {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function crear($nombre, $precio, $imagen) {
        $stmt = $this->conn->prepare("INSERT INTO productos (nombre, precio, imagen) VALUES (?, ?, ?)");
        return $stmt-execute([$nombre, $precio, $imagen]);
    }

    public function obtenerTodos() {
        $stmt = $this->conn->query("SELECT * FROM productos ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM productos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}