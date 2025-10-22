<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bucle</title>
</head>
<body>
    <h1>Número del 1 al 100</h1>
    <?php
        $num=1;
        while($num<=100){
            echo "<p>Número: $num</p>";
        }
        $num++;
    ?>
</body>
</html>