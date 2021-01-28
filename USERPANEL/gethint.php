<?php
require_once("../config/config.php");
// Array with names

$a = (array) null;    
$statement = $pdo->prepare("SELECT option_name FROM options WHERE is_unified = 1");
$statement-> execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row){
$a[] = $row['option_name'];
}

// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
  $q = strtolower($q);
  $len=strlen($q);
  foreach($a as $name) {
    if (stristr($q, substr($name, 0, $len))) {
      if ($hint === "") {
        $hint = $name;
      } else {
        $hint .= ", $name";
      }
    }
  }
}

// Output "no suggestion" if no hint was found or output correct values
echo $hint === "" ? "no suggestion" : $hint;
?>