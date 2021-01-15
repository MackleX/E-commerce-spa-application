<?php
ob_start();
session_start();

include("./admin/inc/config.php");











if (!isset($_REQUEST['id']) || !isset($_REQUEST['type']))
{
    $isAll = true;

    

} else {
    $isAll = false;
}


{	
	$statement = $pdo->prepare("SELECT * FROM tbl_top_category");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);


	foreach ($result as $row) {
		$top[] = $row['tcat_id'];
		$top1[] = $row['tcat_name'];
	}


	$statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
	$statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    
	foreach ($result as $row) {
		$mid_cat_id[] = $row['mcat_id'];
		$mid_cat_name[] = $row['mcat_name'];
		$mid_to_top_cat_id[] = $row['tcat_id'];
	}


	$statement = $pdo->prepare("SELECT * FROM tbl_end_category");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$end_cat_id[] = $row['ecat_id'];
		$end_cat_name[] = $row['ecat_name'];
		$end_to_mid_cat_id[] = $row['mcat_id'];
	}

if(!$isAll){
	if ($_REQUEST['type'] == 'top-category') {
    
            $arr1 = array();
            $arr2 = array();

			for ($i = 0; $i < count($mid_to_top_cat_id); $i++) {
				if ($mid_to_top_cat_id[$i] == $_REQUEST['id']) {
                    $arr1[] = $mid_cat_id[$i];
                    $arr2[] = $mid_cat_name[$i];
				}
            }
            $mid_cat_id = $arr1;
            $mid_cat_name = $arr2;
            foreach($mid_cat_id as $id){
                foreach( $end_cat_id as $end_id){
                    if($id == $end_id){
                        $final_ecat_ids[] = $end_id;
                    }
                }
            }
		
    }
}


        
        
}
        



?>
