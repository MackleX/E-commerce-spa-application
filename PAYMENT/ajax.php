<?php
require_once("../config/config.php");
require_once("../USERINTERFACE/authentfication.php");
?>



<?php
// This is the line to load Stripe PHP bindings with composer.
// If you want more details or use the manual installation
// refer to this page https://github.com/stripe/stripe-php#composer
require_once('../assets/STRIPE/init.php');

// Put your secret API key here. It can be found
// at https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey('sk_test_51IGPGkIZi3lujjoDcd5KHBGL9b2Yy5yahOxOr3XlRAq5I8h7O7Jue4gwIYbO2l1y3FmT7COIJk9u0ALqdZGlpnDk00yxriQOIe');

$token = $_POST['stripeToken'];
$email = $_POST['stripeEmail'];
session_start();
$totalPrice = $_SESSION["totalBill"] * 10;
try {

  $charge = \Stripe\Charge::create(array(
    "amount" => $totalPrice,
    "currency" => "usd",
    "source" => $token,
    "description" => "Charge for " . $email



  ));
  parchauseCompleteHandler();
  ob_clean();
  print('Charge successful!<br>');
  print('Your transaction is made stay tuned to recive your products, check payment details on your profile to know your product state.');
 
} catch (\Stripe\Error\Card $e) {
  // The card can't be charged for some reason
  printError("Cant make transaction from the card check if your card contain suffisante money");
} catch (\Stripe\Error\RateLimit $e) {
  // Too many requests made to the API too quickly
  printError("Server is busy try another time");
} catch (\Stripe\Error\InvalidRequest $e) {
  // Invalid parameters were supplied to Stripe's API
  printError("Wrong informations");
} catch (\Stripe\Error\Authentication $e) {
  // Authentication with Stripe's API failed
  // (maybe you changed API keys recently)
  printError("Server Side probleme");
} catch (\Stripe\Error\ApiConnection $e) {
  // Network communication with Stripe failed
  printError("Check your internet");
} catch (\Stripe\Error\Base $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
  printError("Please contact support");
}

// Helper function to display errors back in the html page
function printError($error)
{

  print($error);
}



function parchauseCompleteHandler()
{
  global $totalPrice;
  global $pdo;

  $statement = $pdo->prepare("INSERT INTO `payment` (`id`, `customer_id`, `customer_name`, `customer_email`, `payment_date`, `bank_transaction_info`, `payment_method`, `payment_status`, `total_amount_paid`) VALUES (NULL, ?, ?, ?, ?, ?, 'Visa card', 'completed', ?);");
  $statement->execute(array($_SESSION['customer']['client_id'], $_SESSION['customer']['client_name'], $_SESSION['customer']['client_email'], date("Y/m/d"), "random info", $totalPrice / 10));



  $last_id = $pdo->lastInsertId();

  $adresseString = "Adresse: " . $_SESSION['customer']['client_s_address'] . ". City: " .  $_SESSION['customer']['client_s_city'] . ". zip-postale: " . $_SESSION['customer']['client_s_zip'];

  foreach ($_SESSION["items_to_buy"] as $productRow) {
    $optionString = "";
    foreach ($productRow['options'] as $optionName => $optionValue) {
      $optionString .= $optionName . ": " . $optionValue . "<br />";
    }


    $statement = $pdo->prepare("INSERT INTO `payment_details` (`payment_id`, `product_name`, `product_buyed_quantity`, `product_chosen_options`, `product_total_price`, `product_shipping_status`,`Shipping adresse`,`seller_id`) VALUES (?, ?, ?, ?, ?, 'on traitemant',?,? );");
    $statement->execute(array($last_id, $productRow['product_name'], $productRow['quantity'], $optionString, $productRow['totalprice'],$adresseString,$productRow['seller_id']));
    
    
    $statement = $pdo->prepare("UPDATE product SET product_total_sells = product_total_sells + ? where product_id = ?; UPDATE product SET product_qty = product_qty - ?  where product_id = ? ;");
    $statement->execute(array($productRow['quantity'],$productRow['product_id'],$productRow['quantity'],$productRow['product_id']));





}

}


$_SESSION["items_to_buy"] = null;
$_SESSION["totalBill"] = null;
$_SESSION["cart_items"] = null;

?>