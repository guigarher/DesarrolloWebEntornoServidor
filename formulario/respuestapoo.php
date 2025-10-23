<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Respuesta JSON (POO mínima)</title>
</head>
<body>
  <h1>Resultado JSON (POO)</h1>

<?php
// --------- Clase (molde) para una persona ----------
class Persona {
  // Propiedades = los datos que guardamos
  private string $nombre;
  private string $apellido;
  private string $email;

  // Constructor = cómo se crea un objeto Persona
  public function __construct(string $nombre, string $apellido, string $email) {
    $this->nombre   = $nombre;   // $this->... accede a la propiedad del objeto
    $this->apellido = $apellido;
    $this->email    = $email;
  }

  // Método que devuelve el fragmento JSON de ESTA persona (sin coma final)
  public function aJson(): string {
    // OJO: si alguien escribe comillas en el nombre, habría que escaparlas.
    // Como versión mínima, asumimos que no las ponen.
    return "
    {
      \"nombre\": \"{$this->nombre}\",
      \"apellido\": \"{$this->apellido}\",
      \"email\": \"{$this->email}\"
    }";
  }
}

// --------- Controlador: leer POST y construir salida ----------
$nombre   = $_POST['nombre']   ?? '';
$apellido = $_POST['apellido'] ?? '';
$email    = $_POST['email']    ?? '';
$veces    = (int)($_POST['veces'] ?? 1);
if ($veces < 1) $veces = 1;

// Creamos UNA Persona con lo que llegó del formulario
$persona = new Persona($nombre, $apellido, $email);

// Empezamos el JSON con objeto raíz y lista employees
$json = "{
  \"empleados\":[";
// Repetimos la persona N veces
for ($i = 1; $i <= $veces; $i++) {
  $json .= $persona->aJson();   // pedimos a la persona su JSON
  if ($i < $veces) {            // coma solo entre elementos
    $json .= ",";
  }
}
// Cerramos
$json .= "
  ]
}";

// Mostramos para copiar
echo "<pre>$json</pre>";
?>

  <p><a href="formulario.html">← Volver</a></p>
</body>
</html>
