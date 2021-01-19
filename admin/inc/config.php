<?php
// Error Reporting Turn On
ini_set('error_reporting', E_ALL);

// Setting up the time zone

// Host Name
$dbhost = 'localhost';

// Database Name
$dbname = 'aseds';

// Database Username
$dbuser = 'root';

// Database Password
$dbpass = '123456';

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname};charset=utf8", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}