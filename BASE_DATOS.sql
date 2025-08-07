CREATE DATABASE comida_casera;
USE comida_casera;

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    precio INT,
    imagen VARCHAR(255)
);

CREATE TABLE resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT,
    usuario VARCHAR(100),
    comentario TEXT,
    calificacion INT,
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);