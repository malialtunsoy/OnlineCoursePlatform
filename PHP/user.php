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
$pathUsername = $_GET['id'];
$userType = $_SESSION['userType'];

if($userType == 'User'){ //user
    
    $htmlContainer = '<!DOCTYPE html>
    <head>
        <title>User Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script defer src="all.js"></script>
        <script defer src="follow.js"></script>
        <script defer src="searchBar.js"></script>
        <script defer src="certificateShare.js"></script>
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
            ';
                    if($username != $pathUsername){
                        $htmlContainer .= '<a id="profile" href="user?id='. $username . '"><i class="fas fa-user"></i>'. $username . '</a>';
                    }else{
                        $htmlContainer .= '<a id="profile" href="logout"><i class="fas fa-sign-out-alt"></i>Logout</a>';
                    }
                    $htmlContainer .= '
            
            <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
        </div>
        <div class="container">
            <div class="userPageContainer">
            <div class="profile">
                <div class="profilePicture">
                    <img src="userPP.png">
                </div>
                <div class="profileDetail">
                    <h1>'. $_GET["id"] . '</h1>
                    <h3>'. $userType . '</h3>';
                    if($username != $pathUsername){
                        $query = "	SELECT username_1
                                    FROM follows
                                    WHERE LOWER(username_1) = '$username' AND LOWER(username_2) = '$pathUsername'";
                            
                        $follow = $database->query($query) or die('Error in the query: ' . $database->error);
                        $follow = $follow->fetch_assoc()['username_1'];
                        if($follow == $username){
                            $htmlContainer .= '<button id="followButton" class="btn btn-sm btn-danger">-Unfollow</button>';
                        }
                        else{
                            $htmlContainer .= '<button id="followButton" class="btn btn-sm btn-primary">+Follow</button>';
                        }
                        
                    }
                    $htmlContainer .= '
                </div>
            </div> 
            <div></div>
            
            <div class="coursesContainer">
                <div class="lectureHeader">
                    <h1>' . $pathUsername . '\'s Purchased Courses</h1>
                </div>';

                $query = "	SELECT DISTINCT course_id, course_fee, course_name,lecture_count, username, rating, video_url
                FROM course NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
                NATURAL JOIN (SELECT course_id, video_url FROM lecture WHERE lecture_index = 1) AS sub2
                NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count FROM lecture GROUP BY
                course_id) AS sub3
                WHERE course_id IN (SELECT course_id FROM owns WHERE username = '$pathUsername')";

                $response = $database->query($query) or die('Error in query: ' . $database->error);
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
                            $htmlContainer .= '<h5>$' . $course['course_fee'] . '</h5>';
                                                    
                            $htmlContainer .= '
                        </div>
                    </div>';
                } 
                $htmlContainer .= '
            
                <div class="wishlist">
                    <h1>Whislist</h1>';
                $query = "	SELECT DISTINCT course_id, course_fee, course_name,lecture_count, username, rating, video_url
                FROM course NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
                NATURAL JOIN (SELECT course_id, video_url FROM lecture WHERE lecture_index = 1) AS sub2
                NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count FROM lecture GROUP BY
                course_id) AS sub3
                WHERE course_id IN (SELECT course_id FROM wishes WHERE username = '$pathUsername')";

                $response = $database->query($query) or die('Error in query: ' . $database->error);
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
                            $htmlContainer .= '<h5>$' . $course['course_fee'] . '</h5>';
                                                    
                            $htmlContainer .= '
                        </div>
                    </div>';



                } 
                $htmlContainer .= '
                </div>
                <div class="modalbox" id="questionModelBox">
                    <div id="questionModelContent" class="modalcontent">
                        <div id="close">
                            <i class="fas fa-times-circle fa-2x"></i>
                        </div>
                        <h1>Add New Course</h1>
                        <form>
                            <div class="form-row">
                                <label>Course Name</label>
                                <input placeholder="CourseName">
                            </div>
                            <div class="form-row">
                                <label>Course Price</label>
                                <input value="$">
                            </div>
                            <div class="form-row">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                    <label class="custom-control-label" for="customSwitch1">Allow Discounts</label>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <label>Course Description</label>
                                <textarea id="questionInput"></textarea>
                            </div>
                            <button class="btn btn-warning" id="modalreg">Add Course</button>
                        </form>
                    </div>
                </div>  
                

                
            </div>                 
            </div>
        </div>
        
    </body>
    </html>';
    echo $htmlContainer; 
}
elseif($userType == 'Instructor' && $username == $pathUsername){ //instructor from itself
    $htmlContainer = '<!DOCTYPE html>
    <head>
        <title>User Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script defer src="all.js"></script>
        <script defer src="follow.js"></script>
        <script defer src="searchBar.js"></script>
        <script defer src="addCourse.js"></script>
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
            <a id="profile" href="logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
            <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
        </div>
        <div class="container">
            <div class="userPageContainer">
                <div class="profile">
                    <div class="profilePicture">
                        <img src="userPP.png">
                    </div>
                    <div class="profileDetail">
                        <h1>'. $_GET["id"] . '</h1>
                        <h3>'. $userType . '</h3>';

                        $addQuery = "SELECT income FROM coursecreator WHERE username = '$username'";
                        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
                        $income = $addResponse->fetch_assoc()['income'];

                        $htmlContainer .='
                        <h5>Income: $'. $income . '</h5>
                        ';
                    if($username != $pathUsername){
                        $query = "	SELECT username_1
                                    FROM follows
                                    WHERE LOWER(username_1) = '$username' AND LOWER(username_2) = '$pathUsername'";
                            
                        $follow = $database->query($query) or die('Error in the query: ' . $database->error);
                        $follow = $follow->fetch_assoc()['username_1'];
                        if($follow == $username){
                            $htmlContainer .= '<button id="followButton" class="btn btn-sm btn-danger">-Unfollow</button>';
                        }
                        else{
                            $htmlContainer .= '<button id="followButton" class="btn btn-sm btn-primary">+Follow</button>';
                        }
                        
                    }
                    $htmlContainer .= '
                    </div>
                </div>
                <div class="coursesContainer">
                    <div class="lectureHeader">
                        <h1>'. $pathUsername . '\'s Courses</h1>
                        <div><button id="openModalBox" class="btn btn-warning addNewQuestion">Add New Course</button>
                        <a href="discountOffer"><button class="btn btn-danger">Discount Offers</button></a></div>
                    </div>';

                $query = "	SELECT DISTINCT course_id, course_fee, course_name,lecture_count, username, rating, video_url
                FROM course NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
                NATURAL JOIN (SELECT course_id, video_url FROM lecture WHERE lecture_index = 1) AS sub2
                NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count FROM lecture GROUP BY
                course_id) AS sub3
                WHERE course_id IN (SELECT course_id FROM course WHERE username = '$pathUsername')";

                $response = $database->query($query) or die('Error in query: ' . $database->error);
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
                            $htmlContainer .= '<h5>$' . $course['course_fee'] . '</h5>';
                                                    
                            $htmlContainer .= '
                        </div>
                    </div>';



                } 
                $htmlContainer .= '
                    <div class="modalbox" id="questionModelBox">
                        <div id="questionModelContent" class="modalcontent">
                            <div id="close">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                            <h1>Add New Course</h1>
                            <form>
                                <div class="form-row">
                                    <label>Course Name</label>
                                    <input class="courseNameEdit" placeholder="CourseName">
                                </div>
                                <div class="form-row">
                                    <label>Course Price</label>
                                    <input class="coursePriceEdit" value="$">
                                </div>
                                <div class="form-row">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input courseDiscountEdit" id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">Allow Discounts</label>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <label>Course Description</label>
                                    <textarea class="courseDescEdit" id="questionInput"></textarea>
                                </div>
                                
                            </form>
                            <button class="btn btn-warning addCourse" id="modalreg">Add Course</button>
                        </div>
                    </div>  
                    
    
                    
                </div>                 
                </div>
            </div>
            
        </body>
    </html>';
    echo $htmlContainer;
}
elseif($userType == 'Instructor'){ //instructor from user
    $htmlContainer = '<!DOCTYPE html>
    <head>
        <title>User Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script defer src="all.js"></script>
        <script defer src="script.js"></script>
        <script defer src="follow.js"></script>
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
            <a id="profile" href="user?id='. $username . '"><i class="fas fa-user"></i>'. $username . '</a>
            <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
        </div>
        <div class="container">
            <div class="userPageContainer">
            <div class="profile">
                <div class="profilePicture">
                    <img src="userPP.png">
                </div>
                <div class="profileDetail">
                    <h1>'. $_GET["id"] . '</h1>
                    <h3>'. $userType . '</h3>
                    ';
                    if($username != $pathUsername){
                        $query = "	SELECT username_1
                                    FROM follows
                                    WHERE LOWER(username_1) = '$username' AND LOWER(username_2) = '$pathUsername'";
                            
                        $follow = $database->query($query) or die('Error in the query: ' . $database->error);
                        $follow = $follow->fetch_assoc()['username_1'];
                        if($follow == $username){
                            $htmlContainer .= '<button id="followButton" class="btn btn-sm btn-danger">-Unfollow</button>';
                        }
                        else{
                            $htmlContainer .= '<button id="followButton" class="btn btn-sm btn-primary">+Follow</button>';
                        }
                        
                    }
                    $htmlContainer .= '
                </div>
            </div> 
            <div></div>
            
            <div class="coursesContainer">
                <div class="lectureHeader">
                    <h1>'. $pathUsername . '\'s Courses</h1>
                </div>';

                $query = "	SELECT DISTINCT course_id, course_fee, course_name,lecture_count, username, rating, video_url
                FROM course NATURAL JOIN (SELECT course_id, AVG(rate) AS rating FROM rating GROUP BY course_id) AS sub1
                NATURAL JOIN (SELECT course_id, video_url FROM lecture WHERE lecture_index = 1) AS sub2
                NATURAL JOIN (SELECT course_id, COUNT(*) AS lecture_count FROM lecture GROUP BY
                course_id) AS sub3
                WHERE course_id IN (SELECT course_id FROM course WHERE username = '$pathUsername')";

                $response = $database->query($query) or die('Error in query: ' . $database->error);
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
                            $htmlContainer .= '<h5>$' . $course['course_fee'] . '</h5>';
                                                    
                            $htmlContainer .= '
                        </div>
                    </div>';



                } 
                $htmlContainer .= '
                </div>
            </div>                 
            </div>
        </div>
        
    </body>
    </html>';
    echo $htmlContainer; 
}
else{ //admin
    $htmlContainer = '<!DOCTYPE html>
    <head>
        <title>User Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script defer src="all.js"></script>
        <script defer src="script.js"></script>
        <script defer src="searchBar.js"></script>
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
            ';
                    if($username != $pathUsername){
                        $htmlContainer .= '<a id="profile" href="user?id='. $username . '"><i class="fas fa-user"></i>'. $username . '</a>';
                    }else{
                        $htmlContainer .= '<a id="profile" href="logout"><i class="fas fa-sign-out-alt"></i>Logout</a>';
                    }
                    $htmlContainer .= '
            <a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
        </div>
        <div class="container">
            <div class="userPageContainer">
            <div class="profile">
                <div class="profilePicture">
                    <img src="userPP.png">
                </div>
                <div class="profileDetail">
                    <h1>'. $_GET["id"] . '</h1>
                    <h3>'. $userType . '</h3>
                </div>
            </div> 
            <div></div>
            
            <div class="coursesContainer">
            <div class="lectureHeader">
                <a href="refundRequest"><button class="btn btn-danger">Refund Requests</button></a></div>
                <h1></h1>
            </div>
                <div class="lectureHeader">
                </div>';
                $htmlContainer .= '
                </div>
            </div>                 
            </div>
        </div>
        
    </body>
    </html>';
    echo $htmlContainer; 
}


?>
