<?php

require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

// Verifica si se ha enviado una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene el contenido del cuerpo de la solicitud
    $json = file_get_contents('php://input');
    // Decodifica el JSON en un array asociativo
    $datos = json_decode($json, true);

    // Verifica si se pudieron decodificar los datos correctamente
    if ($datos === null) {
        http_response_code(400); // Código de respuesta HTTP 400: Solicitud incorrecta
        echo 'Error: El formato de los datos es inválido.';
        exit;
    }
    // Verifica si se proporcionaron los datos necesarios
    if (!isset($datos['mailTo']) || !isset($datos['subject'])) {
        http_response_code(400); // Código de respuesta HTTP 400: Solicitud incorrecta
        echo 'Error: Los datos proporcionados son insuficientes.';
        exit;
    }
    // Obtiene los datos del formulario
    $destinatario = $datos['mailTo'];
    $asunto = $datos['subject'];

    // Crea una nueva instancia de PHPMailer
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Host = 'smtp.hostinger.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'larp-transport@solu-tec.net';
    $mail->Password = 'Mexico_123';
    $mail->setFrom('larp-transport@solu-tec.net', 'LARP');
    $mail->addReplyTo('larp@larptransport.com', 'Larp Transport');
    $mail->addAddress($destinatario); // Usa el destinatario recibido dinámicamente
    $mail->Subject = $asunto; // Usa el asunto recibido dinámicamente
    $mail->msgHTML(file_get_contents('message.html'), __DIR__);
    $mail->Body = 'This is just a plain text message body.';
    $mail->addAttachment('../pdfs/cotizacion.pdf');
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'The email message was sent.';
    }
} else {
    echo 'Error: No se ha enviado una solicitud POST.';
}

?>
