<?php
session_start();
require 'conexion_empleado.php';

$cod_adm = $_POST['cod_adm'];

// Validate admin login
$validar_login = mysqli_query($conn, "SELECT * FROM admin1 WHERE codigo = '$cod_adm'");

if(mysqli_num_rows($validar_login) > 0){
    $_SESSION['Usuario'] = 'admin';  // Setting a static value for simplicity
    header("location: Pagina_Admin.php");
    exit();
}else{
    echo '
    <script>
        alert("Código de administrador incorrecto");
        window.location = "Index.php";
    </script>';
    exit();
}
?>
