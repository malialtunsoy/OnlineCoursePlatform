<?php

include("config.php");
session_start();
//LOGIN CHECK
if(!isset($_SESSION["LOGGEDIN"]) || $_SESSION["LOGGEDIN"] !== true){
    echo "<script LANGUAGE='JavaScript'>
          window.alert('Please login');
          window.location.href='index.php';
       </script>";
    exit;
}

$username = $_SESSION['username'];
$userType = $_SESSION['userType'];


if($userType == 'Instructor'){ //instructor owns
    $htmlContainer = '<!DOCTYPE html>
    <html>
        <head>
            <title>Discount Approve Page</title>
            <link rel="stylesheet" type="text/css" href="style.css" />
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <script defer src="all.js"></script>
            <script defer src="script.js"></script>
            <script defer src="discountOffers.js"></script>
            <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
        <body>
        <div class="topnav">
            <p id=name><img class="logo" src="logo.png">  Wan-Shi</p>
            <a id="home" href="home"><i class="fas fa-home"></i>Home</a>
            <a id="courses" href="courses"><i class="fas fa-book-open"></i>Courses</a>
            <a id="complaint" href="complaint"><i class="fas fa-question-circle"></i>Support</a>
            <form id="searchbar">
                <input id="searchbarInput" type="text" name="">
                <button type="submit" name="Search">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <a id="profile" href="user?id=' . $username . '"><i class="fas fa-user"></i>' . $username . '</a>
            <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
        </div>
            <div class="container">
                <div class="complaintPageContainer">
                    <h1>Discount Offers</h1>

                    ';
    
                            $query = "SELECT *
                            FROM discountoffer
                            WHERE status = 'ACTIVE'";
    
                            $offers = $database->query($query) or die('Error in query: ' . $database->error);
    
                            while($offer = $offers->fetch_assoc()){
                                if($offer['creator_username'] == $username){
                                    $curCourseID = $offer['course_id'];
                                $query = "SELECT course_name, course_fee
                                FROM course
                                WHERE course_id =  '$curCourseID'";
        
                                $course = $database->query($query) or die('Error in query: ' . $database->error);
                                $course = $course->fetch_assoc();
                                $newFee = $course['course_fee'] - $offer['discount_amount'];
                                $htmlContainer .= '
                                <div class="complaint">
                                    <h2>Course: <a href="course?courseID=' . $offer['course_id'] . '">' . $course['course_name'] . '</a></h2>
                                    <h5>Course Price: $' . $course['course_fee'] . '</h5>
                                    <h5>Discount Offer: $' . $offer['discount_amount'] . '</h5>
                                    <h5>New Price: $' . $newFee . '</h5>
                                    <button id="' . $offer['admin_username'] . '-' . $offer['course_id'] . '-' . ($course['course_fee'] - $offer['discount_amount']) . '" class="btn btn-success approveButton">Approve</button>
                                    <button id="' . $offer['admin_username'] . '-' . $offer['course_id'] . '-' . ($course['course_fee'] - $offer['discount_amount']) . '" class="btn btn-danger declineButton">Decline</button>
                                </div>	';
                                }
                                
                            }
    
                            $htmlContainer .= '
                </div>
            </div>
            <div class="modalbox">
                <div class="modalcontent">
                    <div id="close">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                    <h1>Ask a Question</h1>
                    <form>
                        <div class="form-row">
                            <label>Title</label>
                        <input placeholder="Title">
                        </div>
                        <div class="form-row">
                            <label>Question</label>
                            <textarea id="questionInput"></textarea>
                        </div>
                        <button class="btn btn-warning" id="modalreg">Ask</button>
                    </form>
                </div>
            </div>  
        </div>
        </body>
    </html>';
    echo $htmlContainer;
}
else{
    echo "<script LANGUAGE='JavaScript'>
          window.alert('You are not an instructor.');
          window.location.href='index.php';
       </script>";
}

?>

