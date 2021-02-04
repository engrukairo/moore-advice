<?php
$hostname = "localhost";
$dbuser = "esperaso_mooredb";
$dbpw = "m00r3advLcE";
$dbb = "esperaso_mooredb";
try {
$mooredb = new PDO("mysql:host=$hostname;dbname=$dbb", $dbuser, $dbpw);
}
catch (PDOException $e) {
echo 'Error: '.$e->getMessage();
exit;
}
?>