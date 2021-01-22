<?php
require_once("../config/config.php");
if (session_status() == PHP_SESSION_NONE) {
session_start();
}

$isOnline = true;
if (!isset($_SESSION['customer'])) {
    $isOnline = false;
} else {
    // If client is logged in, but admin make him inactive, then force logout this user.
    $statement = $pdo->prepare("SELECT * FROM client WHERE client_id=? AND client_status=?");
    $statement->execute(array($_SESSION['customer']['client_id'], 0));
    $total = $statement->rowCount();
    if ($total) {
        $isOnline = false;

    }
}
?>