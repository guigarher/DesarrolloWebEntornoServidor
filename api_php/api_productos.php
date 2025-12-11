<?php

header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . '/db.php';


$method = $_SERVER["REQUEST_METHOD"];

try {

    if ($method === "GET") {
        $sql = "SELECT 
                    ID,
                    Nombre,
                    CodigoBarras,
                    Codigo,
                    PVP,
                    FechaCaducidad,
                    FechaActualizacion
                FROM productos
                ORDER BY ID DESC";

        // Ejecutamos la consulta 
        $stmt = $pdo->query($sql);

        // Obtenemos todos los productos
        $productos = $stmt->fetchAll();

        // Convertimos el array PHP a JSON 
        echo json_encode($productos);
        exit; 
    }

    if ($method === "POST") {
        $json = file_get_contents("php://input");

        //Convertir ese JSON a array de PHP
        $data = json_decode($json, true);

        //Validaciones
        if (!isset($data["Nombre"]) || !isset($data["PVP"])) {
            http_response_code(400); 
            echo json_encode(["error" => "Faltan campos obligatorios: Nombre y PVP."]);
            exit;
        }

        //Guardar en variables
        $nombre         = $data["Nombre"];
        $codigoBarras   = $data["CodigoBarras"] ?? null;   
        $codigo         = $data["Codigo"] ?? null;
        $pvp            = $data["PVP"];
        $fechaCaducidad = $data["FechaCaducidad"] ?? null;

        //Preparar el INSERT 
        $sql = "INSERT INTO productos
                    (Nombre, CodigoBarras, Codigo, PVP, FechaCaducidad)
                VALUES
                    (:Nombre, :CodigoBarras, :Codigo, :PVP, :FechaCaducidad)";

        $stmt = $pdo->prepare($sql);

        //Ejecutar el INSERT 
        $stmt->execute([
            ':Nombre'         => $nombre,
            ':CodigoBarras'   => $codigoBarras,
            ':Codigo'         => $codigo,
            ':PVP'            => $pvp,
            ':FechaCaducidad' => $fechaCaducidad
        ]);

        //Obtener el ID producto
        $nuevoId = $pdo->lastInsertId();

        //Devolver un JSON diciendo que todo OK y los datos del nuevo producto
        echo json_encode([
            "mensaje"  => "Producto creado correctamente",
            "producto" => [
                "ID"              => (int)$nuevoId,
                "Nombre"          => $nombre,
                "CodigoBarras"    => $codigoBarras,
                "Codigo"          => $codigo,
                "PVP"             => (float)$pvp,
                "FechaCaducidad"  => $fechaCaducidad
            ]
        ]);
        exit;
    }
    
    http_response_code(405); // 405 = método no permitido
    echo json_encode(["error" => "Método no permitido"]);

} catch (PDOException $e) {
    http_response_code(500); // 500 = error interno del servidor
    echo json_encode([
        "error"   => "Error de base de datos",
        "detalle" => $e->getMessage()
    ]);
}
