<?php
include("config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    //SIGN UP
    if($_POST['method'] == "signup" ){

    }
    //SHARE POST
    if($_POST['method'] == "share" ){
      $title = $_POST['title'];
      $post = $_POST['post'];
      $username = $_SESSION['username'];
      
      $addQuery = "INSERT INTO posts VALUES ('$username','$title', '$post', CURRENT_TIMESTAMP);";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }
    //SEND TICKET
    if($_POST['method'] == "ticket" ){
      $title = $_POST['title'];
      $course = $_POST['course'];
      $reason = $_POST['reason'];
      $username = $_SESSION['username'];

      $addQuery = "INSERT INTO complaint VALUES ('$username', NULL , $course, '$title', '$reason', NULL);";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }
    //REFUND COURSE
    if($_POST['method'] == "refund" ){
      $title = $_POST['title'];
      $courseID = $_POST['course'];
      $reason = $_POST['reason'];
      $username = $_SESSION['username'];
      $active = "ACTIVE";

      $query = "	SELECT username
                  FROM requestrefund
                  WHERE username = '$username' AND course_id = $courseID";
              
      $offer = $database->query($query) or die('Error in the query: ' . $database->error);
      $offer = $offer->fetch_assoc()['username'];
      if($offer != $username){
        $addQuery = "INSERT INTO requestrefund VALUES ('$username', $courseID, '$title', '$reason', '$active');";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      else{
        $addQuery = "UPDATE requestrefund SET status = 'ACTIVE', title = '$title', reason = '$reason' WHERE username = '$username' AND course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }

      
    }

    //REFUND REQUEST MANAGE
    if($_POST['method'] == "refundRequestManage" ){
      $username = $_SESSION['username'];
      $user_username = $_POST['username'];
      $courseID = $_POST['courseID'];
      $action = $_POST['action'];

      if($action == "APPROVE"){
        //change request status
        $addQuery = "UPDATE requestrefund SET status = '$action' WHERE  username = '$user_username' AND course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
        
        //get course price
        $addQuery = "SELECT course_fee FROM course WHERE course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
        $courseFee = $addResponse->fetch_assoc()['course_fee'];

        //change user balance
        $addQuery = "UPDATE user SET balance = balance + $courseFee WHERE username = '$user_username'";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);

        //get course creator
        $addQuery = "SELECT username FROM course WHERE course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
        $creator_username = $addResponse->fetch_assoc()['username'];

        //change craeator income
        $addQuery = "UPDATE coursecreator SET income = income - $courseFee WHERE username = '$creator_username'";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);

        //change owns
        $addQuery = "DELETE FROM owns WHERE username = '$user_username' AND course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      else{//DECLINE
        //change request status
        $addQuery = "UPDATE requestrefund SET status = '$action' WHERE  username = '$user_username' AND course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      } 
    }


    //ASK A QUESTION
    if($_POST['method'] == "ask" ){
      $title = $_POST['title'];
      $courseID = $_POST['course'];
      $question = $_POST['question'];
      $username = $_SESSION['username'];
      $active = "ACTIVE";

      $addQuery = "INSERT INTO question VALUES ($courseID , '$username', '$title', '$question', NULL , CURRENT_TIMESTAMP  ,NULL);";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }
    //BUY COURSE
    if($_POST['method'] == "buy" ){
      $fee = $_POST['fee'];
      $balance = $_POST['balance'];
      $courseID = $_POST['course'];
      $username = $_SESSION['username'];
      $active = "ACTIVE";

      //INSERT OWN
      $addQuery = "INSERT INTO owns VALUES ('$username', $courseID);";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);

      //get course creator
      $addQuery = "SELECT username FROM course WHERE course_id = $courseID";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      $creator_username = $addResponse->fetch_assoc()['username'];

      //change craeator income
      $addQuery = "UPDATE coursecreator SET income = income + '$fee' WHERE username = '$creator_username'";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      
      //UPDATE BALANCE
      $addQuery = "UPDATE user SET balance = balance - '$fee' WHERE username = '$username';";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }
    //RATE COURSE
    if($_POST['method'] == "rate" ){
      $courseID = $_POST['course'];
      $rating = $_POST['rating'];
      $username = $_SESSION['username'];
      
      $addQuery = "SELECT username FROM rating WHERE username = '$username' and course_id = $courseID";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      $addResponse = $addResponse->fetch_assoc();
      if($addResponse['username'] != $username){
        $addQuery = "INSERT INTO rating VALUES ('$username' , $courseID, $rating)";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      else{
        $addQuery = "UPDATE rating SET rate = $rating WHERE username = '$username' and course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      
    }
    //FOLLOW / UNFOLLOW USER
    if($_POST['method'] == "follow" ){
      $username = $_SESSION['username'];
      $toFollow = $_POST['toFollow'];
      $action = $_POST['action'];
      
      if($action == "follow"){
        $addQuery = "INSERT INTO follows VALUES ('$username', '$toFollow')";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      else{
        $addQuery = "DELETE FROM follows WHERE username_1 = '$username' and username_2 = '$toFollow'";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }


    }
    //ADD NOTE
    if($_POST['method'] == "note" ){
      $username = $_SESSION['username'];
      $noteText = $_POST['noteText'];
      $lectureID = $_POST['lectureID'];

      $addQuery = "SELECT username FROM notes WHERE username = '$username' and lecture_id = $lectureID";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      $addResponse = $addResponse->fetch_assoc();
      if($addResponse['username'] != $username){
        $addQuery = "INSERT INTO notes VALUES ('$username', $lectureID, '$noteText')";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      else{
        $addQuery = "UPDATE notes SET note = '$noteText' WHERE username = '$username' and lecture_id = $lectureID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }      
    }

    //WATCH
    if($_POST['method'] == "watch" ){
      $username = $_SESSION['username'];
      $lectureID = $_POST['lectureID'];
      $action = $_POST['action'];

      if($action == "watch"){
        $addQuery = "INSERT INTO watched VALUES ('$username', $lectureID)";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      else{
        $addQuery = "DELETE FROM watched WHERE username = '$username' and lecture_id = $lectureID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }     
    }

    //WISH
    if($_POST['method'] == "wish" ){
      $username = $_SESSION['username'];
      $courseID = $_POST['course'];

      $query = "	SELECT username
                  FROM wishes
                  WHERE LOWER(username) = '$username' AND course_id = '$courseID'";
              
      $wish = $database->query($query) or die('Error in the query: ' . $database->error);
      $wish = $wish->fetch_assoc()['username'];
      if($wish != $username){
        $addQuery = "INSERT INTO wishes VALUES ('$username', $courseID)";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      else{
        $addQuery = "DELETE FROM wishes WHERE username = '$username' and course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }     
    }

    //DISCOUNT OFFER SEND
    if($_POST['method'] == "discount" ){
      $username = $_SESSION['username'];
      $courseID = $_POST['course'];
      $creator_username = $_POST['creator'];
      $discount = $_POST['discount'];

      $query = "	SELECT admin_username
                  FROM discountoffer
                  WHERE LOWER(admin_username) = '$username' AND creator_username = '$creator_username' AND course_id = $courseID";
              
      $offer = $database->query($query) or die('Error in the query: ' . $database->error);
      $offer = $offer->fetch_assoc()['admin_username'];
      if($offer != $username){
        $addQuery = "INSERT INTO discountoffer VALUES ('$username', '$creator_username', $courseID, $discount , 'ACTIVE')";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      else{
        $addQuery = "UPDATE discountoffer SET discount_amount = $discount, status = 'ACTIVE' WHERE admin_username = '$username' AND creator_username = '$creator_username' AND course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }   
    }

    //DISCOUNT OFFER MANAGE
    if($_POST['method'] == "discountOffer" ){
      $username = $_SESSION['username'];
      $admin = $_POST['admin'];
      $courseID = $_POST['courseID'];
      $newPrice = $_POST['newPrice'];
      $action = $_POST['action'];

      if($action = 'APPROVE'){
        //change offer status
        $addQuery = "UPDATE discountoffer SET status = '$action' WHERE admin_username = '$admin' AND creator_username = '$username' AND course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);

        //change course price
        $addQuery = "UPDATE course SET course_fee = $newPrice WHERE course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      else{
        //change offer status
        $addQuery = "UPDATE discountoffer SET status = '$action' WHERE admin_username = '$admin' AND creator_username = '$username' AND course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      } 
    }

    //ANNOUNCEMENT
    if($_POST['method'] == "announcement" ){
      $username = $_SESSION['username'];
      $courseID = $_POST['course'];
      $title = $_POST['title'];
      $announcement = $_POST['announcement'];     

      $addQuery = "INSERT INTO announces VALUES ( $courseID, '$title', '$announcement', CURRENT_TIMESTAMP, '$username')";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);

    }
    //ADD COURSE
    if($_POST['method'] == "course" ){
      $username = $_SESSION['username'];
      $action = $_POST['action'];

      if($action == "edit"){
        $courseID = $_POST['course'];
        $courseName = $_POST['courseName'];
        $coursePrice = $_POST['coursePrice'];
        $discount = $_POST['discount'];
        $desc = $_POST['desc'];

        $addQuery = "UPDATE course SET course_name = '$courseName', course_desc = '$desc', course_fee = '$coursePrice', discount_allow = $discount WHERE course_id = $courseID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      if($action == "add"){
        $courseName = $_POST['courseName'];
        $coursePrice = $_POST['coursePrice'];
        $discount = $_POST['discount'];
        $desc = $_POST['desc'];

        //Calulate course index
        $query = "	SELECT MAX(course_id) AS max_index
                    FROM course";
                
        $max_index = $database->query($query) or die('Error in the query: ' . $database->error);
        $courseID = $max_index->fetch_assoc()['max_index']+1;

        $coursePrice = $coursePrice + 0.00;

        $addQuery = "INSERT INTO course VALUES ($courseID, '$courseName', '$desc', $coursePrice, '$username', $discount)";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);

        $lectureID = $courseID * 10000 + 1;
        $addQuery = "INSERT INTO lecture VALUES ($lectureID, 'My First Lecture', 1, 'Please Edit Me', 'cpP-fCo8Dn4', $courseID)";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);

        $addQuery = "INSERT INTO rating VALUES ('malialtunsoy' , $courseID, 0)";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }


    }



    //ADD LECTURE
    if($_POST['method'] == "lecture" ){
      $username = $_SESSION['username'];
      $action = $_POST['action'];

      if($action == "new"){
        $courseID = $_POST['course'];
        $lecture_name = $_POST['lecName'];
        $lecture_desc = $_POST['lecDesc'];
        $video_url = $_POST['video'];
        
        //Calulate lecture index
        $query = "	SELECT MAX(lecture_index) AS max_index
                    FROM lecture
                    WHERE course_id = $courseID";
                
        $lecture_index = $database->query($query) or die('Error in the query: ' . $database->error);
        $lecture_index = $lecture_index->fetch_assoc()['max_index']+1;

        $lectureID = $courseID*10000 + $lecture_index;

        $addQuery = "INSERT INTO lecture VALUES ($lectureID, '$lecture_name', $lecture_index, '$lecture_desc', '$video_url', $courseID)";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      if($action == "delete"){
        $courseID = $_POST['course'];
        $lectureID = $_POST['lecture'];

        //$addQuery = "SELECT COUNT(*) AS num_of_lectures FROM lecture WHERE course_id = $courseID";
        //$addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
        if($lectureID%1000 != 1){//$addResponse->fetch_assoc()['num_of_lectures'] > 1){
          $addQuery = "DELETE FROM watched WHERE lecture_id = $lectureID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);

        $addQuery = "DELETE FROM lecture WHERE course_id = $courseID AND lecture_id = $lectureID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
        }       

      }
      if($action == "edit"){
        $courseID = $_POST['course'];
        $lectureID = $_POST['lecture'];
        $lecture_name = $_POST['lecName'];
        $lecture_desc = $_POST['lecDesc'];
        $video_url = $_POST['video'];

        $addQuery = "UPDATE lecture SET lecture_name = '$lecture_name', lecture_description = '$lecture_desc', video_url = '$video_url' WHERE lecture_id = $lectureID";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
    }

    //TICKET RESPONSE
    if($_POST['method'] == "complaint" ){

      $username = $_POST['username'];
      $courseID = $_POST['courseID'];
      $title = $_POST['title'];
      $answer = $_POST['answer'];

      $addQuery = "UPDATE complaint SET answer = '$answer' WHERE user_username = '$username' AND course_id = $courseID AND title = '$title' ";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
    }
    //DISCOUNT RESPONSE

    //SIGNUP
    if($_POST['method'] == "signup" ){

      $userType = $_POST['userType'];
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];

      $addQuery = "INSERT INTO account VALUES ('$username','$password','$email')";
      $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);

      if($userType == "USER"){//user
        $addQuery = "INSERT INTO user VALUES ('$username',1000)";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }
      else{//creator
        $addQuery = "INSERT INTO coursecreator VALUES ('$username',0)";
        $addResponse = $database->query($addQuery) or die('Error in deleteQuery: ' . $database->error);
      }

      
    }
      
         
  

}


?>