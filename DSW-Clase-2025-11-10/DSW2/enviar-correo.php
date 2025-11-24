<?php
require 'vendor/autoload.php';
require 'DSW/eco-config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//! Obtener datos del destinatario desde el formulario
$destinatario_correo = $_POST['correo'] ?? ''; // -> Dato sacado de un formulario
$destinatario_nombre = $_POST['nombre'] ?? ''; // -> Dato sacado de un formulario

if (empty($destinatario_correo) || empty($destinatario_nombre)) {
    die('Por favor completa todos los campos.');
}

try {
    //! Conectar a la base de datos
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, firstname, lastname, email FROM MyGuests");
    $stmt->execute();

    echo "<h2>Enviando correos a: $destinatario_nombre ($destinatario_correo)</h2><br>";

    $enviados = 0;
    $errores = 0;

    //! Por cada registro de la BD, enviar un correo al destinatario ingresado
    while ($row = $stmt->fetch()) {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $google_email; // Aqui va tu correo para enviar
            $mail->Password   = $app_password; // Aqui va la contraseña de aplicacion de google (https://support.google.com/mail/answer/185833?hl=es)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom($google_email, 'Sistema de Notificaciones');
            //! El destinatario es el que ingresó en el formulario
            $mail->addAddress($destinatario_correo, $destinatario_nombre);
           
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            //! Asunto = ID del registro
            $mail->Subject = "ID: " . $row['id'];
            //! Cuerpo = Nombre, Apellido y Correo del registro
            $mail->Body = "Nombre: " . $row['firstname'] . "<br>" .
                         "Apellido: " . $row['lastname'] . "<br>" .
                         "Correo: " . $row['email'];
       


            $mail->send();
           
            echo "Correo #" . $row['id'] . " enviado (Datos: " . $row['firstname'] . " " . $row['lastname'] . ")<br>";
            $enviados++;
            //! Descanso :)
            sleep(2);
           
        } catch (Exception $e) {
            echo "Error enviando correo #" . $row['id'] . ": {$mail->ErrorInfo}<br>";
            $errores++;
        }
    }

    echo "<br><strong>Resumen:</strong><br>";
    echo "Enviados a $destinatario_correo: $enviados<br>";
    echo "Errores: $errores<br>";

} catch(PDOException $e) {
    echo "Error de base de datos: " . $e->getMessage();
}

$conn = null;

?>