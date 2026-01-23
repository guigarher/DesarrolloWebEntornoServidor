<?php
header("Content-Type: application/json; charset=utf-8");

// CORS (para que cualquier front pueda usar la API)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Respuesta a preflight
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204);
    exit;
}

// Función para responder en JSON
function responder(int $status, array $data): void {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// Leer JSON del body
function leer_json_body(): array {
    $raw = file_get_contents("php://input");
    if ($raw === false || trim($raw) === "") return [];
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        responder(400, [
            "ok"    => false,
            "error" => "JSON inválido",
            "code"  => "BAD_JSON"
        ]);
    }
    return $data;
}

// Convertir warnings en excepciones
set_error_handler(function ($severity, $message) {
    throw new ErrorException($message);
});

try {
    require_once __DIR__ . "/db.php";

    $method = $_SERVER["REQUEST_METHOD"];

    // =========================
    // GET: listar o uno por ID
    // =========================
    if ($method === "GET") {

        
        $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

        if ($id > 0) {
            $stmt = $pdo->prepare("
                SELECT ID, Nombre, CodigoBarras, Codigo, PVP, FechaCaducidad, FechaActualizacion
                FROM productos
                WHERE ID = :id
            ");
            $stmt->execute(["id" => $id]);
            $producto = $stmt->fetch();

            if (!$producto) {
                responder(404, [
                    "ok"    => false,
                    "error" => "Producto no encontrado",
                    "code"  => "NOT_FOUND"
                ]);
            }

            responder(200, [
                "ok"   => true,
                "data" => $producto
            ]);
        }

        // Listado general
        $stmt = $pdo->query("
            SELECT ID, Nombre, CodigoBarras, Codigo, PVP, FechaCaducidad, FechaActualizacion
            FROM productos
            ORDER BY ID DESC
        ");
        $productos = $stmt->fetchAll();

        responder(200, [
            "ok"   => true,
            "data" => $productos
        ]);
    }

    // =========================
    // POST: crear producto
    // =========================
    if ($method === "POST") {
        $data = leer_json_body();

        // Validación
        if (empty($data["Nombre"]) || !isset($data["PVP"])) {
            responder(400, [
                "ok"    => false,
                "error" => "Faltan campos obligatorios: Nombre y PVP",
                "code"  => "MISSING_FIELDS"
            ]);
        }

        $stmt = $pdo->prepare("
            INSERT INTO productos (Nombre, CodigoBarras, Codigo, PVP, FechaCaducidad)
            VALUES (:Nombre, :CodigoBarras, :Codigo, :PVP, :FechaCaducidad)
        ");
        $stmt->execute([
            "Nombre" => $data["Nombre"],
            "CodigoBarras" => $data["CodigoBarras"] ?? null,
            "Codigo" => $data["Codigo"] ?? null,
            "PVP" => $data["PVP"],
            "FechaCaducidad" => $data["FechaCaducidad"] ?? null
        ]);

        responder(201, [
            "ok"      => true,
            "message" => "Producto creado",
            "id"      => (int)$pdo->lastInsertId()
        ]);
    }

    // =========================
    // PUT: actualizar producto
    // =========================
    if ($method === "PUT") {
        $data = leer_json_body();

        if (empty($data["ID"])) {
            responder(400, [
                "ok"    => false,
                "error" => "Falta ID para actualizar",
                "code"  => "MISSING_ID"
            ]);
        }

        $id = (int)$data["ID"];

        // Comprobar existencia
        $check = $pdo->prepare("SELECT ID FROM productos WHERE ID = :id");
        $check->execute(["id" => $id]);
        if (!$check->fetch()) {
            responder(404, [
                "ok"    => false,
                "error" => "Producto no encontrado",
                "code"  => "NOT_FOUND"
            ]);
        }

        // Validación
        if (empty($data["Nombre"]) || !isset($data["PVP"])) {
            responder(400, [
                "ok"    => false,
                "error" => "Faltan campos obligatorios: Nombre y PVP",
                "code"  => "MISSING_FIELDS"
            ]);
        }

        $stmt = $pdo->prepare("
            UPDATE productos
            SET Nombre = :Nombre,
                CodigoBarras = :CodigoBarras,
                Codigo = :Codigo,
                PVP = :PVP,
                FechaCaducidad = :FechaCaducidad
            WHERE ID = :ID
        ");
        $stmt->execute([
            "ID" => $id,
            "Nombre" => $data["Nombre"],
            "CodigoBarras" => $data["CodigoBarras"] ?? null,
            "Codigo" => $data["Codigo"] ?? null,
            "PVP" => $data["PVP"],
            "FechaCaducidad" => $data["FechaCaducidad"] ?? null
        ]);

        responder(200, [
            "ok"      => true,
            "message" => "Producto actualizado",
            "id"      => $id
        ]);
    }

    // =========================
    // DELETE: borrar producto
    // =========================
    if ($method === "DELETE") {

        // Opción 1: /api_productos.php?id=3
        $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

        // Opción 2: JSON { "ID": 3 }
        if ($id <= 0) {
            $data = leer_json_body();
            if (!empty($data["ID"])) $id = (int)$data["ID"];
        }

        if ($id <= 0) {
            responder(400, [
                "ok"    => false,
                "error" => "Falta ID para borrar (usa ?id=... o body JSON con ID)",
                "code"  => "MISSING_ID"
            ]);
        }

        $stmt = $pdo->prepare("DELETE FROM productos WHERE ID = :id");
        $stmt->execute(["id" => $id]);

        if ($stmt->rowCount() === 0) {
            responder(404, [
                "ok"    => false,
                "error" => "Producto no encontrado",
                "code"  => "NOT_FOUND"
            ]);
        }

        responder(200, [
            "ok"      => true,
            "message" => "Producto borrado",
            "id"      => $id
        ]);
    }

    // Si llega aquí, método no permitido
    responder(405, [
        "ok"    => false,
        "error" => "Método no permitido",
        "code"  => "METHOD_NOT_ALLOWED"
    ]);

} catch (PDOException $e) {
    // Error de conexión / SQL
    responder(500, [
        "ok"    => false,
        "error" => "No hay conexión con la base de datos",
        "code"  => "DB_ERROR"
    ]);
} catch (Throwable $e) {
    responder(500, [
        "ok"    => false,
        "error" => "Error interno del servidor",
        "code"  => "SERVER_ERROR"
    ]);
}
