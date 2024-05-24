async function obtenerDatos() {
    try {
        // Hacer la solicitud a la API PHP en localhost
        let response = await fetch('http://localhost/obtener_mesas.php');
        
        // Verificar si la respuesta es correcta
        if (!response.ok) {
            throw new Error('Error en la solicitud: ' + response.statusText);
        }

        // Convertir la respuesta a JSON
        let results = await response.json();

        // Seleccionar el contenedor donde se agregarán los elementos
        let contenedor = document.getElementById('Contenedor');

        // Procesar cada mesa
        results.forEach(mesa => {
            let div = document.createElement("div");
            let boton = document.createElement("button");
            let texto = document.createElement("p");

            div.setAttribute("id", "boton" + mesa.id);
            texto.textContent = "mesa " + mesa.nombre;

            boton.appendChild(texto);
            div.appendChild(boton);
            contenedor.appendChild(div);
        });
    } catch (error) {
        console.error('Hubo un problema con la solicitud fetch:', error);
    }
}

// Llamar a la función para obtener los datos
obtenerDatos();