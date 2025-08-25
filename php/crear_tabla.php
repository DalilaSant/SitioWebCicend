<?php
$servername = "localhost";
$username = "root"; // Usuario por defecto en XAMPP
$password = ""; // Contraseña por defecto (vacía)
$dbname = "cursos_db"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear la base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos '$dbname' creada exitosamente (si no existía)";
} else {
    echo "Error al crear base de datos: " . $conn->error;
}

// Seleccionar la base de datos
$conn->select_db($dbname);

// SQL para crear la tabla 'participantes'
$sql = "CREATE TABLE IF NOT EXISTS participantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    folio VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    curso VARCHAR(100) NOT NULL,
    estado ENUM('activo', 'finalizado') NOT NULL,
    fecha_inscripcion DATE NOT NULL
)";

// Ejecutar la consulta para crear la tabla
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'participantes' creada exitosamente";
} else {
    echo "Error al crear tabla: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
