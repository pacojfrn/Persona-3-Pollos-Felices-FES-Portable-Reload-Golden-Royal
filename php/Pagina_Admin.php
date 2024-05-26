<?php 
session_start();
include 'conexion_empleado.php';

if (!isset($_SESSION['Usuario'])) {
    echo '
    <script>
        alert("Por favor, inicia sesión");
        window.location = "Index.php";
    </script>';
    session_destroy();
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="../css/styles_Pagina_Admin.css">
</head>
<body>
    <div class="container">
        <h1>Panel de Administración</h1>
        <div class="admin-options">
            <a href="Admin_EMP.php" class="admin-option">Administrar Meseros</a>
            <a href="Admin_PDT.php" class="admin-option">Administrar Productos</a>
            <a href="Admin_Mesas.php" class="admin-option">Administrar Mesas</a>
            <a href="Cerrar_sesion.php" class="admin-option logout">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>
