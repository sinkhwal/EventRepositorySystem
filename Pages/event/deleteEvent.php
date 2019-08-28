<?php
include_once '../../Actions/ItemAction.php';

$funObj = new ItemAction();
$eventId = '';
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
}
$eventId = $funObj->DeleteEvent($eventId);
header("location:eventListing.php");