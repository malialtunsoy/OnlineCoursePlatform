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
$courseID = $_GET['courseID'];

$query = "	SELECT DISTINCT course_id, course_name,lecture_count, username, rating, video_url, wathcedLectures
FROM course NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
NATURAL JOIN (SELECT course_id, video_url FROM lecture WHERE lecture_index = 1) AS sub2
NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count FROM lecture GROUP BY
course_id) AS sub3
NATURAL JOIN (SELECT course_id, COUNT(lecture_id) AS wathcedLectures 
              FROM (SELECT course_id, lecture_id 
                    FROM course NATURAL JOIN lecture 
                    WHERE lecture_id IN (SELECT lecture_id FROM watched WHERE username = '$username')) AS sub41 
              GROUP BY course_id) AS sub4
WHERE course_id = '$courseID'";

$course = $database->query($query) or die('Error in query: ' . $database->error);
$course = $course->fetch_assoc();

if($course['wathcedLectures'] == $course['lecture_count'] && $course['lecture_count'] > 0){
    $htmlContainer = '<!DOCTYPE html>
    <html>
        <head>
            <title>Certificate Page</title>
            <link rel="stylesheet" type="text/css" href="style.css" />
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <script defer src="all.js"></script>
            <script defer src="stars.js"></script>
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
                <h1>Your certificate for <a href="course?courseID=' . $course['course_id'] . '">' . $course['course_name'] . '</a></h1>
                <img id="certificateImg" src="certificate.jpg">
                <div style="display: flex; justify-content: space-between;">
                    <div><h2>Rate Course:</h2>
                        <div class="stars">
                            <button class="star" id="star1button" ><span id="star1" class="fa fa-star"></span></button>
                            <button class="star" id="star2button" ><span id="star2" class="fa fa-star"></span></button>
                            <button class="star" id="star3button" ><span id="star3" class="fa fa-star"></span></button>
                            <button class="star" id="star4button" ><span id="star4" class="fa fa-star"></span></button>
                            <button class="btn btn-warning">Rate</button>
                        </div>
                        
                    </div>
                <div>
                    <p></p>
                <button class="btn btn-primary">Share</button></div>
                </div>
                
                
                
            </div>
            
        </body>
    </html>';
    echo $htmlContainer;
 }
 else{
    echo "<script LANGUAGE='JavaScript'>
          window.alert('You should finish the course to get a certificate.');
          window.location.href='course?courseID=" . $courseID .".php';
       </script>";
 }  

?>
