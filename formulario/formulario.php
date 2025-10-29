<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario simple</title>
  <script src="formulario.js" defer></script>
</head>
<body>
  <?php date_default_timezone_set('Atlantic/Canary'); ?>

  <h1>Formulario</h1>

  <form action="respuesta.php" method="post">
    <label>Nombre:
      <input type="text" name="nombre" id="nombre" required>
    </label>
    <br><br>

    <label>Apellido:
      <input type="text" name="apellido" id="apellido" required>
    </label>
    <br><br>

    <label>E-mail:
      <input type="email" name="email" id="email" required>
    </label>
    <br><br>

    <label>Número de repeticiones:
      <input type="number" name="veces" min="1" value="1" required>
    </label>
    <br><br>
    <label>Aceto las condiciones
    <input type="checkbox" name="check" id="check" required>
    </label>
    <br><br>
      <input type="hidden" name="fecha" id="fecha" value= "<?php echo date('l-d-m-Y h:i:sa'); ?>">

    <button type="submit" id="boton">Enviar</button>
  </form>
</body>
</html>
