<?php

// Verifica si se ha enviado un archivo
if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    // Obtiene el nombre del archivo y la ruta temporal
    $nombreArchivo = $_FILES['archivo']['name'];
    $rutaTemporal = $_FILES['archivo']['tmp_name'];

    // Directorio donde se almacenará el archivo
    $directorioDestino = 'cotizaciones/';

    // Verifica si el directorio de destino existe, si no, lo crea
    if (!file_exists($directorioDestino)) {
        mkdir($directorioDestino, 0777, true);
    }

    // Genera la ruta completa de destino
    $rutaDestino = $directorioDestino . $nombreArchivo;

    // Mueve el archivo de la ruta temporal al directorio de destino
    if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
        echo "El archivo se ha subido correctamente a la ruta: $rutaDestino";
    } else {
        echo "Error al mover el archivo al directorio de destino.";
    }
} else {
    echo "Error al subir el archivo.";
}
?>
