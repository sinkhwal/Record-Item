<?php
include_once '../../Actions/ItemAction.php';

$funObj = new ItemAction();
$ItemId = '';
if (isset($_GET['id'])) {
    $ItemId = $_GET['id'];
}
$item = $funObj->DeleteItem($ItemId);
header("location:itemListing.php");