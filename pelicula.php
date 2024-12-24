pelicula

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 3 Películas Favoritas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f9;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        .form-container {
            margin-bottom: 20px;
        }
        input {
            padding: 8px;
            margin: 10px;
            width: 200px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 15px;
            margin: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h1>Top 3 Películas Favoritas</h1>

    <div class="form-container">
        <input type="text" id="movie1" placeholder="Película 1">
        <input type="text" id="movie2" placeholder="Película 2">
        <input type="text" id="movie3" placeholder="Película 3">
    </div>

    <button id="saveButton">Guardar</button>
    <button id="exportButton">Exportar a CSV</button>

    <script>
        // Guardar películas en LocalStorage
        document.getElementById('saveButton').addEventListener('click', function() {
            const movie1 = document.getElementById('movie1').value;
            const movie2 = document.getElementById('movie2').value;
            const movie3 = document.getElementById('movie3').value;

            if (movie1 && movie2 && movie3) {
                const movies = [movie1, movie2, movie3];
                localStorage.setItem('topMovies', JSON.stringify(movies));
                alert('Películas guardadas con éxito.');
            } else {
                alert('Por favor, ingresa las tres películas.');
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
                alert('No hay películas guardadas. Por favor, guarda tus películas primero.');
            }
        });
    </script>

</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie1 = $_POST['movie1'] ?? '';
    $movie2 = $_POST['movie2'] ?? '';
    $movie3 = $_POST['movie3'] ?? '';

    if ($movie1 && $movie2 && $movie3) {
        $filename = 'top_3_peliculas.csv';
        $csvFile = fopen($filename, 'w');

        // Escribir las cabeceras
        fputcsv($csvFile, ['Película']);

        // Escribir las películas
        fputcsv($csvFile, [$movie1]);
        fputcsv($csvFile, [$movie2]);
        fputcsv($csvFile, [$movie3]);

        fclose($csvFile);

        // Descargar el archivo CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filename);

        // Eliminar el archivo temporal
        unlink($filename);
        exit;
    } else {
        echo 'No se recibieron todas las películas.';
    }
} else {
    echo '';
}
?>
