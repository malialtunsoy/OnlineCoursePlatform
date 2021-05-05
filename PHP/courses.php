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

$query = "	SELECT course_id, course_name, course_fee, username, rating, video_url, lecture_count
            FROM (course 
            NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
            NATURAL JOIN (SELECT course_id, video_url 
                          FROM lecture 
                          WHERE lecture_index = 1) AS sub2
            NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count 
                          FROM lecture 
                          GROUP BY course_id) AS sub3)";

$response = $database->query($query) or die('Error in query: ' . $database->error);


?>

<!DOCTYPE html>
<html>
	<head>
		<title>Courses Page</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script defer src="all.js"></script>
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
	        <a id="profile" href="user?id=<?php echo $username; ?>"><i class="fas fa-user"></i><?php echo $username; ?></a>
	        <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
    	</div>
    	<div class="container">
    		<h1>Courses</h1>
            
    		<div class="coursesContainer">

                <?php 
                $htmlContainer = '';
                while ($course = $response->fetch_assoc()){ 
                    
                    $htmlContainer .= '<div class="courseCard">
                        <div class="videoImage">
                            <img src="https://img.youtube.com/vi/' . $course['video_url'] . '/maxresdefault.jpg">
                        </div>
                        <div class="courseDetails">
                            <h2><a href="course?courseID=' . $course['course_id'] . '">' . $course['course_name'] . ' - ' . $course['lecture_count'] . ' Lectures</a></h2>
                            <h4>' . $course['username'] . '</h4>';

                            for($i = 0; $i < 4; $i++){
                                if($i < $course['rating']){
                                    $htmlContainer .= '<span class="fa fa-star checked"></span>';
                                }
                                else{
                                    $htmlContainer .= '<span class="fa fa-star"></span>';
                                }
                            }
                             $htmlContainer .= '<h5>$' . $course['course_fee'] . '</h5>
                        </div>
                    </div>';



                } 
                
                echo $htmlContainer;
                ?>
    		</div>
    	</div>
    	
	</body>
</html>