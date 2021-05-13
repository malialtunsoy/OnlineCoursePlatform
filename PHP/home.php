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

$htmlContainer = '<!DOCTYPE html>
<html>
	<head>
		<title>Newsfeed Page</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script defer src="all.js"></script>
        <script defer src="script.js"></script>
		<script defer src="share.js"></script>
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
	<a id="profile" href="user?id=' . $username . '"><i class="fas fa-user"></i>Profile</a>
	<a id="mycourses" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
</div>
    	<div class="container">
    		<div class="QAPageContainer">
				<div class="lectureHeader">
					<h1>Newsfeed</h1>
				</div>
                <div class="questionContainer">
                    <div class="lectureHeader">
                        <h2>Posts</h2>
                        <button class="btn btn-primary" id="openModalBox">Post Something</button>
                    </div>
                    ';

                                $query = "SELECT * 
								FROM posts
								WHERE username IN (SELECT username_2 
								  FROM follows 
								  WHERE username_1 = '$username')";

                                $posts = $database->query($query) or die('Error in query: ' . $database->error);

                                while ($post = $posts->fetch_assoc()){ 
									$htmlContainer .= '<div class="questionCard">
									<div class="question">
										<div class="profilePost">
											<img src="userPP.png">
											<div>
											<h3><a href="user?id=' . $post['username'] . '">' . $post['username'] . '</a></h3>
											<p>' . $post['timestamp'] . '</p>
											</div>
										</div>
										<h4>' . $post['post_title'] . '</h4>
										<p>' . $post['content'] . '</p>
									</div>
								</div>';
                                    
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
                <h1>Post Something</h1>
                <form>
                    <div class="form-row">
                        <label>Title</label>
                    <input id="title" placeholder="Title">
                    </div>
                    <div class="form-row">
                        <label>Post</label>
                        <textarea id="questionInput"></textarea>
                    </div>
                    <button class="btn btn-warning" id="modalreg">Post</button>
                </form>
            </div>
        </div>  
    </div>
	</body>
</html>';
echo $htmlContainer;

?>
