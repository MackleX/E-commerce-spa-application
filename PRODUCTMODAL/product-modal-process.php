<?php
if (isset($_REQUEST['reportText']) && isset($_REQUEST['itemType'])) {
    $reptext = $_REQUEST['reportText'];
    $profileId = $_REQUEST['reportedProfileId'];
    $itemType = $_REQUEST['itemType'];
    $statement = $pdo->prepare("INSERT INTO `reports` (`reported_item_id`, `reported_item_type`, `report_content`, `reporte_date`, `report_is_seen`, `reporter_id`) VALUES ( ?, ?, ?, ?, ?, ?)");
    $statement->execute(array($profileId, $itemType, $reptext, date('Y-m-d H:i:s'), 0, $_SESSION['customer']['client_id']));

    echo "YUP REPORTED";
}
?>