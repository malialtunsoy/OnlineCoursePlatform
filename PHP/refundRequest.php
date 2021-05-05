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

$userType;

$query = "	SELECT username
            FROM user
            WHERE LOWER(username) = '$username'";
    
$user = $database->query($query) or die('Error in the query: ' . $database->error);
$user = $user->fetch_assoc()['username'];

$query = "	SELECT username
            FROM coursecreator
            WHERE LOWER(username) = '$username'";
    
$creator = $database->query($query) or die('Error in the query: ' . $database->error);
$creator = $creator->fetch_assoc()['username'];

$query = "	SELECT username
            FROM siteadmin
            WHERE LOWER(username) = '$username'";
    
$admin = $database->query($query) or die('Error in the query: ' . $database->error);
$admin = $admin->fetch_assoc()['username'];

if($user == $username){$userType = 'User';}
if($creator == $username){$userType = 'Instructor';}
if($admin == $username){$userType = 'Admin';}

if($userType == 'Admin'){ //admin
    $htmlContainer = '<!DOCTYPE html>
    <html>
        <head>
            <title>Refund Admin Page</title>
            <link rel="stylesheet" type="text/css" href="style.css" />
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <script defer src="all.js"></script>
            <script defer src="script.js"></script>
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
                    <h1>Refund Requests</h1>
                    ';
    
                            $query = "SELECT *
                            FROM requestrefund
                            WHERE status = 'ACTIVE'";
    
                            $requests = $database->query($query) or die('Error in query: ' . $database->error);

                            
    
                            while($request = $requests->fetch_assoc()){
                                $curCourseID = $request['course_id'];
                                $query = "SELECT course_name
                                FROM course
                                WHERE course_id =  '$curCourseID'";
        
                                $course = $database->query($query) or die('Error in query: ' . $database->error);
                                $course = $course->fetch_assoc();

                                $htmlContainer .= '
                            <div class="complaint">
                                <h2>' . $request['title'] . '</h2>
                                <h5>User: <a href="user?id=' . $request['username'] . '">' . $request['username'] . '</a></h5>
                                <h5>Course: <a href="course?courseID=' . $request['course_id'] . '">' . $course['course_name'] . '</a></h5>
                                <p>' . $request['reason'] . '</p>
                                <button class="btn btn-success">Approve Request</button>
                                <button class="btn btn-danger">Decline Request</button>
                            </div>	';
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
else{//not admin
    echo "<script LANGUAGE='JavaScript'>
          window.alert('You dont have permission.');
          window.location.href='index.php';
       </script>";
}

?>

