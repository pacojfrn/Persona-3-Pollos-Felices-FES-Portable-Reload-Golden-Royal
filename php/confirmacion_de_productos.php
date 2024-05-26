<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #ff6600;
            color: white;
            padding: 10px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .contenedor {
            padding: 20px;
        }
        .producto {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 15px;
            text-align: center;
            width: 220px;
            display: inline-block;
        }
        .producto img {
            max-width: 100%;
            border-radius: 10px;
        }
        .producto h2 {
            color: #ff6600;
            font-size: 20px;
            margin: 10px 0;
        }
        .producto p {
            font-size: 18px;
            margin: 5px 0;
            color: #333;
        }
        .metodo-pago {
            text-align: center;
            margin: 20px 0;
        }
        .metodo-pago button {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .metodo-pago button:hover {
            background-color: #e55d00;
        }
    </style>
</head>
<body>
    <header>Confirmación de Productos</header>
    <div class="contenedor">
        <?php
        if (isset($_POST['cart'])) {
            $cart = json_decode($_POST['cart'], true);
            foreach ($cart as $name => $item) {
                echo '<div class="producto">';
                echo '<h2>' . $name . '</h2>';
                echo '<p>Precio: $' . $item['price'] . '</p>';
                echo '<p>Cantidad: ' . $item['quantity'] . '</p>';
                echo '<img src="data:image/jpeg;base64,' . $item['photo'] . '" alt="' . $name . '">';
                echo '</div>';
            }
        } else {
            echo '<p>No hay productos en el carrito.</p>';
        }
        ?>
        <div class="metodo-pago">
            <h2>Método de pago:</h2>
            <button onclick="alert('Pago con tarjeta de crédito')">Tarjeta de crédito</button>
            <button onclick="alert('Pago en efectivo')">Efectivo</button>
        </div>
    </div>
</body>
</html>
