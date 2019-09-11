<?php
include_once '../../Actions/UserAction.php';
if (!isset($_SESSION['email']))
{
    header("Location: login.php");
    die();
}

$funObj = new UserAction();
$userId = '';
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
}
$users = $funObj->DeleteUser($userId);
header("location:userListing.php");