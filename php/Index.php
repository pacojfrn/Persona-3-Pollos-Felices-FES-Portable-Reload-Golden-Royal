<?php
    session_start();
    if(isset($_SESSION['usuario'])){
        header("location: php/Principal.php");
        exit();
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles_index.css">
    <title>Login/Registro</title>
</head>
<body>
    <!--Div para mentener todo-->
     <div class="contenedor_all">
        <!--Div para las cajitas con información que aparecen atrás -->
        <div class="caja_back">
            <div class="caja_login">
                <h3>Login de empleado</h3>
                <p></p>
                <button id = "ini_ses">Iniciar sesión</button>
            </div>
            <div class="caja_regis">
                <h3>Login de administrador</h3>
                <p></p>
                <button id = "regi_usu">Iniciar sesión</button>
            </div>
        </div>
        <!--Div para las cajas de enfrente que van a interactuar con el usuario-->
        <div class="contenedor_login_register">
            <form action="Login.php" method = "POST" class="form_login">
                <h2>Ingrese código de empleado</h2>
                 <input type="text" placeholder="Código de empleado" REQUIRED name = "codigo">
                 <button>Entrar</button>
            </form>

            <form action="Admin_Login.php" method = "POST" class="form_regis" enctype = "multipart/form-data">
                <h2>Ingrese código de administrador</h2>
                <input type="password" placeholder="Código de administrador" REQUIRED name="cod_adm">
                <button>Entrar</button>
            </form>

        </div>
     </div>
     <script src="../js/script.js"></script>
</body>
</html>