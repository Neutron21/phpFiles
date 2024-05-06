<?php
// Verifica si se ha enviado un archivo
if ($_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    // Obtiene el nombre del archivo
    $nombreArchivo = $_FILES['archivo']['name'];

    // Directorio donde se almacenará el archivo
    $directorioDestino = 'cotizaciones/';

    // Verifica si el directorio de destino existe, si no, lo crea
    if (!file_exists($directorioDestino)) {
        mkdir($directorioDestino, 0777, true);
    }

    // Genera la ruta completa de destino
    $rutaDestino = $directorioDestino . $nombreArchivo;

    // Mueve el archivo de la ruta temporal al directorio de destino
    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaDestino)) {
        http_response_code(200);
        echo json_encode(["mensaje" => "El archivo se ha subido correctamente a la ruta: $rutaDestino"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Error al mover el archivo al directorio de destino."]);
    }
} else {
    echo json_encode(["error" => "Error al subir el archivo."]);
}

?>
