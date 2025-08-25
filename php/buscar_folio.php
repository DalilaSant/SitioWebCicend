<?php
$servername = "localhost";
$username = "root"; // Usuario de XAMPP
$password = ""; // Contraseña (por defecto vacía)
$dbname = "cursos_db"; // Nombre de la base de datos

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos enviados desde el formulario
$nombre_completo = $_POST['nombre_completo'] ?? '';
$folio = $_POST['folio'] ?? '';

// Validar que los campos no estén vacíos
if (!empty($nombre_completo) && !empty($folio)) {
    // Consulta a la base de datos
    $sql = "SELECT * FROM participantes WHERE nombre = ? AND folio = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nombre_completo, $folio);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $estado = $data['estado'] === 'activo' ? 'Estado: Activo' : 'Estado: Inactivo';
        $color = $data['estado'] === 'activo' ? 'green' : 'red';

        echo "<div class='resultado-box'>
                <p style='color: $color;'>$estado</p>
              </div>";
    } else {
        echo "<div class='resultado-box'>
                <p style='color: red;'>No se encontraron resultados para los datos proporcionados.</p>
              </div>";
    }
} else {
    echo "<div class='resultado-box'>
            <p style='color: red;'>Por favor, completa todos los campos.</p>
          </div>";
}




// Cerrar la conexión
$conn->close();
?>
