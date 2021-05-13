<?php
include("config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //SIGN UP
    if($_POST['method'] == "signup" ){

    }
    //SHARE POST
    if($_POST['method'] == "share" ){
      $title = $_POST['title'];
      $post = $_POST['post'];
      $username = $_SESSION['username'];
      
      $addQuery = "INSERT INTO posts VALUES ('$username','$title', '$post', CURRENT_TIMESTAMP);";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }
    //SEND TICKET
    if($_POST['method'] == "ticket" ){
      $title = $_POST['title'];
      $course = $_POST['course'];
      $reason = $_POST['reason'];
      $username = $_SESSION['username'];

      $addQuery = "INSERT INTO complaint VALUES ('$username', NULL , $course, '$title', '$reason', NULL);";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }
    //REFUND COURSE
    if($_POST['method'] == "refund" ){
      $title = $_POST['title'];
      $courseID = $_POST['course'];
      $reason = $_POST['reason'];
      $username = $_SESSION['username'];
      $active = "ACTIVE";

      $addQuery = "INSERT INTO requestrefund VALUES ('$username', $courseID, '$title', '$reason', '$active');";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }
    //ASK A QUESTION
    if($_POST['method'] == "ask" ){
      $title = $_POST['title'];
      $courseID = $_POST['course'];
      $question = $_POST['question'];
      $username = $_SESSION['username'];
      $active = "ACTIVE";

      $addQuery = "INSERT INTO question VALUES ($courseID , '$username', '$title', '$question', NULL , CURRENT_TIMESTAMP  ,NULL);";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }
    //BUY COURSE
    if($_POST['method'] == "buy" ){
      $fee = $_POST['fee'];
      $balance = $_POST['balance'];
      $courseID = $_POST['course'];
      $username = $_SESSION['username'];
      $active = "ACTIVE";

      //INSERT OWN
      $addQuery = "INSERT INTO owns VALUES ('$username', $courseID);";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);

      $lectureID = $courseID*10000 + 1;
      $addQuery = "INSERT INTO watched VALUES ('$username', $lectureID);";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      //UPDATE BALANCE
      $addQuery = "UPDATE user SET balance = balance - '$fee' WHERE username = '$username';";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }
    //RATE COURSE
    if($_POST['method'] == "rate" ){

    }
    //FOLLOW USER

    //ADD NOTE

    //WATCH LECTURE

    
}


?>