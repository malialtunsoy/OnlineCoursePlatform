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

//if($userType == 'User' || $userType == 'Instructor' ){ //user or instructor

    if(strtolower($ownsData['username']) != $username && ($userType == 'User' || $userType == 'Instructor') && ($courseData['username'] != $username) ){ //user or insturctor not owns
        echo "<script LANGUAGE='JavaScript'>
          window.alert('You should buy the course to display Q&A Section.');
          window.location.href='course?courseID=" . $courseID .".php';
        </script>";
    }
    elseif($userType == 'User' || $userType == 'Admin' ){//user own OR admin
        $htmlContainer = '<!DOCTYPE html>
        <html>
            <head>
                <title>Q&A Page</title>
                <link rel="stylesheet" type="text/css" href="style.css" />
                <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
                <script defer src="all.js"></script>
                <script defer src="script.js"></script>
                <script defer src="questionUser.js"></script>
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
                    <div class="QAPageContainer">
                        <div class="lectureHeader">
                            <h1>Python Tutorial - Q&A</h1>
                            <a href="course?courseID=' . $courseID . '"><button class="btn btn-warning">Go to Course Page
                            </button></a>
                        </div>
                        <div class="questionContainer">
                            <div class="lectureHeader">
                                <h2>Questions</h2>
                                <button class="btn btn-danger" id="openModalBox">Ask a Question</button>
                            </div>';
    
                            $query = "SELECT username, question_title, question, answer, question_time, answer_time
                            FROM question
                            WHERE course_id = '$courseID'";
    
                            $questions = $database->query($query) or die('Error in query: ' . $database->error);
    
                            while ($question = $questions->fetch_assoc()){
                                if($question['answer_time'] != NULL){
                                $htmlContainer .= '<div class="questionCard">
                                <div class="question">
                                    <h5>Question by: <a href="user?id=' . $question['username'] . '">' . $question['username'] . '</a></h5>
                                    <p>Date: ' . $question['question_time'] . '</p>
                                    <h6>' . $question['question_title'] . '</h6>
                                    <p>' . $question['question'] . '</p>
                                </div>
                                <div class="answer">
                                    <h5>Answered by: <a href="user?id=' . $courseData['username'] . '">' . $courseData['username'] . '</a></h5>
                                    <p>Date: ' . $question['answer_time'] . '</p>
                                    <p>' . $question['answer'] . '</p>
                                </div>
                            </div>';}
                            }
    
                            $htmlContainer .= '
                        </div>
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
                            <input id="title" placeholder="Title">
                            </div>
                            <div class="form-row">
                                <label>Question</label>
                                <textarea id="questionInput"></textarea>
                            </div>
                            
                        </form>
                        <button class="btn btn-warning" id="modalreg">Ask</button>
                    </div>
                </div>  
            </div>
            </body>
        </html>';
        echo $htmlContainer;
    }
    else{ //instructor own
        $htmlContainer = '<!DOCTYPE html>
        <html>
            <head>
                <title>Q&A Page - Creator</title>
                <link rel="stylesheet" type="text/css" href="style.css" />
                <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
                <script defer src="all.js"></script>
                <script defer src="script.js"></script>
                <script defer src="questionInst.js"></script>
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
                    <div class="QAPageContainer">
                        <div class="lectureHeader">
                            <h1>Python Tutorial - Q&A</h1>
                            <a href="course?courseID=' . $courseID . '"><button class="btn btn-warning">Go to Course Page
                            </button>
                        </div>
                        <div class="questionContainer">
                            <div class="lectureHeader">
                                <h2>Questions</h2>
                               
                            </div>
                            ';
    
                            $query = "SELECT username, question_title, question, answer, question_time, answer_time
                            FROM question
                            WHERE course_id = '$courseID'";
    
                            $questions = $database->query($query) or die('Error in query: ' . $database->error);
    
                            while ($question = $questions->fetch_assoc()){ 
                                if($question['answer_time'] == NULL){
                                    $htmlContainer .= '
                                    <div class="questionCard">
                                        <div class="question">
                                            <h5>Question by: <a href="user?id=' . $question['username'] . '">' . $question['username'] . '</a></h5>
                                            <p>Date: ' . $question['question_time'] . '</p>
                                            <h6>' . $question['question_title'] . '</h6>
                                            <p>' . $question['question'] . '</p>
                                        </div>
                                        <div class="answer">
                                            <h5>Answer</h5>
                                            <textarea class="complaintTextArea"></textarea>
                                            <button class="btn btn-primary">Answer</button>
                                        </div>
                                    </div>';
                                }
                               
                            }
    
                            $htmlContainer .= '
                        </div>
                            
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


//}

//elseif($userType == 'Admin'){ //instructor from itself
//    $htmlContainer = '';
//        echo $htmlContainer;
//}

?>

