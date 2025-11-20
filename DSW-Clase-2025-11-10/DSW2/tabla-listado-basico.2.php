 <?php
// Mejorado en: https://www.w3schools.com/php/php_mysql_select.asp 
require 'eco-config.php';

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT id, firstname, lastname FROM MyGuests");
  $stmt->execute();

  if ( !empty($stmt)) {
    echo "Hay registros. <br>";
    while( ($row = $stmt->fetch()) !== false):
      echo "<a href=https://www.dominio.aaa?ID=".$row['id'].">".$row['id']."</a><br>" ;

	// echo $row['id'].  " -> ".$row['lastname']."<br>" ;


    endwhile;
  } else {
    echo "No hay registros";
  }
  
  
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;

?> 