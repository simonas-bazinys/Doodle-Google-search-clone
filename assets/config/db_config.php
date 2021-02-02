<?php
ob_start();

try {
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$connection = new PDO("mysql:dbname=doodle_db;host=localhost", "root", "");
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
?>