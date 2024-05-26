<?php
session_start();

include 'conexion_empleado.php';
$cod = $_POST['codigo'];

// Consulta segura para evitar inyecciones SQL
$stmt = $conn->prepare("SELECT * FROM empleado WHERE codigo = ?");
$stmt->bind_param("s", $cod);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Asignar variables de sesión adecuadas
    $_SESSION['Usuario'] = $row['nombre']; // o cualquier campo que quieras usar
    header("Location: Mesas.php");
    exit();
} else {
    echo '
    <script>
        alert("Código de empleado incorrecto o no existe");
        window.location = "Index.php";
    </script>';
    exit();
}
?>