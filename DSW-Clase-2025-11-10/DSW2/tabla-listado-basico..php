 <?php
// Mejorado en: https://www.w3schools.com/php/php_mysql_select.asp 
require 'eco-config.php';

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn->prepare("SELECT id, firstname, lastname FROM MyGuests");
  $stmt->execute();

/*  $num_rows = (int) $stmt->fetch(PDO::FETCH_NUM) ;
  echo $num_rows;
  echo "<br>";
  $num_rows = $stmt->fetch(PDO::FETCH_NUM) ;
  echo count($num_rows);
  echo "<br>";
  */
  
  $num_rows = $stmt->fetch(PDO::FETCH_NUM) ;
  if (count($num_rows) > 0) {
	// output data of each row
	foreach ($stmt as $row) {
		echo $row["id"]." | ".$row["firstname"]." ".$row["lastname"]."<br>";
    }
	echo "Total -> " . count($num_rows);
  } else {
	echo "0 results";
  }
  
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;

?> 