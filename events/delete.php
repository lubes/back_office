<?php session_start();
if(!isset($_SESSION['valid'])) {
	header('Location: index.php');
}
$brand_id = $_GET['id'];
include("../connection.php");
    delete_event();
?>

