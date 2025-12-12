<?php
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . '/db.php';

$method = $_SERVER["REQUEST_METHOD"];

// Para peticiones OPTIONS (preflight)
if ($method === "OPTIONS") {
    http_response_code(204);
    exit;
}

function responder($data, int $code = 200): void {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function leerJsonBody(): array {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

try {

    // =========================
    // READ (GET) - listar
    // =========================
    if ($method === "GET") {
        $sql = "SELECT 
                    ID, Nombre, CodigoBarras, Codigo, PVP,
                    FechaCaducidad, FechaActualizacion
                FROM productos
                ORDER BY ID DESC";

        $stmt = $pdo->query($sql);
        $productos = $stmt->fetchAll();

        responder($productos, 200);
    }

    // =========================
    // CREATE (POST) - crear
    // =========================
    if ($method === "POST") {
        $data = leerJsonBody();

        if (!isset($data["Nombre"]) || !isset($data["PVP"])) {
            responder(["error" => "Faltan campos obligatorios: Nombre y PVP."], 400);
        }

        $nombre         = trim((string)$data["Nombre"]);
        $codigoBarras   = $data["CodigoBarras"] ?? null;
        $codigo         = $data["Codigo"] ?? null;
        $pvp            = $data["PVP"];
        $fechaCaducidad = $data["FechaCaducidad"] ?? null;

        if ($nombre === "") {
            responder(["error" => "Nombre no puede estar vacío."], 400);
        }
        if (!is_numeric($pvp)) {
            responder(["error" => "PVP debe ser numérico."], 400);
        }

        $sql = "INSERT INTO productos
                    (Nombre, CodigoBarras, Codigo, PVP, FechaCaducidad)
                VALUES
                    (:Nombre, :CodigoBarras, :Codigo, :PVP, :FechaCaducidad)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':Nombre'         => $nombre,
            ':CodigoBarras'   => $codigoBarras ?: null,
            ':Codigo'         => $codigo ?: null,
            ':PVP'            => (float)$pvp,
            ':FechaCaducidad' => $fechaCaducidad ?: null
        ]);

        $nuevoId = (int)$pdo->lastInsertId();

        // Devolvemos el registro recién creado (incluye FechaActualizacion generada por MySQL)
        $stmt = $pdo->prepare("SELECT * FROM productos WHERE ID = :id");
        $stmt->execute([':id' => $nuevoId]);
        $producto = $stmt->fetch();

        responder([
            "mensaje"  => "Producto creado correctamente",
            "producto" => $producto
        ], 201);
    }

    // =========================
    // UPDATE (PUT) - modificar
    // =========================
    if ($method === "PUT") {
        // id por querystring: api_productos.php?id=5
        $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
        if ($id <= 0) {
            responder(["error" => "Falta el parámetro id en la URL. Ej: ?id=5"], 400);
        }

        $data = leerJsonBody();

        // Permitimos actualizar cualquiera de estos campos
        $camposPermitidos = ["Nombre", "CodigoBarras", "Codigo", "PVP", "FechaCaducidad"];
        $sets = [];
        $params = [":id" => $id];

        foreach ($camposPermitidos as $campo) {
            if (array_key_exists($campo, $data)) {
                $sets[] = "$campo = :$campo";

                if ($campo === "Nombre") {
                    $valor = trim((string)$data[$campo]);
                    if ($valor === "") {
                        responder(["error" => "Nombre no puede estar vacío."], 400);
                    }
                    $params[":$campo"] = $valor;
                } elseif ($campo === "PVP") {
                    if (!is_numeric($data[$campo])) {
                        responder(["error" => "PVP debe ser numérico."], 400);
                    }
                    $params[":$campo"] = (float)$data[$campo];
                } else {
                    // strings/fecha: permitimos null
                    $params[":$campo"] = ($data[$campo] === "" ? null : $data[$campo]);
                }
            }
        }

        if (empty($sets)) {
            responder(["error" => "No has enviado campos para actualizar."], 400);
        }

        // Comprobar que existe
        $stmt = $pdo->prepare("SELECT ID FROM productos WHERE ID = :id");
        $stmt->execute([":id" => $id]);
        if (!$stmt->fetch()) {
            responder(["error" => "No existe producto con ID $id"], 404);
        }

        $sql = "UPDATE productos SET " . implode(", ", $sets) . " WHERE ID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // Devolver el producto actualizado
        $stmt = $pdo->prepare("SELECT * FROM productos WHERE ID = :id");
        $stmt->execute([":id" => $id]);
        $producto = $stmt->fetch();

        responder([
            "mensaje"  => "Producto actualizado correctamente",
            "producto" => $producto
        ], 200);
    }

    // =========================
    // DELETE (DELETE) - borrar
    // =========================
    if ($method === "DELETE") {
        $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
        if ($id <= 0) {
            responder(["error" => "Falta el parámetro id en la URL. Ej: ?id=5"], 400);
        }

        // Comprobar que existe
        $stmt = $pdo->prepare("SELECT * FROM productos WHERE ID = :id");
        $stmt->execute([":id" => $id]);
        $producto = $stmt->fetch();

        if (!$producto) {
            responder(["error" => "No existe producto con ID $id"], 404);
        }

        $stmt = $pdo->prepare("DELETE FROM productos WHERE ID = :id");
        $stmt->execute([":id" => $id]);

        responder([
            "mensaje"  => "Producto eliminado correctamente",
            "producto" => $producto
        ], 200);
    }

    responder(["error" => "Método no permitido"], 405);

} catch (PDOException $e) {
    responder([
        "error"   => "Error de base de datos",
        "detalle" => $e->getMessage()
    ], 500);
}
