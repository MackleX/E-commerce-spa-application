<?php
ob_start();
session_start();

include("../config/config.php");












$statement = $pdo->prepare("SELECT * FROM tbl_top_category");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);


	foreach ($result as $row) {
		$top_cat_id[] = $row['tcat_id'];
		$top_cat_name[] = $row['tcat_name'];
	}


	$statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$mid_cat_id[] = $row['mcat_id'];
		$mid_cat_name[] = $row['mcat_name'];
		$mid_top_cat_id[] = $row['tcat_id'];
	}

	$statement = $pdo->prepare("SELECT * FROM tbl_end_category");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$end_cat_id[] = $row['ecat_id'];
		$end_cat_name[] = $row['ecat_name'];
		$end_mid_cat_id[] = $row['mcat_id'];
	}



?>
