<?php
require_once("../config/config.php");
require_once("../userinterface/authentfication.php");
if($isOnline){
if (isset($_REQUEST['reportText']) && isset($_REQUEST['itemType'])) {
    $reptext = htmlentities($_REQUEST['reportText']);
    $profileId = $_SESSION["prod_id"];
    $itemType = $_REQUEST['itemType'];
    $statement = $pdo->prepare("INSERT INTO `reports` (`reported_item_id`, `reported_item_type`, `report_content`, `reporte_date`, `report_is_seen`, `reporter_id`) VALUES ( ?, ?, ?, ?, ?, ?)");
    $statement->execute(array($profileId, $itemType, $reptext, date('Y-m-d H:i:s'), 0, $_SESSION['customer']['client_id']));

    echo "YUP REPORTED";
}

if (isset($_REQUEST['followedProfile'])) {
    $followedProfileId = $_REQUEST['followedProfile'];
    $followerProfileId = $_SESSION['customer']['client_id'];

    $statement = $pdo->prepare("SELECT count(*) FROM followers WHERE followed_id = ? AND following_id = ?; ");
    $statement->execute(array($followedProfileId, $followerProfileId));
    $count = $statement->fetchColumn();
    if ($count == 0) {
        $statement = $pdo->prepare("INSERT INTO `followers` (`followed_id`, `following_id`) VALUES (?, ?) ");
        $statement->execute(array($followedProfileId, $followerProfileId));
        echo "followed";

    }else{
        $followedProfileId = $_REQUEST['followedProfile'];
        $followerProfileId = $_SESSION['customer']['client_id'];
        $statement = $pdo->prepare("DELETE FROM `followers` WHERE followed_id = ? AND following_id = ? ");
        $statement->execute(array($followedProfileId, $followerProfileId));
        echo "unfollowed";

    }
    
}
}else{
    echo "You should be en-ligne to report someone";
}