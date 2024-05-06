<?php
use PHPMailer\PHPMailer\PHPMailer;


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
    if (!isset($datos['mailTo']) || !isset($datos['nameFile'])) {
        http_response_code(400); 
        echo 'Error: Los datos proporcionados son insuficientes. Solicitud incorrecta';
        exit;
    }
    // Obtiene los datos del formulario
    $destinatario = $datos['mailTo'];
    $adjunto = $datos['nameFile'];

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
    // $mail->addAddress('larp@larptransport.com', 'Larp Transport');
    $mail->addAddress('ij.innovaciones@gmail.com', 'Ij Innovaciones');
    $mail->addAddress($destinatario); // Destinatario recibido dinámicamente
    $mail->Subject = 'Cotizacon No: '.$adjunto; 
    $mail->msgHTML(file_get_contents('message.html'), __DIR__);
    $mail->Body = 'Tu cotizacion esta lista';
    $mail->addAttachment('cotizaciones/'.$adjunto);
    if (!$mail->send()) {
        echo json_encode(["error" => 'Mailer Error: ' . $mail->ErrorInfo]);

    } else {
        echo 'The email message was sent.';
        echo json_encode(["error" => 'The email message was sent.']);
    }
 } else {
    echo json_encode(["error" => 'Error: Bad Request.']);
 }

?>
