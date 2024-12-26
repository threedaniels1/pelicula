<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 3 Películas Favoritas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: #000;
            cursor: url('varita/Varita.png'), auto;
            position: relative;
        }

        /* Estilos para el video de fondo */
        #background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Estilos para el contenedor del formulario con efecto de castillo */
        .form-container {
            background-image: url('castle-background.jpg');
            background-size: cover;
            background-position: center;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            text-align: center;
            z-index: 1;
            border: 4px solid #fff;
        }

        h1 {
            color: #fff;
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
        }

        input {
            padding: 12px;
            margin: 10px;
            width: 100%;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1.2rem;
            transition: border-color 0.3s ease;
            background-color: rgba(255, 255, 255, 0.8);
        }

        input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            padding: 12px 20px;
            font-size: 1.2rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .alert {
            margin-top: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 6px;
            display: none;
        }

        .alert.error {
            background-color: #f44336;
        }

        /* Hacer el diseño responsive */
        @media (max-width: 600px) {
            h1 {
                font-size: 2rem;
            }

            input, button {
                font-size: 1rem;
            }
        }

        /* Estilos para las partículas de nieve */
        .snowflake {
            position: absolute;
            top: -10px;
            color: #fff;
            font-size: 1.5rem;
            opacity: 0.8;
            user-select: none;
            pointer-events: none;
            z-index: 9999;
            animation: fall linear infinite;
        }

        @keyframes fall {
            0% {
                transform: translateY(0) rotate(0deg);
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
            }
        }
    </style>
</head>
<body>

<video id="background-video" autoplay loop muted>
    <source src="videos/harry.mp4" type="video/mp4"> <!-- Añadido soporte para MP4 -->
    Tu navegador no soporta este video.
</video>

<div class="form-container">
    <h1>Top 3 Películas Favoritas</h1>

    <input type="text" id="movie1" placeholder="Película 1">
    <input type="text" id="movie2" placeholder="Película 2">
    <input type="text" id="movie3" placeholder="Película 3">

    <button id="saveButton">Guardar</button>
    <button id="exportButton">Exportar a CSV</button>

    <div class="alert" id="alertMessage"></div>
</div>

<script>
    // Mostrar mensaje de alerta
    function showAlert(message, type = 'success') {
        const alertBox = document.getElementById('alertMessage');
        alertBox.textContent = message;
        alertBox.className = `alert ${type}`;
        alertBox.style.display = 'block';

        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 3000);
    }

    // Guardar películas en LocalStorage
    document.getElementById('saveButton').addEventListener('click', function() {
        const movie1 = document.getElementById('movie1').value;
        const movie2 = document.getElementById('movie2').value;
        const movie3 = document.getElementById('movie3').value;

        if (movie1 && movie2 && movie3) {
            const movies = [movie1, movie2, movie3];
            localStorage.setItem('topMovies', JSON.stringify(movies));
            showAlert('Películas guardadas con éxito.');
        } else {
            showAlert('Por favor, ingresa las tres películas.', 'error');
        }
    });

    // Exportar películas a CSV
    document.getElementById('exportButton').addEventListener('click', function() {
        const movies = JSON.parse(localStorage.getItem('topMovies'));

        if (movies && movies.length === 3) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'export.php';

            const input1 = document.createElement('input');
            input1.type = 'hidden';
            input1.name = 'movie1';
            input1.value = movies[0];

            const input2 = document.createElement('input');
            input2.type = 'hidden';
            input2.name = 'movie2';
            input2.value = movies[1];

            const input3 = document.createElement('input');
            input3.type = 'hidden';
            input3.name = 'movie3';
            input3.value = movies[2];

            form.appendChild(input1);
            form.appendChild(input2);
            form.appendChild(input3);

            document.body.appendChild(form);
            form.submit();
        } else {
            showAlert('No hay películas guardadas. Por favor, guarda tus películas primero.', 'error');
        }
    });

    // Función para generar las partículas de nieve
    function createSnowflakes() {
        const snowflakeCount = 100;

        for (let i = 0; i < snowflakeCount; i++) {
            let snowflake = document.createElement('div');
            snowflake.classList.add('snowflake');
            snowflake.textContent = '❄'; // Cambia el símbolo de nieve si es necesario
            snowflake.style.left = `${Math.random() * 100}%`;
            snowflake.style.animationDuration = `${Math.random() * 5 + 5}s`;
            snowflake.style.animationDelay = `${Math.random() * 5}s`;

            document.body.appendChild(snowflake);
        }
    }

    createSnowflakes(); // Llamar la función para crear la nieve al cargar la página
</script>

</body>
</html>
