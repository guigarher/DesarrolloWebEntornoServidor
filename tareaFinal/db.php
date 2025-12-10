<?php
require_once __DIR__ . '/eco-config.php';

try {
    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";

    //PostgreSQL:
    // $dsn = "pgsql:host=$DB_HOST;dbname=$DB_NAME;port=5432";

    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "error"   => "Error de conexión a la base de datos",
        "details" => $e->getMessage()
    ]);
    exit;
}
