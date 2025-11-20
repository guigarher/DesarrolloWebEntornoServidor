<html>
<body>

<?php
$myfile = fopen("webdictionary.php", "r") or die("Unable to open file!");
echo fgets($myfile);
echo fgets($myfile);
echo fgets($myfile);
echo fgets($myfile);
echo fgets($myfile);
echo fgets($myfile);
fclose($myfile);
?>

</body>
</html>