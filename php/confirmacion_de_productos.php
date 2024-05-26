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
    <div class="contenedor" id="ticket">
        <?php
        $total = 0;
        if (isset($_POST['cart'])) {
            $cart = json_decode($_POST['cart'], true);
            foreach ($cart as $name => $item) {
                $total += $item['price'] * $item['quantity'];
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
            <h2>Total: $<?php echo $total; ?></h2>
            <button onclick="generatePDF('Pago con tarjeta de crédito')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1z"/>
  <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
</svg></button>
            <button onclick="generatePDF('Pago en efectivo')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash" viewBox="0 0 16 16">
  <path d="M8 10a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
  <path d="M0 4a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V6a2 2 0 0 1-2-2z"/>
</svg></button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script>
        function generatePDF(paymentMethod) {
            const { jsPDF } = window.jspdf;
            const content = document.getElementById('ticket');
            
            html2canvas(content).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF();
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('ticket.pdf');
                
                alert(paymentMethod);
            });
        }
    </script>
</body>
</html>
