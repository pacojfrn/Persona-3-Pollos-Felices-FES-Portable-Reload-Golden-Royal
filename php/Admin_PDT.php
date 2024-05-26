<?php
require 'conexion_empleado.php';

$alertMessage = "";

// Agregar Producto
if (isset($_POST['add'])) {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $precio = $_POST['precio'];
    $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));

    // Verificar si el código ya existe
    $query = "SELECT * FROM platos WHERE codigo = '$codigo'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        // Si el código ya existe, mostrar una alerta
        $alertMessage = "El código ya existe. Por favor, use un código diferente.";
    } else {
        // Si el código no existe, proceder con la inserción
        $query = "INSERT INTO platos (nombre, codigo, foto, precio) VALUES ('$nombre', '$codigo', '$foto', '$precio')";
        if ($conn->query($query) === TRUE) {
            $alertMessage = "Nuevo producto agregado exitosamente";
        } else {
            $alertMessage = "Error: " . $query . "<br>" . $conn->error;
        }
    }
}

// Editar Producto
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $precio = $_POST['precio'];
    $foto_query = "";

    if (!empty($_FILES['foto']['tmp_name'])) {
        $foto = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
        $foto_query = ", foto='$foto'";
    }

    $query = "UPDATE platos SET nombre='$nombre', codigo='$codigo', precio='$precio' $foto_query WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        $alertMessage = "Producto actualizado exitosamente";
    } else {
        $alertMessage = "Error: " . $query . "<br>" . $conn->error;
    }
}

// Eliminar Producto
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM platos WHERE id=$id";
    if ($conn->query($query) === TRUE) {
        $alertMessage = "Producto eliminado exitosamente";
    } else {
        $alertMessage = "Error: " . $query . "<br>" . $conn->error;
    }
}

// Obtener Productos
$query = "SELECT * FROM platos";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos</title>
    <link rel="stylesheet" href="../css/styles_PDT.css">
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
        <h1>Administrar Productos</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Código</th>
                    <th>Foto</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <td><?php echo $row['id']; ?></td>
                        <td><input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"></td>
                        <td><input type="text" name="codigo" value="<?php echo $row['codigo']; ?>"></td>
                        <td>
                            <input type="file" name="foto">
                            <?php if (!empty($row['foto'])): ?>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['foto']); ?>" alt="<?php echo $row['nombre']; ?>" width="50" height="50">
                            <?php endif; ?>
                        </td>
                        <td><input type="number" name="precio" step="0.01" value="<?php echo $row['precio']; ?>"></td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="edit" value="Guardar">
                            <BR></BR>
                            <a href="Admin_PDT.php?delete=<?php echo $row['id']; ?>" class="delete">Eliminar</a>
                        </td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <h2>Agregar Producto</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" required>
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" required>
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>
            <input type="submit" name="add" value="Agregar">
        </form>
        <br><br><br>
        <a href="Pagina_Admin.php" class="back-button">
            <button>Regresar</button>
        </a>
    </div>
</body>
</html>
