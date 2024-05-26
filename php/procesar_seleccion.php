<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pollos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los platos
$sql = "SELECT nombre, precio, foto FROM platos";
$result = $conn->query($sql);

// Recibir el número de mesa seleccionado
$mesaSeleccionada = isset($_POST['selectedTable']) ? $_POST['selectedTable'] : 'No seleccionada';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Platos POS</title>
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
        .platos {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            width: 75vw;
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
            transition: transform 0.2s;
        }
        .producto:hover {
            transform: scale(1.05);
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
        .producto button {
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .producto button:hover {
            background-color: #e55d00;
        }
        #cartMenu {
            position: fixed;
            right: 0;
            top: 0;
            width: 300px;
            height: 100%;
            background-color: white;
            border-left: 1px solid #ddd;
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            overflow-y: auto;
        }
        #cartMenu h2 {
            color: #ff6600;
            font-size: 22px;
            margin-bottom: 20px;
        }
        .cart-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .cart-item span {
            font-size: 18px;
        }
        #checkoutButton {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #ff6600;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
        }
        #checkoutButton:hover {
            background-color: #e55d00;
        }
        .Chead{
            display:flex;
            justify-content:space-between;
            align-items:center;
            width: 75vw;
        }
        .Chead button, h2, h4{
            align-items:center;
        }
        .Chead button{
            background-color: #ffe240;
            border-radius: 3px; 
            margin:10px;
            padding: 15px;
        }
        .Chead a{
            text-decoration: none;
        }
    </style>
    <script>
        let cart = {};

        function addToCart(name, price, photo) {
            if (!cart[name]) {
                cart[name] = { quantity: 0, price: price, photo: photo };
            }
            cart[name].quantity++;
            updateCartMenu();
        }

        function updateCartMenu() {
            const cartMenu = document.getElementById('cartMenuItems');
            cartMenu.innerHTML = '';
            let total = 0;
            for (const [name, item] of Object.entries(cart)) {
                const itemTotal = item.quantity * item.price;
                total += itemTotal;
                cartMenu.innerHTML += `<div class="cart-item"><span>${name} (x${item.quantity})</span><span>$${itemTotal.toFixed(2)}</span></div>`;
            }
            cartMenu.innerHTML += `<div class="cart-item"><strong>Total</strong><strong>$${total.toFixed(2)}</strong></div>`;
        }

        function goToConfirmationPage() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'confirmacion_de_productos.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'cart';
            input.value = JSON.stringify(cart);
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>
<body>
    <header>
        <div class="Chead">
            <button>
                <a href="Mesas.php">Regresar</a>
            </button>
            <h2>Platos disponibles</h2>
            <h4>Mesa: <?php echo htmlspecialchars($mesaSeleccionada); ?></h4>
        </div>
    </header>
    <div class="platos">
        <?php
        if ($result->num_rows > 0) {
            // Salida de datos de cada fila
            while($row = $result->fetch_assoc()) {
                echo '<div class="producto">';
                echo '<h2>' . htmlspecialchars($row["nombre"]) . '</h2>';
                echo '<p>Precio: $' . htmlspecialchars($row["precio"]) . '</p>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($row["foto"]) . '" alt="' . htmlspecialchars($row["nombre"]) . '">';
                echo '<button onclick="addToCart(\'' . htmlspecialchars($row["nombre"]) . '\', ' . htmlspecialchars($row["precio"]) . ', \'' . base64_encode($row["foto"]) . '\')">Agregar al carrito</button>';
                echo '</div>';
            }
        } else {
            echo "No hay platos disponibles";
        }
        $conn->close();
        ?>
    </div>
    <div id="cartMenu">
        <h2>Carrito de Compras</h2>
        <div id="cartMenuItems"></div>
    </div>
    <button id="checkoutButton" onclick="goToConfirmationPage()">Confirmar Productos</button>
</body>
</html>