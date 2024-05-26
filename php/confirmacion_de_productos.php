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
            position: relative;
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
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            position: absolute;
            bottom: 15px;
            right: 15px;
        }
        .producto button:hover {
            background-color: #e55d00;
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
        .Chead {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 98vw;
        }
        .Chead button, h2, h4 {
            align-items: center;
        }
        .Chead button {
            background-color: #ffe240;
            border-radius: 3px; 
            margin: 10px;
            padding: 15px;
        }
        .Chead a {
            text-decoration: none;
        }
    </style>
</head>
<body>
<header>
    <div class="Chead">
        <button>
            <a href="procesar_seleccion.php">Regresar</a>
        </button>
        <h2>Confirmacion de productos</h2>
        <h4>Mesa: <?php echo htmlspecialchars($mesaSeleccionada); ?></h4>
    </div>
</header>
<div class="contenedor" id="ticket">
    <?php
    $total = 0;
    if (isset($_POST['cart'])) {
        $cart = json_decode($_POST['cart'], true);
        foreach ($cart as $name => $item) {
            $total += $item['price'] * $item['quantity'];
            echo '<div class="producto" data-name="' . htmlspecialchars($name) . '">';
            echo '<h2>' . htmlspecialchars($name) . '</h2>';
            echo '<p>Precio: $' . htmlspecialchars($item['price']) . '</p>';
            echo '<p>Cantidad: ' . htmlspecialchars($item['quantity']) . '</p>';
            echo '<img src="data:image/jpeg;base64,' . htmlspecialchars($item['photo']) . '" alt="' . htmlspecialchars($name) . '">';
            echo '<button onclick="removeFromCart(\'' . htmlspecialchars($name) . '\')">Eliminar</button>';
            echo '</div>';
        }
    } else {
        echo '<p>No hay productos en el carrito.</p>';
    }
    ?>
    <div class="metodo-pago">
        <h2>Total: $<?php echo htmlspecialchars($total); ?></h2>
        <button onclick="generatePDF('Pago con tarjeta de crédito')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
            </svg>
        </button>
        <button onclick="generatePDF('Pago en efectivo')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
                <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2z"/>
            </svg>
        </button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.0.0/html2canvas.min.js"></script>
<script>
    let cart = <?php echo isset($cart) ? json_encode($cart) : '[]'; ?>;

    function removeFromCart(name) {
        if (cart[name]) {
            if (cart[name].quantity > 1) {
                cart[name].quantity--;
            } else {
                delete cart[name];
            }
            updatePage();
        }
    }

    function updatePage() {
        const container = document.getElementById('ticket');
        container.innerHTML = '';

        let total = 0;
        for (const [name, item] of Object.entries(cart)) {
            total += item.price * item.quantity;
            const productDiv = document.createElement('div');
            productDiv.classList.add('producto');
            productDiv.setAttribute('data-name', name);

            productDiv.innerHTML = `
                <h2>${name}</h2>
                <p>Precio: $${item.price}</p>
                <p>Cantidad: ${item.quantity}</p>
                <img src="data:image/jpeg;base64,${item.photo}" alt="${name}">
                <button onclick="removeFromCart('${name}')">Eliminar</button>
            `;

            container.appendChild(productDiv);
        }

        const totalDiv = document.createElement('div');
        totalDiv.classList.add('metodo-pago');
        totalDiv.innerHTML = `<h2>Total: $${total.toFixed(2)}</h2>`;
        totalDiv.innerHTML += `
            <button onclick="generatePDF('Pago con tarjeta de crédito')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
                    <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
                </svg>
            </button>
            <button onclick="generatePDF('Pago en efectivo')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
                    <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                    <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2z"/>
                </svg>
            </button>
        `;

        container.appendChild(totalDiv);
    }

    function generatePDF(paymentMethod) {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.text(`Ticket de Pago - ${paymentMethod}`, 10, 10);
        doc.text(`Mesa: ${<?php echo json_encode($mesaSeleccionada); ?>}`, 10, 20);

        let y = 30;
        for (const [name, item] of Object.entries(cart)) {
            doc.text(`Plato: ${name}`, 10, y);
            doc.text(`Precio: $${item.price}`, 10, y + 10);
            doc.text(`Cantidad: ${item.quantity}`, 10, y + 20);
            y += 30;
        }

        doc.text(`Total: $${<?php echo json_encode($total); ?>}`, 10, y);
        doc.save('ticket.pdf');
    }
</script>
</body>
</html>
