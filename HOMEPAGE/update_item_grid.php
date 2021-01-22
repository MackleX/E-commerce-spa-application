
<?php

require_once("./header.php");

$id = $_REQUEST["id"];

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



$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);



ob_end_clean();
if ($id !== "") {
    $childsArray = midCatChilds($id);
    foreach ($result as $index => $row) {
        if (!in_array( $row['ecat_id'],$childsArray)) {
            unset($result[$index]);
        }
    }
}


function midCatChilds($midCatId)
{
    global $end_cat_id, $end_to_mid_cat_id;
    $childsArray = array();
    for ($i = 0; $i < count($end_cat_id); $i++) {
        if ($midCatId == $end_to_mid_cat_id[$i]) {
            $childsArray[] = $end_to_mid_cat_id[$i];
        }
    }
    return $childsArray;
}

$response = json_encode($result);

echo $response;


?>
