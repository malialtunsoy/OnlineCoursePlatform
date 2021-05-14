<?php
include("config.php");
session_start();

//LOGIN CHECK
if(isset($_SESSION["LOGGEDIN"]) || $_SESSION["LOGGEDIN"] === true){
  header("location: home.php");
  exit;
}

//AUTHENTICATON
if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty($_POST['username']) || empty($_POST['password'])){
        $errors = 'You must fill the blanks';
      } 
      else{
        $username = $_POST['username'];
        $password = $_POST['password'];
        $username = strtolower($username);

        $query = "	SELECT username AS name
                    FROM account
                    WHERE LOWER(username) = '$username' AND password = '$password'";
    
        $res = $database->query($query) or die('Error in the query: ' . $database->error);
        $resData = $res->fetch_assoc();
    
        if (strtolower($resData['name']) == $username) {
            session_start();
            $_SESSION['password'] = $password;
            $_SESSION['username'] = $username;
            $_SESSION['LOGGEDIN'] = true;

			//SET USER TYPE
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
        $_SESSION['userType'] = $userType;

		
            header('Location: home.php');
        } else {
           $errors = "Invalid username or password";
        }
    
        $database->close(); 

		
      }	
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login Page</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script defer src="all.js"></script>
	<body>
		<div class="topnav">
	        <p id=name><img class="logo" src="logo.png">  Wan-Shi</p>
	        <a id="profile" href="signup"><i class="fas fa-user"></i>Sign Up</a>
	        <a id="mycourses" style="display: none" href="mycourses"><i class="fas fa-project-diagram"></i>My Courses</a>
    	</div>
    	
		<div class="loginContainer">
			<div class="d-flex justify-content-center h-100">
				<div class="card">
					<div class="card-header">
						<h3>Sign In</h3>
					</div>
					<div class="card-body">
						<form method="POST">
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>
								<input type="text" class="form-control" name="username" placeholder="username">
								
							</div>
							<div class="input-group form-group">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" class="form-control" name="password" placeholder="password">
							</div>
							<div class="row align-items-center remember">
								<input type="checkbox">Remember Me
							</div>
              <div style="color: red"> <?php echo $errors; ?> &nbsp</div>
							<div class="form-group">
								<input type="submit" value="Login"  name="submit" class="login_btn btn float-right">
							</div>
						</form>
					</div>
					<div class="card-footer">
						<div class="d-flex justify-content-center links">
							Don't have an account?<a href="signup">Sign Up</a>
						</div>
						<div class="d-flex justify-content-center">
							<a href="#">Forgot your password?</a>
						</div>
					</div>
				</div>
			</div>
		</div>	

    	
	</body>
</html>