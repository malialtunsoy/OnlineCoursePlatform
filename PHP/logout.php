<?php

session_start();
//LOGIN CHECK
if(!isset($_SESSION["LOGGEDIN"]) || $_SESSION["LOGGEDIN"] !== true){
   header("location: index.php");
   exit;
}
$_SESSION = array();
session_destroy();

echo "<script LANGUAGE='JavaScript'>
          window.alert('You are logging out.');
          window.location.href='index.php';
       </script>";

exit;
?>

