<?php
require 'conexion_empleado.php';

// Variable para almacenar el mensaje de alerta
$alertMessage = "";

// Agregar Mesero
if (isset($_POST['add'])) {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    
    // Verificar si el código ya existe
    $query = "SELECT * FROM empleado WHERE codigo = '$codigo'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        // Si el código ya existe, mostrar una alerta
        $alertMessage = "El código ya existe. Por favor, use un código diferente.";
    } else {
        // Si el código no existe, proceder con la inserción
        $query = "INSERT INTO empleado (nombre, codigo) VALUES ('$nombre', '$codigo')";
        if ($conn->query($query) === TRUE) {
            $alertMessage = "Nuevo mesero agregado exitosamente.";
        } else {
            $alertMessage = "Error: " . $query . "<br>" . $conn->error;
        }
    }
}

// Editar Mesero
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $query = "UPDATE empleado SET nombre='$nombre', codigo='$codigo' WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        $alertMessage = "Mesero actualizado exitosamente.";
    } else {
        $alertMessage = "Error: " . $query . "<br>" . $conn->error;
    }
}

// Eliminar Mesero
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM empleado WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        $alertMessage = "Mesero eliminado exitosamente.";
    } else {
        $alertMessage = "Error: " . $query . "<br>" . $conn->error;
    }
}

// Obtener Meseros
$query = "SELECT * FROM empleado";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Meseros</title>
    <link rel="stylesheet" href="../css/styles_EMP.css">
    <script>
        // Mostrar alerta si hay un mensaje
        function showAlert(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body onload="showAlert('<?php echo $alertMessage; ?>')">
    <div class="container">
        <h1>Administrar Meseros</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <form method="POST" action="">
                        <td><?php echo $row['id']; ?></td>
                        <td><input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"></td>
                        <td><input type="text" name="codigo" value="<?php echo $row['codigo']; ?>"></td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="edit" value="Guardar">
                            <a href="Admin_EMP.php?delete=<?php echo $row['id']; ?>" class="delete">Eliminar</a>
                        </td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h2>Agregar Mesero</h2>
        <form method="POST" action="">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" required>
            <input type="submit" name="add" value="Agregar" class="agregar">
        </form>
        <br><br><br>
        <a href="Pagina_Admin.php" class="back-button">
            <button>Regresar</button>
        </a>
    </div>
</body>
</html>
