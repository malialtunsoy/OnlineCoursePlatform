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

$query = "	SELECT course_name, course_desc, course_fee, username, rating, video_url, lecture_count, discount_allow
    FROM course NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
    NATURAL JOIN (SELECT course_id, video_url FROM lecture WHERE lecture_index = 1) AS sub2
    NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count FROM lecture GROUP BY
    course_id) AS sub3
    WHERE course_id = '$courseID'";

    $course = $database->query($query) or die('Error in query: ' . $database->error);
    $courseData = $course->fetch_assoc();

    if($courseData['username'] != $username){
        echo "<script LANGUAGE='JavaScript'>
          window.alert('You cannot edit this page');
          window.location.href='course?courseID=" . $courseID . ".php';
       </script>";
    }
    else{

    $htmlContainer = '<!DOCTYPE html>
    <html>
        <head>
            <title>Course Edit Page</title>
            <link rel="stylesheet" type="text/css" href="style.css" />
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
            <script defer src="all.js"></script>
            <script defer src="courseEdit.js"></script>
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
            <div id="searchbar">
                <input id="searchbarInput" class="search" type="text" name="">
                <button type="submit" class="searchButton" name="Search">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <a id="profile" href="user?id=' . $username . '"><i class="fas fa-user"></i>' . $username . '</a>
            <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
            <a id="complaint" href="complaint"><i class="fas fa-question-circle"></i>Support</a>
        </div>
        <div class="container">
            <div class="courseEditPageContainer">
            <div class="lectureHeader">
                <h1>Course Edit: ' . $courseData['course_name'] . '</h1>
                <button id="openEditModalBox" class="btn btn-warning addNewQuestion">Edit Course Settings</button>
            </div>
                
                <div class="editions">
                    <div class="newLecture">
                        <h2>Add New Lecture</h2>
                        <form>
                            <div class="form-group">
                            <label for="exampleFormControlInput1">Lecture Name</label>
                            <input  type="text" class="form-control" id="exampleFormControlInput1"> 
                            </div>
                            <div class="form-group">
                            <label for="exampleFormControlTextarea1">Lecture Description</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                            <label for="exampleFormControlInput1">Video Url</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1"> 
                            </div>
                            
                        </form>
                        <button id="addLectureButton" type="submit" class="btn btn-primary">Add Lecture</button>
                    </div>
                    <div class="newAnn">
                        <h2>Make an Announcement</h2>
                        <form>
                            <div class="form-group">
                            <label for="exampleFormControlInput1">Title</label>
                            <input id="annTitle" type="text" class="form-control" id="exampleFormControlInput1"> 
                            </div>
                            <div class="form-group">
                            <label for="exampleFormControlTextarea1">Announcement</label>
                            <textarea id="annContent" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                            
                        </form>
                        <button id="announceButton" type="submit" class="btn btn-primary">Announce</button>
                    </div>
                </div>
                <div class="courseEditLectures">
                    <h2>Lectures</h2>';

                    $query = "	SELECT lecture_id, lecture_name, lecture_index, video_url, lecture_description
                    FROM lecture
                    WHERE course_id = '$courseID'";

                    $lectures = $database->query($query) or die('Error in query: ' . $database->error);

                    while ($lecture = $lectures->fetch_assoc()){ 
                        $htmlContainer .= '                              
                    
                    <div class="courseEditCard">
                        <div class="videoImage">
                            <img src="https://img.youtube.com/vi/' . $lecture['video_url'] . '/maxresdefault.jpg">
                        </div>
                        <div class="lectureDetails">
                            <h2><a href="lecture?lectureID=' . $lecture['lecture_id'] . '">Lecture ' . $lecture['lecture_index'] . ' - ' . $lecture['lecture_name'] . '</a></h2>
                            <h5>Description</h5>
                            <p>' . $lecture['lecture_description'] . '</p>
                        </div>
                        <div class="lectureEditButtons">
                            <button id="' . $lecture['lecture_id'] . '" class="btn-warning btn openModalBox editButton">Edit</button>
                            <button id="' . $lecture['lecture_id'] . '" class="btn-danger btn deleteButton">Remove</button>
                        </div>
                    </div>';
                    }

                    $htmlContainer .= '
                    
                </div>
            </div>
        </div>
        ';

                            $query = "	SELECT lecture_id, lecture_name, lecture_index, video_url, lecture_description
                            FROM lecture
                            WHERE course_id = '$courseID'";

                            $lectures = $database->query($query) or die('Error in query: ' . $database->error);

                                $htmlContainer .= '
                                <div class="modalbox" id="questionModelBox">
                                    <div id="questionModelContent" class="modalcontent">
                                        <div id="close">
                                            <i class="fas fa-times-circle fa-2x"></i>
                                        </div>
                                        <h1>Edit Lecture</h1>
                                        <form>
                                            <div class="form-row">
                                                <label>Lecture Name</label>
                                                <input class="lecNameEdit" placeholder="">
                                            </div>
                                            <div class="form-row">
                                                <label>Lecture Video URL</label>
                                                <input class="videoURLEdit" value="">
                                            </div>                                            
                                            <div class="form-row">
                                                <label>Lecture Description</label>
                                                <textarea class="lecDescEdit"  id="questionInput"></textarea>
                                            </div>
                                            
                                        </form>
                                        <button class="btn btn-warning editLecture" id="modalreg">Edit Lecture</button>
                                    </div>
                                </div>';

                            $htmlContainer .= '
                            <div class="editModalbox" id="questionModelBox">
                                <div id="questionModelContent" class="modalcontent">
                                    <div id="editClose">
                                        <i class="fas fa-times-circle fa-2x"></i>
                                    </div>
                                    <h1>Edit Course</h1>
                                    <form>
                                        <div class="form-row">
                                            <label>Course Name</label>
                                            <input class="courseNameEdit" placeholder="' . $courseData['course_name'] . '">
                                        </div>
                                        <div class="form-row">
                                            <label>Course Price</label>
                                            <input class="coursePriceEdit"  value="$' . $courseData['course_fee'] . '">
                                        </div>
                                        <div class="form-row">
                                            <div class="custom-control custom-switch">';
                                                if($courseData['discount_allow']){
                                                    $htmlContainer .= '<input type="checkbox" class="custom-control-input courseDiscountEdit" id="customSwitch1" checked>';
                                                }
                                                else{
                                                    $htmlContainer .= '<input type="checkbox" class="custom-control-input courseDiscountEdit" id="customSwitch1">';
                                                }
                                                $htmlContainer .= '
                                                
                                                <label class="custom-control-label" for="customSwitch1">Allow Discounts</label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row">
                                            <label>Course Description</label>
                                            <textarea class="courseDescEdit" id="questionInput">' . $courseData['course_desc'] . '</textarea>
                                        </div>
                                    </form>
                                    <button class="btn btn-warning editCourse" id="editModalreg">Edit Course</button>
                                </div>
                            </div>                      
            
            
        </body>
    </html>';
    echo $htmlContainer;
}
?>