var signupButton = document.getElementById("signupButton");
signupButton.addEventListener("click", function(){
    var username = document.getElementById("usernameSignup").value;
    var email = document.getElementById("emailSignup").value;
    var password = document.getElementById("passwordSignup").value;

    var user = document.getElementById("userSignup").checked;

    userType = "";
    if(user){
        userType = "USER";
    }
    else{
        userType = "CREATOR";
    }

    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "signup", username : username, email: email, password : password, userType : userType},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });

    $.ajax({
        type : "POST",  //type of method
        url  : "index.php",  //your page
        data : { username : username, password : password},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    alert("Hello " + username);
    window.location.href = "index";
    
})