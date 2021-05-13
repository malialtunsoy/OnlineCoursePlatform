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
	<body>
		<div class="topnav">
	        <p id=name><img class="logo" src="logo.png">  Wan-Shi</p>
	        <a id="profile" href="index"><i class="fas fa-user"></i>Login</a>
	        <a id="mycourses" style="display: none"href=""><i class="fas fa-project-diagram" ></i>My Courses</a>
    	</div>
    	
		<div class="loginContainer">
			<div class="d-flex justify-content-center h-100">
				<div class="card">
					<div class="card-header">
						<h3>Sign Up</h3>
					</div>
					<div class="card-body">
						<form>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="username">
								
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-at"></i></span>
								</div>
								<input type="text" class="form-control" placeholder="e-mail">
								
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" class="form-control" placeholder="password">
							</div>
							<div class="form-group">
								<input type="submit" value="Sign Up" class="login_btn btn float-right">
							</div>
						</form>
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