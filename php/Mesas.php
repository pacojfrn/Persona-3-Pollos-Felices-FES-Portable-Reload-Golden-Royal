<?php 
session_start();
require 'conexion_empleado.php';

if (isset($_SESSION['Usuario'])) {
    echo '
    <script>
        alert("Por favor, inicia sesión");
        window.location = "index.php";
    </script>';
    session_destroy();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type = "text/css" href="../css/styles_Mesas.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Mesas</title>
</head>
<body>
    <header>
        <div class="perfil-container">
            <a href="Cerrar_sesion.php">Cerrar sesión</a>
        </div>
    </header>
    <div class="side-menu">
        <button>Siguente</button>
    </div>
    <div class="Contenedor">
        <h1>Seleccione la mesa:</h1>
        <div class="Mesas">
            
        </div>
    </div>
    <footer>
        <div class="info">
            <p>Para mas informacion contactar:</p>
            <a href="mailto:pacoeco23@hotmail.com"><i class="bi bi-envelope"></i></a><br>
        </div>
    </footer>
</body>
</html>
