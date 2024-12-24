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
    echo 'Solicitud no válida.';
}
?>
