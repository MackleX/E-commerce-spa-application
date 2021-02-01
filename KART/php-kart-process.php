
<?php
include_once('../config/config.php');
require_once('../userinterface/authentfication.php');


if (isset($_REQUEST['jsonObject'])) {

    if($isOnline){
    $data = json_decode($_REQUEST['jsonObject']);

    $addedPrice = 0;
    $selectedOptions;
    $productQty;
    $priceRows = array(0);
    foreach($data as $element){
        if(isset($element->p_id)){
            $product_id = $element->p_id;
        } 
    }
    
    foreach ($data as $object) {

        foreach ($object as $key => $value) {

            if($key != "buyProduct" && $key != "qty" && $key != "p_id"){
            $statement = $pdo->prepare("SELECT option_added_price from product INNER JOIN product_options on product.product_id = product_options.product_option_values_id INNER JOIN option_values ON option_values.option_values_id = product_options.option_id AND option_values.value_id = product_options.option_value where product_id = ? and value_name = ? ");
            $statement->execute(array($product_id, $value));
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                $priceRows[] = $result;
                $selectedOptions[$key] = $value . " for " . $result['option_added_price'] . " Dh more." ;
            }


            }

            if ($key == "qty") {
                $productQty = $value;
            }


        }
    }

    foreach ($priceRows as $row) {

        $addedPrice += $row['option_added_price'];
    }


    $statement = $pdo->prepare("SELECT * from product  where product_id = ?");
    $statement->execute(array($product_id));
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $addedPrice = ($addedPrice + $result['product_price']) * $productQty;
    

    if(!isset($selectedOptions)){ $selectedOptions = array("product have" =>"no option");}

    $productRow = array_merge(array("product_id" => $result['product_id']),array("product_name" => $result['product_name']), array("product_photo" => $result["product_featured_photo"]), array("options" => $selectedOptions), array("quantity" => $productQty),array("seller_id" => $result["product_seller_id"]), array("totalprice" => $addedPrice));

    if (($data[0]->buyProduct) == false) {

        if (!isset($_SESSION["cart_items"])) {

            $_SESSION["cart_items"] = array($productRow);

        } else {
            $_SESSION["cart_items"][] = $productRow;
           
        }

        $_SESSION["items_to_buy"] = $_SESSION["cart_items"];

        ob_end_clean();
        $result = "itemAdded";
        echo $result;

    }elseif(($data[0]->buyProduct) == true){

        if (!isset($_SESSION["current_buy_product"])) {

            $_SESSION["current_buy_product"] = array($productRow);
           
        } else {

            $_SESSION["current_buy_product"] = array($productRow);
        }

        $_SESSION["items_to_buy"] = $_SESSION["current_buy_product"];
     
        $cartRequest = false;
        require_once("../payment/payment-modal.php");

    }

}else{
    ob_end_clean();
    $result = "userIsOffline";
    echo $result;

}
}


?>