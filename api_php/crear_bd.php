<?php

$adminHost = "localhost";
$adminUser = "root";
$adminPass = "";  

try {
    //Conectar como administrador
    $dsn = "mysql:host=$adminHost;charset=utf8mb4";
    $pdo = new PDO($dsn, $adminUser, $adminPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    //Crear base de datos 
    $sqlCrearBD = "CREATE DATABASE IF NOT EXISTS basedatosdsw
                   CHARACTER SET utf8mb4
                   COLLATE utf8mb4_general_ci";
    $pdo->exec($sqlCrearBD);
    echo "Base de datos 'basedatosdsw' creada (o ya existía).<br>";

    //Conectar
    $dsnBD = "mysql:host=$adminHost;dbname=basedatosdsw;charset=utf8mb4";
    $pdoBD = new PDO($dsnBD, $adminUser, $adminPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    //Crear tabla productos
    $sqlCrearTabla = "api
        CREATE TABLE IF NOT EXISTS productos (
            ID              INT(11) NOT NULL AUTO_INCREMENT,
            Nombre          VARCHAR(255) NOT NULL,
            CodigoBarras    VARCHAR(50) DEFAULT NULL,
            Codigo          VARCHAR(50) DEFAULT NULL,
            PVP             DECIMAL(10,2) NOT NULL,
            FechaCaducidad  DATE DEFAULT NULL,
            FechaActualizacion TIMESTAMP NOT NULL 
                DEFAULT CURRENT_TIMESTAMP 
                ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (ID)
        ) ENGINE=InnoDB;
    ";

    $pdoBD->exec($sqlCrearTabla);
    echo "Tabla productos creada";
} catch (PDOException $e) {
    echo "Error al crear la base de datos o la tabla: " . $e->getMessage();
}
