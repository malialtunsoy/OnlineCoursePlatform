var followButton = document.getElementById("followButton");
followButton.addEventListener("click", function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const toFollow = urlParams.get('id');

    var action = followButton.innerText;
    if(action == "-Unfollow"){
        action = "unfollow";
    }
    else{
        action = "follow";
    }
    console.log(toFollow + action);
   
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "follow", action : action, toFollow : toFollow},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });

    location.reload();

    
    
})