<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreHotel = $_POST['nombreHotel'];
    $ciudad = $_POST['ciudad'];
    $pais = $_POST['pais'];
    $fechaViaje = $_POST['fechaViaje'];
    $duracionViaje = $_POST['duracionViaje'];
    $email = $_POST['email'];

    $to_agencia = "viajes@tuagenciadeviajes.com";
    $subject_agencia = "Nueva Solicitud de Viaje";
    $message_agencia = "Detalles de la solicitud:\n\n";
    $message_agencia .= "Nombre del Hotel: $nombreHotel\n";
    $message_agencia .= "Ciudad: $ciudad\n";
    $message_agencia .= "País: $pais\n";
    $message_agencia .= "Fecha de Viaje: $fechaViaje\n";
    $message_agencia .= "Duración del Viaje: $duracionViaje días\n";


    $headers_agencia = 'From: viajes@agenciadeviajes.com' . "\r\n";

    // Enviar correo a la agencia
    $mail_agencia = mail($to_agencia, $subject_agencia, $message_agencia, $headers_agencia);

    // Correo Resumen Solicitante
    $to_solicitante = $email;
    $subject_solicitante = "Confirmación de Solicitud de Viaje";
    $message_solicitante = "Estimado/a viajero/a,\n\n";
    $message_solicitante .= "Hemos recibido su solicitud de viaje con los siguientes detalles:\n\n";
    $message_solicitante .= "Nombre del Hotel: $nombreHotel\n";
    $message_solicitante .= "Ciudad: $ciudad\n";
    $message_solicitante .= "País: $pais\n";
    $message_solicitante .= "Fecha de Viaje: $fechaViaje\n";
    $message_solicitante .= "Duración del Viaje: $duracionViaje días\n";
    $message_solicitante .= "\nGracias por confiar en nosotros. Le estaremos contactando pronto.\n\n";
    $message_solicitante .= "Atentamente,\nTu Agencia de Viajes";

    // Encabezados Solicitante
    $headers_solicitante = 'From: viajes@tuagenciadeviajes.com' . "\r\n";

    // Enviar correo especial al solicitante
    $mail_solicitante = mail($to_solicitante, $subject_solicitante, $message_solicitante, $headers_solicitante);

    if ($mail_agencia && $mail_solicitante) {
        echo "El correo fue enviado exitosamente tanto a la agencia como al solicitante.";
    } else {
        echo "Hubo un error al enviar el correo.";
    }
}
?>
