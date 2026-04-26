<?php
$servername = "localhost";
$username = "u571279726_root"; // Usuario de XAMPP
$password = "ojK/QTP1^"; // Contraseña (por defecto vacía)
$dbname = "u571279726_participantes"; // Nombre de la base de datos

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
        $estado = $data['estado'] === 'activo' ? 'Estado: Verificado' : 'Estado: No Verificado';
        $color = $data['estado'] === 'activo' ? 'green' : 'red';
        $curso = htmlspecialchars($data['curso']); // Sanitiza el curso para evitar problemas de seguridad //22/03
        $fecha = date("d-m-Y", strtotime($data['fecha_inscripcion'])); // Formatea la fecha a DD-MM-YYYY //22/03
        
        echo "<div class='resultado-box'>
               <p style='color: $color;'><strong>$estado</strong></p>
               <p><strong>Curso:</strong> $curso</p>
               <p><strong>Fecha de inscripción:</strong> $fecha</p>
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
