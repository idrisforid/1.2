<?php require_once("Includes/DB.php");?>

<?php require_once("Includes/Functions.php");?>

<?php require_once("Includes/Sessions.php");?>

<?php 

$_SESSION["UserId"] =$Found_Account["id"];
$_SESSION["UserName"]=$Found_Account["username"];
$_SESSION["AdminName"]=$Found_Account["aname"];

session_destroy();
Redirect_to("Login.php");
 ?>