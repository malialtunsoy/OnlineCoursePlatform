<?php
include("config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //DELETE TICKET
    if($_POST['method'] == "ticket" ){
      $title = $_POST['title'];
      $course = $_POST['course'];
      $reason = $_POST['reason'];
      $username = $_SESSION['username'];

      $addQuery = "INSERT INTO complaint VALUES ('$username', NULL , $course, '$title', '$reason', NULL);";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }

}


?>