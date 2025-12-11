<?php

require_once 'eco-config.php';

try {
    //Conexión PDO
    $dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    echo "<h1>Insertando productos...</h1>";

    //Array de productos de prueba
    $productosDemo = [
        [
            "Nombre"         => "Tomate Raf",
            "CodigoBarras"   => "8410001000015",
            "Codigo"         => "TOM-RAF-001",
            "PVP"            => 4.20,
            "FechaCaducidad" => "2026-03-20"
        ],
        [
            "Nombre"         => "Leche entera 1L",
            "CodigoBarras"   => "8410001000022",
            "Codigo"         => "LEC-ENT-1L",
            "PVP"            => 1.05,
            "FechaCaducidad" => "2025-12-31"
        ],
        [
            "Nombre"         => "Café molido 250g",
            "CodigoBarras"   => "8410001000039",
            "Codigo"         => "CAF-MOL-250",
            "PVP"            => 3.80,
            "FechaCaducidad" => "2027-01-15"
        ],
        [
            "Nombre"         => "Arroz redondo 1kg",
            "CodigoBarras"   => "8410001000046",
            "Codigo"         => "ARR-RED-1K",
            "PVP"            => 2.10,
            "FechaCaducidad" => "2027-06-30"
        ],
        [
            "Nombre"         => "Garbanzos cocidos bote",
            "CodigoBarras"   => "8410001000053",
            "Codigo"         => "GAR-COC-400",
            "PVP"            => 1.25,
            "FechaCaducidad" => "2026-09-10"
        ],
    ];

    //Preparar el INSERT 
    $sql = "INSERT INTO productos
                (Nombre, CodigoBarras, Codigo, PVP, FechaCaducidad)
            VALUES
                (:Nombre, :CodigoBarras, :Codigo, :PVP, :FechaCaducidad)";
    $stmt = $pdo->prepare($sql);

    //Recorrer el array e ir insertando
    $insertados = 0;

    foreach ($productosDemo as $p) {
        $stmt->execute([
            ':Nombre'         => $p['Nombre'],
            ':CodigoBarras'   => $p['CodigoBarras'],
            ':Codigo'         => $p['Codigo'],
            ':PVP'            => $p['PVP'],
            ':FechaCaducidad' => $p['FechaCaducidad']
        ]);
        $insertados++;
        echo "Insertado: " . htmlspecialchars($p['Nombre']) . "<br>";
    }

    echo "<br><strong>Productos insertados: $insertados</strong><br>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
