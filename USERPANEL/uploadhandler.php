<?php
require_once('../config/config.php');
session_start();


$productName = htmlentities($_POST['productName']);
$productslogan = htmlentities($_POST['productSlogan']);
$productPrice = htmlentities($_POST['productPrice']);
$productQty = htmlentities($_POST['productAvailableQuantity']);
$productDesc = htmlentities($_POST['productDescription']);
$sellerId = htmlentities($_SESSION['customer']['client_id']);
$isProductFeatured = 0;



$statement = $pdo->prepare("SELECT ecat_id FROM tbl_end_category WHERE ecat_name=?");
$statement->execute(array($_REQUEST['endcat']));
$end_category = $statement->fetchColumn();


$queryProduct = "
  
INSERT INTO `product` 
(`product_name`, `product_price`, `product_qty`, `product_featured_photo`, `product_description`, `product_slogan`, `product_total_view`, `product_is_featured`, `product_is_active`, `ecat_id`, `product_seller_id`, `product_total_sells`)
 VALUES
(?,?,?,?,?,?,?,?,?,?,?,?)
";

$queryArray = array($productName,$productPrice,$productQty,"default.jpeg",$productDesc,$productslogan,0,$isProductFeatured,1,$end_category,$sellerId,0);
$statement = $pdo->prepare($queryProduct);
$statement->execute($queryArray);

$lastGeneratedId = $pdo->lastInsertId();


$options = json_decode($_REQUEST['jsondata']);

foreach ($options as $option){
  foreach ($option as $option_name => $values){

    $optionId = addoption($option_name);

    foreach ($values as $value) {

      addValue($value->value_name,$value->value_price,$optionId);
    
  }

}
}

function addOption($option){
  global $pdo;
  $statement = $pdo->prepare("SELECT option_id FROM options WHERE option_name = ?");
  $statement->execute(array($option));
  $result = $statement->fetchColumn();
  if($result){
    return $result;
  }else{
    $statement = $pdo->prepare("INSERT INTO `options` (`option_name`,`is_unified`) VALUES (?,'0') ");
    $statement->execute(array($option));
    return $pdo->lastInsertId();
  }
}

function addValue($valueName,$valuePrice,$optionId){

  global $pdo,$lastGeneratedId;

  $statement = $pdo->prepare("SELECT MAX(value_id) FROM `option_values` WHERE option_values_id = ? ");
  $statement->execute(array($optionId));
  $result = $statement->fetchColumn();

  var_dump($result);

  if($result != 0){

    $result = (int)$result;
    $result = $result + 1;

    $statement = $pdo->prepare("INSERT INTO `option_values` (`option_values_id`,`value_id`,`value_name`,`option_added_price`) VALUES (?,?,?,?)");
    $statement->execute(array($optionId,$result,$valueName,$valuePrice));


  }else{

    $result = 1;
    echo "condition is false:" . $result . '\n' ;
    $statement = $pdo->prepare("INSERT INTO `option_values` (`option_values_id`,`value_id`,`value_name`,`option_added_price`) VALUES (?,?,?,?)");
    $statement->execute(array($optionId,$result,$valueName,$valuePrice));

  }


  $statement = $pdo->prepare("INSERT INTO `product_options` (`product_option_values_id`,`option_id`,`option_value`,`is_unified`) VALUES (?,?,?,?)");
  $statement->execute(array($lastGeneratedId,$optionId,$result,'0'));


}


function reArrayFiles(&$file_post)
{

  $file_ary = array();
  $file_count = count($file_post['name']);
  $file_keys = array_keys($file_post);

  for ($i = 0; $i < $file_count; $i++) {
    foreach ($file_keys as $key) {
      $file_ary[$i][$key] = $file_post[$key][$i];
    }
  }

  return $file_ary;
}


require_once("../assets/bulletproof-master/bulletproof.php");
require "../assets/bulletproof-master/utils/func.image-resize.php";
$count = 0;

if (isset($_FILES['files'])) {
  $__files =  reArrayFiles($_FILES['files']);

  foreach ($__files as $key => $file) { //get upload name: $key
    $count++;
    $imageName = "product_" . $lastGeneratedId ."_desc_" . "photo_" . $count;
    $image = new Bulletproof\Image($file);
    $image->setName($imageName);
    $image->setLocation('../assets/uploads/product_photos');  
    if ($image->upload()) {           //upload succeed?
      bulletproof\utils\resize(     //you are still playing with $image
        $image->getFullPath(),
        $image->getMime(),
        $image->getWidth(),
        $image->getHeight(),
        190,
        175
      );
      $imageType = $image->getMime();
      $statement = $pdo->prepare("INSERT INTO `images_table` (`p_id`, `images`) VALUES (?, ?)");
      $statement->execute(array($lastGeneratedId,$imageName.".". $imageType));


      echo "SUCCES";
    } else {
      ob_clean();
      echo "The picture you choosed aren't allowed default pictures have been added";

      $statement = $pdo->prepare("INSERT INTO `images_table` (`p_id`, `images`) VALUES (?, ?)");
      $statement->execute(array($lastGeneratedId,"default.jpeg"));
    }
  }
}

if (isset($_FILES["fileso"])) {
  $imageName = "product_" . $lastGeneratedId . "_principale_photo";
  $image = new Bulletproof\Image($_FILES["fileso"]);
  $image->setName($imageName);
  $image->setLocation('../assets/uploads/product_photos');

  if ($image->upload()) {           //upload succeed?
    bulletproof\utils\resize(     //you are still playing with $image
      $image->getFullPath(),
      $image->getMime(),
      $image->getWidth(),
      $image->getHeight(),
      190,
      175
    );
    $imageType = $image->getMime();
    $statement = $pdo->prepare("UPDATE `product` SET product_featured_photo = ? where product_id = ?");
    $statement->execute(array($imageName .".". $imageType ,$lastGeneratedId));

    echo "SUCCES";
  } else {
    ob_clean();
    echo "The picture you choosed aren't allowed default pictures have been added";

    $statement = $pdo->prepare("INSERT INTO `images_table` (`p_id`, `images`) VALUES (?, ?)");
    $statement->execute(array($lastGeneratedId,"default.jpeg"));
  }
}
