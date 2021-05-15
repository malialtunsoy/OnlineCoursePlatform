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

        

if($userType == 'User' || $userType == 'Instructor' ){ //user or instructor

    

    if(strtolower($ownsData['username']) != $username && $username != $courseData['username']){ //user not own or instructor not own

        
    
        $htmlContainer = '<!DOCTYPE html>
        <html>
            <head>
                <title>Course Page</title>
                <link rel="stylesheet" type="text/css" href="style.css" />
                <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
                <script defer src="all.js"></script>
                <script defer src="searchBar.js"></script>
                <script defer src="buyCourse.js"></script>
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
                    <a id="profile" href="user?id=' . $username . '"><i class="fas fa-user"></i>' . $username . ' </a>';
                    if($userType == "User"){
                        $query = "	SELECT balance
                        FROM user
                        WHERE LOWER(username) = '$username'";
                            
                        $balance = $database->query($query) or die('Error in the query: ' . $database->error);
                        $balance = $balance->fetch_assoc();
                        $balance = $balance['balance'];

                        $htmlContainer .='<a id="balance" disabled>Balance: $' . $balance . '</a>';
                    }
                    $htmlContainer .='
                    <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
                </div>
                <div class="container">
                    <div class="courseContainer">
                        <div class="leftCourseContainer">
                            
                            <iframe class="courseVideo" width="560" height="315" src="https://www.youtube.com/embed/' . $courseData['video_url'] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <h3>Course Description</h3>
                            <p>' . $courseData['course_desc'] . '</p>
                        </div>
                        <div class="rightCourseContainer">
                            <h1>' . $courseData['course_name'] . '</h1>
                            <h4><a href="user?id=' . $courseData['username'] . '">' . $courseData['username'] . '</a></h4>
                            <p>' . $courseData['lecture_count'] . ' Lectures</p>';
                            for($i = 0; $i < 4; $i++){
                                if($i < $courseData['rating']){
                                    $htmlContainer .= '<span class="fa fa-star checked"></span>';
                                }
                                else{
                                    $htmlContainer .= '<span class="fa fa-star"></span>';
                                }
                            }
                            $htmlContainer .= '<h4 id="price">$' . $courseData['course_fee'] . '</h4>
                            <button id="buyButton" class="btn btn-success">Buy</button>
                            ';
                        $query = "	SELECT username
                                    FROM wishes
                                    WHERE LOWER(username) = '$username' AND course_id = '$courseID'";
                            
                        $wish = $database->query($query) or die('Error in the query: ' . $database->error);
                        $wish = $wish->fetch_assoc()['username'];
                        if($wish == $username){
                            $htmlContainer .= '<button id="wishButton" class="btn btn-danger">Remove from Wishlist</button>';
                        }
                        else{
                            $htmlContainer .= '<button id="wishButton" class="btn btn-warning">Add to Wishlist</button>';
                        }
                        
                    $htmlContainer .= '
                            
                        </div>
                        
                    </div>
                </div>
                
            </body>
        </html>';
        echo $htmlContainer;
    }
    else{  //own
    
        $query = "	SELECT course_id, course_name, course_desc, course_fee, username, rating, video_url, lecture_count
        FROM course NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
        NATURAL JOIN (SELECT course_id, video_url FROM lecture WHERE lecture_index = 1) AS sub2
        NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count FROM lecture GROUP BY
        course_id) AS sub3
        WHERE course_id = '$courseID'";
    
        $course = $database->query($query) or die('Error in query: ' . $database->error);
        $courseData = $course->fetch_assoc();
    
        
        $htmlContainer = '<!DOCTYPE html>
        <html>
            <head>
                <title>Course Page</title>
                <link rel="stylesheet" type="text/css" href="style.css" />
                <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
                <script defer src="all.js"></script>
                <script defer src="searchBar.js"></script>
                <script defer src="script.js"></script>
                <script defer src="refundRequest.js"></script>
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
                    <a id="profile" href="user?id=' . $username . '"><i class="fas fa-user"></i>' . $username . ' </a>';
                    if($userType == "User"){
                        $query = "	SELECT balance
                        FROM user
                        WHERE LOWER(username) = '$username'";
                            
                        $balance = $database->query($query) or die('Error in the query: ' . $database->error);
                        $balance = $balance->fetch_assoc();
                        $balance = $balance['balance'];

                        $htmlContainer .='<a id="balance" disabled>Balance: $' . $balance . '</a>';
                    }
                    $htmlContainer .='
                    <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
                </div>
                <div class="container">
                    <div class="courseContainer">
                        <div class="leftCourseContainer">
                            
                            <iframe class="courseVideo" width="560" height="315" src="https://www.youtube.com/embed/' . $courseData['video_url'] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        
                            <h1>Announcements</h1>
                            <div class="announcementContainer">';
    
                            $query = "	SELECT title, announcement, timestamp
                            FROM announces
                            WHERE course_id = '$courseID'";
    
                            $announcements = $database->query($query) or die('Error in query: ' . $database->error);
    
                            while ($announcement = $announcements->fetch_assoc()){ 
                                $htmlContainer .= '<div class="announcement">
                                <h3>' . $announcement['title'] . '</h3>
                                <p><strong>Date: ' . $announcement['timestamp'] . '</strong></p>
                                <p>' . $announcement['announcement'] . '</p>
                            </div>';
                            }
    
                            $htmlContainer .= '
                            </div>
                            
                            
                        </div>
                        <div class="rightCourseContainer">
                            <h1>' . $courseData['course_name'] . '</h1>
                            <h4><a href="user?id=' . $courseData['username'] . '">' . $courseData['username'] . '</a></h4>
                            <p>' . $courseData['lecture_count'] . ' Lectures</p>
                            ';
                            for($i = 0; $i < 4; $i++){
                                if($i < $courseData['rating']){
                                    $htmlContainer .= '<span class="fa fa-star checked"></span>';
                                }
                                else{
                                    $htmlContainer .= '<span class="fa fa-star"></span>';
                                }
                            }
                            $htmlContainer .= '
                            <p></p>
                            ';

                            if($username == $courseData['username']){//course creator
                                $htmlContainer .= '<button class="btn btn-warning"><a style="text-decoration: none; color: white;" href="courseEdit?courseID=' . $courseData['course_id'] .'">Edit Course</a></button>
                                <p></p>
                                <a href="QandA?courseID=' . $courseData['course_id'] . '"><button class="btn btn-info">Go to Q&A Page</button></a>';     
                            }
                            else{//user
                                $htmlContainer .= '<button id="openModalBox" class="btn btn-danger">Refund Course</button>
                                <p></p>
                                <a href="QandA?courseID=' . $courseData['course_id'] . '"><button class="btn btn-info">Go to Q&A Page</button></a>';
                            }

                            $htmlContainer .= '
                            
                            <div class="lectureContainer">
                                <h3>Lectures</h3>';
    
                                $query = "	SELECT lecture_id, lecture_name, lecture_index, video_url, lecture_description
                                FROM lecture
                                WHERE course_id = '$courseID'";
    
                                $lectures = $database->query($query) or die('Error in query: ' . $database->error);
    
                                while ($lecture = $lectures->fetch_assoc()){ 
                                    $htmlContainer .= '<div class="lectureCard">
                                    <img src="https://img.youtube.com/vi/' . $lecture['video_url'] . '/maxresdefault.jpg">
                                    <h5><a href="lecture?lectureID=' . $lecture['lecture_id'] . '">Lecture ' . $lecture['lecture_index'] . ': ' . $lecture['lecture_name'] . '</a></h5>
                                </div>';
                                }
    
                                $htmlContainer .= '    
                                
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modalbox" id="refundModelBox">
                    <div id="refundModelContent" class="modalcontent">
                        <div id="close">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                        <h1>Refund Request</h1>
                        <form>
                            <div class="form-row">
                                <label>Title</label>
                            <input id="title" placeholder="Title">
                            </div>                      
                            <div class="form-row">
                                <label>Refund Reason</label>
                                <textarea id="refundReason"></textarea>
                            </div>
                            
                        </form>
                        <button class="btn btn-warning" id="modalreg">Request</button>
                    </div>
                </div>  
                
            </body>
        </html>';
        echo $htmlContainer;
    }
}
elseif($userType == 'Admin'){ //admin
    $htmlContainer = '<!DOCTYPE html>
        <html>
            <head>
                <title>Course Page</title>
                <link rel="stylesheet" type="text/css" href="style.css" />
                <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
                <script defer src="all.js"></script>
                <script defer src="searchBar.js"></script>
                <script defer src="discount.js"></script>
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
            <a id="profile" href="user?id=' . $username . '"><i class="fas fa-user"></i>' . $username . ' </a>
            <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
        </div>
                <div class="container">
                    <div class="courseContainer">
                        <div class="leftCourseContainer">
                            
                            <iframe class="courseVideo" width="560" height="315" src="https://www.youtube.com/embed/' . $courseData['video_url'] . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <h3>Course Description</h3>
                            <p>' . $courseData['course_desc'] . '</p>
                        </div>
                        <div class="rightCourseContainer">
                            <h1>' . $courseData['course_name'] . '</h1>
                            <h4><a id="creatorUsername" href="user?id=' . $courseData['username'] . '">' . $courseData['username'] . '</a></h4>
                            <p>' . $courseData['lecture_count'] . ' Lectures</p>';
                            for($i = 0; $i < 4; $i++){
                                if($i < $courseData['rating']){
                                    $htmlContainer .= '<span class="fa fa-star checked"></span>';
                                }
                                else{
                                    $htmlContainer .= '<span class="fa fa-star"></span>';
                                }
                            }
                            $htmlContainer .= '<h4 id="price">$' . $courseData['course_fee'] . '</h4>';
                            
                            $query = "	SELECT discount_allow
                                        FROM course
                                        WHERE course_id = '$courseID'";
    
                                $discount = $database->query($query) or die('Error in query: ' . $database->error);
                                $discount = $discount->fetch_assoc();
                                $discount = $discount['discount_allow'];
                                if($discount){
                                    $htmlContainer .='<div style="display: flex"><form class="form-inline">
                                    <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
                                    <div class="input-group mb-2 mr-sm-2">
                                      <div class="input-group-prepend">
                                        <div class="input-group-text">$</div>
                                      </div>
                                      <input id="discountAmount" type="number" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Discount">
                                    </div>                                   
                                  </form>
                                  <button id="discountButton" type="submit" class="btn btn-primary mb-2">Offer</button></div>';
                                  
                                }

                            $htmlContainer .='
                            
                        </div>
                        
                    </div>
                </div>
                
            </body>
        </html>';
        echo $htmlContainer;
}





?>

