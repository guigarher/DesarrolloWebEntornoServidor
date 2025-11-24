<?php

require 'config.php';

try {
    $dsnServidor = "mysql:host=$servername;charset=utf8mb4";
    $conn = new PDO($dsnServidor, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "<p>Conexión al servidor MySQL correcta.</p>";

    
    $sqlCrearBD = "CREATE DATABASE IF NOT EXISTS $dbname
                   CHARACTER SET utf8mb4
                   COLLATE utf8mb4_unicode_ci";
    $conn->exec($sqlCrearBD);

    echo "<p>Base de datos <strong>$dbname</strong> creada (o ya existía).</p>";

    
    $dsnBD = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
    $connBD = new PDO($dsnBD, $username, $password);
    $connBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    $sqlCrearTabla = "
        CREATE TABLE IF NOT EXISTS envios_txt (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) NOT NULL,
            texto TEXT NOT NULL,
            fecha_envio DATETIME NOT NULL
        )
    ";

    $connBD->exec($sqlCrearTabla);

    echo "<p>Tabla <strong>envios_txt</strong> creada (o ya existía).</p>";
    echo "<p><strong>Todo listo.</strong> Ya puedes ejecutar procesar_txt.php.</p>";

} catch (PDOException $e) {
    echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
}
