<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Respuesta JSON manual</title>
</head>
<body>
  <h1>Resultado JSON</h1>

  <?php
  // 1️ Recibir datos del formulario
  $nombre   = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $email    = $_POST['email'];
  $veces    = (int)($_POST['veces'] ?? 1);
  if ($veces < 1) $veces = 1;

  // 2️ Empezar el JSON
  $json = "{
  \"empleados\":[";

  // 3️ Bucle para crear los objetos
  for ($i = 1; $i <= $veces; $i++) {
    $json .= "
    {
      \"nombre\": \"$nombre\",
      \"apellido\": \"$apellido\",
      \"email\": \"$email\"
    }";

    // Añadir coma solo si NO es el último
    if ($i < $veces) {
      $json .= ",";
    }
  }

  // 4️ Cerrar el array JSON
  $json .= "
    ]
  }";

  // 5️ Mostrar el resultado
  echo "<pre>$json</pre>";
  ?>

  <p><a href='formulario.html'>← Volver al formulario</a></p>
</body>
</html>
