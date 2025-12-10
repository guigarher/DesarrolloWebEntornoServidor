<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de productos</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 1rem; }
        h1 { margin-bottom: 0.5rem; }
        form { margin-bottom: 1.5rem; padding: 1rem; border: 1px solid #ccc; }
        label { display: block; margin-bottom: 0.5rem; }
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            max-width: 300px;
            padding: 0.3rem;
            margin-top: 0.2rem;
        }
        table { border-collapse: collapse; width: 100%; margin-top: 1rem; }
        th, td { border: 1px solid #ccc; padding: 0.3rem 0.5rem; text-align: left; }
        th { background-color: #f0f0f0; }
        .errores { color: red; margin-bottom: 0.5rem; }
        .ok { color: green; margin-bottom: 0.5rem; }
    </style>
</head>
<body>

    <h1>Gestión de productos</h1>

    <?php if (!empty($errores)): ?>
        <div class="errores">
            <?php foreach ($errores as $err): ?>
                <div>⚠️ <?= htmlspecialchars($err) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($mensajeOK)): ?>
        <div class="ok">✅ <?= htmlspecialchars($mensajeOK) ?></div>
    <?php endif; ?>

    <h2>Nuevo producto</h2>
    <form method="post" action="productos.php">
        <label>
            Nombre*:
            <input type="text" name="nombre" required>
        </label>

        <label>
            Código de barras:
            <input type="text" name="codigo_barras">
        </label>

        <label>
            Código interno:
            <input type="text" name="codigo">
        </label>

        <label>
            PVP*:
            <input type="number" step="0.01" name="pvp" required>
        </label>

        <label>
            Fecha de caducidad:
            <input type="date" name="fecha_caducidad">
        </label>

        <button type="submit">Guardar producto</button>
    </form>

    <h2>Listado de productos</h2>
    <?php if (empty($productos)): ?>
        <p>No hay productos en la base de datos.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Código barras</th>
                    <th>Código</th>
                    <th>PVP (€)</th>
                    <th>Fecha caducidad</th>
                    <th>Fecha actualización</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['ID']) ?></td>
                        <td><?= htmlspecialchars($p['Nombre']) ?></td>
                        <td><?= htmlspecialchars($p['CodigoBarras']) ?></td>
                        <td><?= htmlspecialchars($p['Codigo']) ?></td>
                        <td><?= htmlspecialchars($p['PVP']) ?></td>
                        <td><?= htmlspecialchars($p['FechaCaducidad']) ?></td>
                        <td><?= htmlspecialchars($p['FechaActualizacion']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>
