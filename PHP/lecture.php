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
$lectureID = $_GET['lectureID'];
$one = 1;
$thousand = 10000;

$query = "	SELECT course_id FROM lecture
WHERE lecture_id = '$lectureID'";

$course = $database->query($query) or die('Error in query: ' . $database->error);
$courseData = $course->fetch_assoc();
$courseID = $courseData['course_id'];


$query = "	SELECT username FROM owns
WHERE username = '$username' and course_id = '$courseID' ";

$owns = $database->query($query) or die('Error in query: ' . $database->error);
$ownsData = $owns->fetch_assoc();

if(strtolower($ownsData['username']) == $username){

    $query = "	SELECT lecture_id, lecture_name, lecture_description, lecture_index, video_url
    FROM lecture
    WHERE lecture_id = '$lectureID'    ";

    $thisLecture = $database->query($query) or die('Error in query: ' . $database->error);
    $thisLectureData = $thisLecture->fetch_assoc();

    $query = "	SELECT COUNT(lecture_id) AS lectureCount
    FROM lecture
    WHERE course_id = '$courseID'    ";

    $lectureCount = $database->query($query) or die('Error in query: ' . $database->error);    
    $lectureCount = $lectureCount->fetch_assoc()['lectureCount'];

    $query = "	SELECT note
    FROM notes
    WHERE lecture_id = '$lectureID' AND username = '$username'";

    $note = $database->query($query) or die('Error in query: ' . $database->error);    
    $note = $note->fetch_assoc()['note'];

    $htmlContainer = '
<!DOCTYPE html>
<html>
	<head>
		<title>Lecture Page</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script defer src="all.js"></script>
        <script defer src="lecture.js"></script>
        <script defer src="searchBar.js"></script>
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
                <div id="searchbar">
                <input id="searchbarInput" class="search" type="text" name="">
                <button type="submit" class="searchButton" name="Search">
                    <i class="fas fa-search"></i>
                </button>
            </div>
                <a id="profile" href="user?id=' . $username . '"><i class="fas fa-user"></i>Profile</a>
                <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
            </div>
    	<div class="container">
    		<div class="lecturePageContainer">
    				<div class="lectureHeader">
    					<h1>' . $thisLectureData['lecture_name'] . '</h1>
    					<a href="QandA?courseID=' . $courseData['course_id'] . '"><button class="btn btn-info">Go to Q&A Page</button></a>
    					</button>
    				</div>
    				
    				<iframe class="courseVideo" width="100%" height="600" src="https://www.youtube.com/embed/' . $thisLectureData['video_url'] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    				<div class="lectureBottom">
    					<div class="leftBottom">
    						<h2>Lecture ' . $thisLectureData['lecture_index'] . ': ' . $thisLectureData['lecture_name'] . '</h2>
    						<p>' . $thisLectureData['lecture_description'] . '</p>
    						<h3>My Notes:</h3>
    						<textarea id="noteText" class="lectureNotes">' . $note . '</textarea>
    						<button id="noteUpdate" class="btn btn-warning">Update</button>
    					</div>
    					<div class="rigthBottom">
                            <div class="arrows">
                                ';
                                if(((int)($thisLectureData['lecture_id'])-$one) > ((int)$courseID*$thousand)){
                                    $htmlContainer .= '<p>Previous</p><a id="prev" href="lecture?lectureID=' . ((int)($thisLectureData['lecture_id'])-$one) . '"><i class="fas fa-arrow-left"></i></a>';
                                }
                                else{
                                    $htmlContainer .= '<p>Unwatch</p><a id="prev" href=""><i class="fas fa-times"></i></a>';
                                }
                                if(((int)($thisLectureData['lecture_id'])+$one) < (((int)$courseID)*$thousand)+$lectureCount+$one){
                                    $htmlContainer .= '<a id="next" href="lecture?lectureID=' . ((int)($thisLectureData['lecture_id'])+$one) . '"><i class="fas fa-arrow-right"></i></a><p>Next</p>';
                                }
                                else{
                                    $htmlContainer .= '<a id="next" href=""><i class="fas fa-check"></i></i></a><p>Finish</p>';
                                }
                                
                                $htmlContainer .= '
                            </div>
    						
    						<div class="lectureContainer inLecturePage">

    							<h3>Lectures</h3>
    							';

                                $query = "	SELECT lecture_id, lecture_name, lecture_index, video_url, lecture_description
                                FROM lecture
                                WHERE course_id = '$courseID'";

                                $lectures = $database->query($query) or die('Error in query: ' . $database->error);

                                while ($lecture = $lectures->fetch_assoc()){ 
                                    $curID = $lecture['lecture_id'];
                                    $query = "	SELECT lecture_id
                                    FROM watched
                                    WHERE username = '$username' AND lecture_id = '$curID'";

                                    $curLecture = $database->query($query) or die('Error in query: ' . $database->error);
                                    $curLecture = $curLecture->fetch_assoc()['lecture_id'];
                                    if($curLecture == $lecture['lecture_id']){
                                        $htmlContainer .= '<div class="lectureCard done">
                                        <img src="https://img.youtube.com/vi/' . $lecture['video_url'] . '/maxresdefault.jpg">
                                        <h5><a href="lecture?lectureID=' . $lecture['lecture_id'] . '">Lecture ' . $lecture['lecture_index'] . ': ' . $lecture['lecture_name'] . '</a></h5>
                                        </div>';
                                    }
                                    else{
                                        $htmlContainer .= '<div class="lectureCard">
                                        <img src="https://img.youtube.com/vi/' . $lecture['video_url'] . '/maxresdefault.jpg">
                                        <h5><a href="lecture?lectureID=' . $lecture['lecture_id'] . '">Lecture ' . $lecture['lecture_index'] . ': ' . $lecture['lecture_name'] . '</a></h5>
                                        </div>';
                                    }

                                    
                                }

                                $htmlContainer .= '
		    				</div>
    					</div>
    				</div>
    				
    		</div>
    	</div>
    	
	</body>
</html>';
echo $htmlContainer;
}
else{
    echo "<script LANGUAGE='JavaScript'>
          window.alert('You should buy the course to watch the lectures.');
          window.location.href='course?courseID=" . $courseID .".php';
       </script>";
}




?>