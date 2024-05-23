<?php
require 'conexion_empleado.php';
// Agregar Mesero
if (isset($_POST['add'])) {
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $query = "INSERT INTO empleado (nombre, codigo) VALUES ('$nombre', '$codigo')";
    $conn->query($query);
}

// Editar Mesero
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $codigo = $_POST['codigo'];
    $query = "UPDATE empleado SET nombre='$nombre', codigo='$codigo' WHERE id=$id";
    $conn->query($query);
}

// Eliminar Mesero
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM empleado WHERE id=$id";
    $conn->query($query);
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
    <link rel="stylesheet" href="css/styles_EMP_PDT.css">
</head>
<body>
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
                        <a href="Admin_EMP.php?delete=<?php echo $row['id']; ?>">Eliminar</a>
                    </td>
                </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br><br><br>
    <h2>Agregar Mesero</h2>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required>
        <input type="submit" name="add" value="Agregar">
    </form>
<br><br><br>
    <a href="Pagina_Admin.php">
        <button>Regresar</button>
    </a>
</body>
</html>
