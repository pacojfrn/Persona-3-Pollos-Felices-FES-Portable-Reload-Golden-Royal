<?php 
session_start();
include 'conexion_empleado.php';

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
    <style>
        .titulo{
            display: flex;
            justify-content: center;
        }

        .Mesas button {
            border-radius: 100%;
            padding: 20px;
            margin: 2vw;
            width: 5vw;
            height:auto;
        }
        .Mesas button.selected {
            background-color: #007bff; /* Cambia el color de fondo al seleccionado */
            color: white; /* Cambia el color del texto al seleccionado */
            border: 2px solid #007bff; /* Agrega un borde sólido alrededor del botón seleccionado */
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let selectedButton = null;
            
            document.querySelectorAll(".Mesas button").forEach(button => {
                button.addEventListener("click", function() {
                    if (selectedButton) {
                        selectedButton.classList.remove("selected");
                    }
                    this.classList.add("selected");
                    selectedButton = this;
                    document.getElementById("selectedTable").value = this.getAttribute("data-mesa");
                });
            });

            document.getElementById("nextButton").addEventListener("click", function() {
                if (selectedButton) {
                    const selectedTableNumber = selectedTable.getAttribute('data-mesa');
                    alert('Mesa seleccionada: ' + selectedTableNumber);
                    // Aquí puedes enviar el número de mesa seleccionado al servidor o a la siguiente página.
                    // Por ejemplo, mediante un formulario oculto:
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'procesar_mesa.php';  // Cambia esto al nombre de tu archivo PHP de procesamiento
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'mesaSeleccionada';
                    input.value = selectedTableNumber;
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                } else {
                    alert("Por favor, seleccione una mesa.");
                }
            });
        });
    </script>
</head>
<body>
    <header>
        <div class="perfil-container">
            <a href="Cerrar_sesion.php">Cerrar sesión</a>
        </div>
    </header>
    <form id="mesaForm" action="procesar_seleccion.php" method="post">
        <input type="hidden" id="selectedTable" name="selectedTable" value="">
        <div class="side-menu">
            <button type="button" id="nextButton">Siguiente</button>
        </div>
        <div class="Contenedor">
            <div class="titulo">
                <h1>Seleccione la mesa:</h1>
            </div>
            <div class="Mesas">
                <?php if ($mesas): ?>
                    <?php foreach ($mesas as $mesa): ?>
                        <button type="button" data-mesa="<?php echo $mesa['No_Mesas']; ?>">
                            mesa <?php echo $mesa['No_Mesas']; ?>
                        </button>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No se encontraron mesas.</p>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <footer>
        <div class="info">
            <p>Para más información contactar:</p>
            <a href="mailto:pacoeco23@hotmail.com"><i class="bi bi-envelope"></i></a><br>
        </div>
    </footer>
</body>
</html>