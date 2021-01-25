<?php
ob_start();

try {

	$connection = new PDO("mysql:dbname=doodle_db;host=localhost", "root", "");
	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
?>