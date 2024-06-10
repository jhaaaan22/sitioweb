<?php
// Habilitar la visualización de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$servername = "localhost";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "formulario_db";

// Crear conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos enviados desde el formulario
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);

    // Validar que los campos no estén vacíos y que el email tenga un formato válido
    if (!empty($nombre) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Preparar y bindear la declaración
        $stmt = $conn->prepare("INSERT INTO contactos (nombre, email) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $email);

        if ($stmt->execute()) {
            echo "Gracias, $nombre. Hemos recibido tu mensaje.";
        } else {
            echo "Hubo un problema al guardar tu mensaje. Por favor, inténtalo de nuevo.";
        }

        $stmt->close();
    } else {
        echo "Por favor, ingresa un nombre y un email válidos.";
    }
} else {
    echo "Método de solicitud no permitido.";
}

$conn->close();
?>

