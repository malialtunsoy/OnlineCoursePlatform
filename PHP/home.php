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
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Home Page</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script defer src="all.js"></script>
	<body>
		<div class="topnav">
	        <p id=name><img class="logo" src="logo.png">  Wan-Shi</p>
	        <a id="home" href="home"><i class="fas fa-home"></i>Home</a>
            <a id="courses" href="courses"><i class="fas fa-book-open"></i>Courses</a>
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
    		<h1>Welcome to Udemy</h1>
    	</div>
    	
	</body>
</html>