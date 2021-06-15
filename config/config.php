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

//this config file belong to fashionys project, it was the one of the first files that i used as reference to know where i am going, the fashionys didn't use any ajax, 
// and it was a total static web app, this app is reactive for the client and static for the admin and have many more features.
// the admin panel design belong to CreativeTim

