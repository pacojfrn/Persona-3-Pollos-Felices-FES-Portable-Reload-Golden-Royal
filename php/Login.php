<?php
    session_start();

    require 'conexion_empleado.php';
    $cod = $_POST['codigo'];

    $validar_login = mysqli_query($conn, "SELECT * FROM empleado WHERE codigo = '$cod'");

    if(mysqli_num_rows($validar_login) > 0){
        $_SESSION['Usuario'] = $nombre;
        header("location:Mesas.php");
        exit();
    }else{
        echo '
        <script>
            alert("Código de empleado incorrecto o no existe");
            window.location = "Index.php";
        </script>';
        exit();
    }

?>