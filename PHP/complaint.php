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

$query = "	SELECT username FROM owns
WHERE username = '$username' and course_id = '$courseID' ";

$owns = $database->query($query) or die('Error in query: ' . $database->error);
$ownsData = $owns->fetch_assoc();

$userType = $_SESSION['userType'];

$query = "	SELECT course_name, course_desc, course_fee, username, rating, video_url, lecture_count
        FROM course NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
        NATURAL JOIN (SELECT course_id, video_url FROM lecture WHERE lecture_index = 1) AS sub2
        NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count FROM lecture GROUP BY
        course_id) AS sub3
        WHERE course_id = '$courseID'";
    
        $course = $database->query($query) or die('Error in query: ' . $database->error);
        $courseData = $course->fetch_assoc();

if($userType == 'Admin'){//admin
    $htmlContainer = '<!DOCTYPE html>
    <html>
        <head>
            <title>Complaint Admin Page</title>
            <link rel="stylesheet" type="text/css" href="style.css" />
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <script defer src="all.js"></script>
            <script defer src="script.js"></script>
            <script defer src="searchBar.js"></script>
            <script defer src="complaint.js"></script>
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
                    <h1>User Complaints</h1>

                    ';
    
                            $query = "SELECT *
                            FROM complaint";
    
                            $complaints = $database->query($query) or die('Error in query: ' . $database->error);
    
                            while($complaint = $complaints->fetch_assoc()){
                                if($complaint['answer'] == NULL){

                                $curCourseID = $complaint['course_id'];
                                $query = "SELECT course_name, course_fee
                                FROM course
                                WHERE course_id =  '$curCourseID'";
        
                                $course = $database->query($query) or die('Error in query: ' . $database->error);
                                $course = $course->fetch_assoc();
                                $newFee = $course['course_fee'] - $offer['discount_amount'];
                                $htmlContainer .= '
                                
                                <div class="complaint">
                                    <h2>' . $complaint['title'] . '</h2>
                                    <h5>User: <a href="user?id=' . $complaint['user_username'] . '">' . $complaint['user_username'] . '</a></h5>
                                    <h5>Course: <a href="course?courseID=' . $complaint['course_id'] . '">' . $course['course_name'] . '</a></h5>
                                    <p>' . $complaint['reason'] . '</p>
                                    <h5>Answer</h5>
                                    <textarea id="' . $complaint['user_username'] . '-' . $complaint['course_id'] . '-' . $complaint['title'] . '" class="complaintTextArea"></textarea>
                                    <button id="' . $complaint['user_username'] . '-' . $complaint['course_id'] . '-' . $complaint['title'] . '" class="btn btn-danger solveButton">Solve Complaint</button>
                                </div>';
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
    $htmlContainer = '<!DOCTYPE html>
    <html>
        <head>
            <title>Complaint User Page</title>
            <link rel="stylesheet" type="text/css" href="style.css" />
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <script defer src="all.js"></script>
            <script defer src="script.js"></script>
            <script defer src="sendticket.js"></script>
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
                <a id="profile" href="user?id=' . $username . '"><i class="fas fa-user"></i>' . $username . '</a>
                <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
            </div>
            <div class="container">
                <div class="complaintPageContainer">
                    <h1>Send Ticket</h1>
                    <form>
                      <div class="form-group">
                        <label for="exampleFormControlInput1">Title</label>
                        <input id="title" type="email" class="form-control" id="exampleFormControlInput1" placeholder="Title">
                      </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Select Course</label>
                        <select id="selectedCourse" class="form-control" id="exampleFormControlSelect1">';

                        if($userType == 'User'){
                            $query = "	SELECT DISTINCT course_id, course_fee, course_name,lecture_count, username, rating, video_url
                            FROM course NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
                            NATURAL JOIN (SELECT course_id, video_url FROM lecture WHERE lecture_index = 1) AS sub2
                            NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count FROM lecture GROUP BY
                            course_id) AS sub3
                            WHERE course_id IN (SELECT course_id FROM owns WHERE username = '$username')";

                            $response = $database->query($query) or die('Error in query: ' . $database->error);
                            while ($course = $response->fetch_assoc()){ 
                                $htmlContainer .= '<option>' . $course['course_id'] . '-' . $course['course_name'] . '</option>';
                            }
                        }
                        else{
                            $query = "	SELECT DISTINCT course_id, course_fee, course_name,lecture_count, username, rating, video_url
                            FROM course NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
                            NATURAL JOIN (SELECT course_id, video_url FROM lecture WHERE lecture_index = 1) AS sub2
                            NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count FROM lecture GROUP BY
                            course_id) AS sub3
                            WHERE course_id IN (SELECT course_id FROM course WHERE username = '$username')";

                            $response = $database->query($query) or die('Error in query: ' . $database->error);
                            while ($course = $response->fetch_assoc()){ 
                                $htmlContainer .= '<option>' . $course['course_id'] . '-' . $course['course_name'] . '</option>';
                            }
                        }
                        $htmlContainer .= '</select>
                      </div>
                      <div class="form-group">
                        <label for="exampleFormControlTextarea1">Complaint Reason</label>
                        <textarea id="complaintReason" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                      </div>
                      <button id="sendTicket" class="btn btn-warning">Send</button>
                    </form>
                        
                        
                        
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
?>

