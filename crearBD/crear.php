<?php
// === Ajusta estas credenciales: deben ser de un usuario administrador (p. ej. root en local) ===
$admin_host = 'localhost';
$admin_user = 'root';
$admin_pass = ''; // pon tu contraseña de root/administrador

// Función simple para validar nombres de BD/usuario (solo letras, números y _)
function sane_ident($s) {
  return preg_match('/^[A-Za-z0-9_]{1,64}$/', $s);
}

// Manejo POST
$msg = '';
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $dbname   = trim($_POST['dbname']   ?? '');
  $newuser  = trim($_POST['newuser']  ?? '');
  $newpass  = $_POST['newpass']       ?? '';
  $hostuser = trim($_POST['hostuser'] ?? 'localhost'); // dónde se conectará ese user

  try {
    if (!sane_ident($dbname))  throw new Exception('Nombre de base de datos no válido.');
    if (!sane_ident($newuser)) throw new Exception('Nombre de usuario no válido.');
    if ($newpass === '')       throw new Exception('La contraseña del usuario no puede estar vacía.');
    if (!preg_match('/^[A-Za-z0-9._%-]{1,255}$/', $hostuser)) throw new Exception('Host del usuario no válido.');

    $pdo = new PDO("mysql:host=$admin_host;charset=utf8mb4", $admin_user, $admin_pass, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    // 1) Crear la base de datos con charset/collation modernos
    $sqlCreateDb = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    // Si tu MySQL no soporta _0900_, usa utf8mb4_general_ci o utf8mb4_unicode_ci
    $pdo->exec($sqlCreateDb);

    // 2) Crear el usuario (si no existe) y darle permisos sobre esa BD
    // IMPORTANTE: no se pueden parametrizar identificadores; por eso validamos antes.
    $sqlCreateUser = "CREATE USER IF NOT EXISTS '$newuser'@'$hostuser' IDENTIFIED BY :pwd";
    $stmt = $pdo->prepare($sqlCreateUser);
    $stmt->execute([':pwd' => $newpass]);

    // Si el usuario ya existía y quieres asegurar su contraseña, descomenta:
    // $sqlAlterUser = "ALTER USER '$newuser'@'$hostuser' IDENTIFIED BY :pwd";
    // $stmt = $pdo->prepare($sqlAlterUser);
    // $stmt->execute([':pwd' => $newpass]);

    // 3) Conceder privilegios sobre esa BD
    $sqlGrant = "GRANT ALL PRIVILEGES ON `$dbname`.* TO '$newuser'@'$hostuser'";
    $pdo->exec($sqlGrant);

    // 4) Aplicar cambios
    $pdo->exec("FLUSH PRIVILEGES");

    $msg = "✅ Base de datos `$dbname` creada (o ya existía) y usuario `$newuser`@`$hostuser` con permisos.";
  } catch (Exception $e) {
    $err = "❌ Error: " . $e->getMessage();
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Crear BD y Usuario</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body { font-family: system-ui, sans-serif; max-width: 720px; margin: 2rem auto; padding: 0 1rem; }
    form { display: grid; gap: .75rem; background: #f7f7f8; padding: 1rem; border: 1px solid #ddd; border-radius: .5rem; }
    label { font-weight: 600; }
    input { padding: .5rem .6rem; border: 1px solid #bbb; border-radius: .375rem; }
    button { padding: .6rem .9rem; border: 0; border-radius: .375rem; cursor: pointer; }
    .ok { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; padding: .75rem; border-radius: .5rem; }
    .err{ background: #fef2f2; color: #7f1d1d; border: 1px solid #fecaca; padding: .75rem; border-radius: .5rem; }
  </style>
</head>
<body>
  <h1>Crear Base de Datos y Usuario MySQL</h1>

  <?php if ($msg): ?><p class="ok"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
  <?php if ($err): ?><p class="err"><?= htmlspecialchars($err) ?></p><?php endif; ?>

  <form method="post" autocomplete="off">
    <div>
      <label>Nombre de la base de datos</label><br>
      <input name="dbname" required placeholder="p.ej. smart_economato">
    </div>
    <div>
      <label>Usuario nuevo</label><br>
      <input name="newuser" required placeholder="p.ej. economato_user">
    </div>
    <div>
      <label>Contraseña del usuario nuevo</label><br>
      <input name="newpass" type="password" required>
    </div>
    <div>
      <label>Host del usuario</label><br>
      <input name="hostuser" value="localhost">
    </div>
    <button type="submit">Crear BD + Usuario</button>
  </form>

  <p style="margin-top:1rem;color:#555">
    Tras crearla, recarga phpMyAdmin: deberías ver la base de datos en la barra lateral.  
    El usuario creado solo tendrá permisos sobre esa BD.
  </p>
</body>
</html>
