<?php
require_once 'eco-config.php';

//Conectar con PDO
try {
    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

//inserción
$errores   = [];
$mensajeOK = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre         = trim($_POST['nombre'] ?? '');
    $codigoBarras   = trim($_POST['codigo_barras'] ?? '');
    $codigo         = trim($_POST['codigo'] ?? '');
    $pvp            = trim($_POST['pvp'] ?? '');
    $fechaCaducidad = trim($_POST['fecha_caducidad'] ?? '');

    if ($nombre === '') {
        $errores[] = "El campo Nombre es obligatorio.";
    }
    if ($pvp === '' || !is_numeric($pvp)) {
        $errores[] = "El PVP es obligatorio y debe ser numérico.";
    }

    if (empty($errores)) {
        try {
            $sql = "INSERT INTO productos
                        (Nombre, CodigoBarras, Codigo, PVP, FechaCaducidad)
                    VALUES
                        (:Nombre, :CodigoBarras, :Codigo, :PVP, :FechaCaducidad)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':Nombre'         => $nombre,
                ':CodigoBarras'   => $codigoBarras ?: null,
                ':Codigo'         => $codigo ?: null,
                ':PVP'            => $pvp,
                ':FechaCaducidad' => $fechaCaducidad ?: null
            ]);

            $mensajeOK = "Producto insertado correctamente.";
        } catch (PDOException $e) {
            $errores[] = "Error al insertar el producto: " . $e->getMessage();
        }
    }
}

//Obtener productos
try {
    $sql = "SELECT ID, Nombre, CodigoBarras, Codigo, PVP, FechaCaducidad, FechaActualizacion
            FROM productos
            ORDER BY ID DESC";
    $stmt = $pdo->query($sql);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener productos: " . $e->getMessage());
}

//Cargar HTML
require 'productos-vista.php';
