<?php
include("config.php");
session_start();
include("config.php");
session_start();
//LOGIN CHECK
if(isset($_SESSION["LOGGEDIN"]) || $_SESSION["LOGGEDIN"] == true){
    echo "<script LANGUAGE='JavaScript'>
          window.alert('You already logged in.');
          window.location.href='home.php';
       </script>";
    exit;
}


?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sign Up Page</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script defer src="all.js"></script>
		<script defer src="signup.js"></script>
            <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"></script>
	<body>
		<div class="topnav">
	        <p id=name><img class="logo" src="logo.png">  Wan-Shi</p>
	        <a id="profile" href="index"><i class="fas fa-user"></i>Login</a>
	        <a id="mycourses" style="display: none"href=""><i class="fas fa-project-diagram" ></i>My Courses</a>
    	</div>
    	
		<div class="loginContainer">
			<div class="d-flex justify-content-center h-100">
				<div class="signupCard">
					<div class="card-header">
						<h3>Sign Up</h3>
					</div>
					<div class="card-body">
						<form>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input id="usernameSignup" type="text" class="form-control" placeholder="username">
								
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-at"></i></span>
								</div>
								<input id="emailSignup" type="text" class="form-control" placeholder="e-mail">
								
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input id="passwordSignup" type="password" class="form-control" placeholder="password">
							</div>
							<p style="color: white">User Type:</p>
							<div class="form-check">
								<input id="userSignup" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
								<label style="color: white" class="form-check-label" for="flexRadioDefault1">
									User
								</label>
							</div>
								<div class="form-check">
								<input id="creatorSignup" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" >
								<label style="color: white" class="form-check-label" for="flexRadioDefault2">
									Course Creator
								</label>
							</div>

							
						</form>
						<div class="form-group">
								<input id="signupButton" type="submit" value="Sign Up" class="login_btn btn float-right">
							</div>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-center links">
							Already have an account?<a href="index">Login</a>
						</div>
					</div>
				</div>
			</div>
		</div>	

    	
	</body>
</html>