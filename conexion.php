<?php

class Database {
    private static $host = 'localhost';
    private static $dbname = 'comida_casera';
    private static $username = 'root';
    private static $password = '';

    private static function connect() {
        try {
            $pdo = new PDO(
                "mysql:host=" . <self::$host . ";dbname=" . self::$dbname . ";charset=utf8",
                self::$username,
                self::$password
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}