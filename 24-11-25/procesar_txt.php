<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Procesar TXT y enviar correos</title>
</head>
<body>

<?php

require 'config.php';

try {
    $dsn  = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
    $conn = new PDO($dsn, $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<p>Conexión a la base de datos correcta.</p>";

    $rutaArchivo = __DIR__ . '/correos.txt';

    if (!file_exists($rutaArchivo)) {
        die("<p style='color:red'>No se encuentra el archivo correos.txt</p>");
    }

    $fh = fopen($rutaArchivo, 'r');
    if (!$fh) {
        die("<p style='color:red'>No se pudo abrir el archivo correos.txt</p>");
    }

    echo "<p>Archivo correos.txt abierto. Procesando líneas...</p>";

    $stmt = $conn->prepare("
        INSERT INTO envios_txt (email, texto, fecha_envio)
        VALUES (:email, :texto, NOW())
    ");

    while (($linea = fgets($fh)) !== false) {

        $linea = trim($linea);

        if ($linea === '') {
            continue;
        }

        $partes = explode(';', $linea, 2); 

        $email = trim($partes[0] ?? '');
        $texto = trim($partes[1] ?? '');

        if ($email === '' || $texto === '') {
            echo "<p style='color:orange'>Línea ignorada (faltan datos): $linea</p>";
            continue;
        }

        $asunto    = "Mensaje automático desde PHP (TXT)";
        $mensaje   = $texto; 
        $cabeceras = "From: no-responder@midominio.com\r\n" .
                     "X-Mailer: PHP/" . phpversion();

        $resultadoMail = mail($email, $asunto, $mensaje, $cabeceras);

        if ($resultadoMail) {
            echo "<p>Correo enviado (o intentado) a: <strong>$email</strong></p>";

            $stmt->execute([
                ':email' => $email,
                ':texto' => $texto
            ]);

        } else {
            echo "<p style='color:red'>Error al enviar correo a $email</p>";
             $stmt->execute([
                ':email' => $email,
                ':texto' => $texto
            ]);

        }
    }

    fclose($fh);

    echo "<p>Proceso completo.</p>";

} catch (PDOException $e) {
    echo "<p style='color:red'>Error de base de datos: " . $e->getMessage() . "</p>";
}
?>

</body>
</html>
