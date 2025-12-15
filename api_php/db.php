<?php
require_once __DIR__ . "/eco-config.php";

$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4;connect_timeout=2";

$pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);
