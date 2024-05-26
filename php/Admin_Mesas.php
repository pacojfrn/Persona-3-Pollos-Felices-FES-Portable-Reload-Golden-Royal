<?php
require 'conexion_empleado.php';

$alertMessage = "";

// Agregar Mesa
if (isset($_POST['add'])) {
    $noMesa = $_POST['noMesa'];

    $query = "INSERT INTO mesas (No_Mesas) VALUES ('$noMesa')";
    if ($conn->query($query) === TRUE) {
        $alertMessage = "Nueva mesa agregada exitosamente";
    } else {
        $alertMessage = "Error: " . $query . "<br>" . $conn->error;
    }
}

// Editar Mesa
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $noMesa = $_POST['noMesa'];

    $query = "UPDATE mesas SET No_Mesas='$noMesa' WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        $alertMessage = "Mesa actualizada exitosamente";
    } else {
        $alertMessage = "Error: " . $query . "<br>" . $conn->error;
    }
}

// Eliminar Mesa
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM mesas WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        $alertMessage = "Mesa eliminada exitosamente";
    } else {
        $alertMessage = "Error: " . $query . "<br>" . $conn->error;
    }
}

// Obtener Mesas
$query = "SELECT * FROM mesas";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Mesas</title>
    <link rel="stylesheet" href="../css/styles_Mesas.css">
    <script>
        // Mostrar alerta si hay un mensaje
        function showAlert(message) {
            if (message) {
                alert(message);
            }
        }

        // Agregar animaciones al cargar
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('h1').style.animation = 'slideIn 1s forwards';
            document.querySelector('h2').style.animation = 'slideIn 1.5s forwards';
            document.querySelectorAll('table, form').forEach(function(el) {
                el.style.animation = 'fadeIn 2s forwards';
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Administrar Mesas</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>No. Mesa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="text" name="noMesa" value="<?php echo $row['No_Mesas']; ?>">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    </td>
                    <td>
                            <input type="submit" name="edit" value="Guardar">
                        </form>
                        <a class="delete-btn" href="admin_mesas.php?delete=<?php echo $row['id']; ?>">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h2>Agregar Mesa</h2>
        <form method="POST" action="">
            <label for="noMesa">No. Mesa:</label>
            <input type="number" id="noMesa" name="noMesa" required>
            <input type="submit" name="add" value="Agregar">
        </form>
        <BR></BR><BR></BR>
        <div class="back-button">
            <a href="Pagina_Admin.php">
                <button>Regresar</button>
            </a>
        </div>
    </div>
    <script>
        showAlert('<?php echo $alertMessage; ?>');
    </script>
</body>
</html>
