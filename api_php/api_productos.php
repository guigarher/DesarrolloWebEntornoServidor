<?php
header("Content-Type: application/json; charset=utf-8");

// Función única para responder
function responder(int $status, array $data) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// Convertir warnings en excepciones
set_error_handler(function ($severity, $message) {
    throw new ErrorException($message);
});

try {
    require_once __DIR__ . "/db.php";

    // SOLO GET de momento
    if ($_SERVER["REQUEST_METHOD"] !== "GET") {
        responder(400, [
            "error" => "Método no permitido",
            "code"  => "BAD_METHOD"
        ]);
    }

    $stmt = $pdo->query("
    SELECT ID, Nombre, CodigoBarras, Codigo, PVP, FechaCaducidad, FechaActualizacion
    FROM productos
    ORDER BY ID DESC
    ");
    $productos = $stmt->fetchAll();


    responder(200, [
        "ok" => true,
        "data" => $productos
    ]);

} catch (PDOException $e) {
    // 🔥 MySQL apagado / error de conexión
    responder(500, [
        "error" => "No hay conexión con la base de datos",
        "code"  => "DB_ERROR"
    ]);
} catch (Throwable $e) {
    responder(500, [
        "error" => "Error interno del servidor",
        "code"  => "SERVER_ERROR"
    ]);
}
