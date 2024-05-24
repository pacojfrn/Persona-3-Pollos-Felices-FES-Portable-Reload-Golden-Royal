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

// Consulta a la base de datos para obtener las mesas
$mesas = [];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, No_Mesas FROM mesas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mesas[] = $row;
    }
} else {
    $mesas = null;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/styles_Mesas.css">
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
        <button>Siguiente</button>
    </div>
    <div class="Contenedor">
        <div class="titulo">
        <h1>Seleccione la mesa:</h1>
        </div>
        <div class="Mesas">
            <?php if ($mesas): ?>
                <?php foreach ($mesas as $mesa): ?>
                    <div id="boton<?php echo $mesa['id']; ?>">
                        <button>
                            <p>mesa <?php echo $mesa['No_Mesas']; ?></p>
                        </button>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron mesas.</p>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <div class="info">
            <p>Para más información contactar:</p>
            <a href="mailto:pacoeco23@hotmail.com"><i class="bi bi-envelope"></i></a><br>
        </div>
    </footer>
    <script src="../js/scriptM.js"></script>
</body>
</html>