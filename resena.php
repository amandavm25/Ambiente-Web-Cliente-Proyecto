<?php
require_once 'conexion.php';

class Resena {
    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function crear($producto_id, $usuario, $comentario, $calificacion) {
        $stmt = $this->conn->prepare("INSERT INTO resenas (producto_id, usuario, comentario, calificacion) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$producto_id, $usuario, $comentario, $calificacion]);
    }

    public function obtenerPorProducto($producto_id) {
        $stmt = $this->conn->prepare("SELECT * FROM resenas WHERE producto_id = ?");
        $stmt->execute([$producto_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM resenas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}