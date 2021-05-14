var approveButton = document.querySelectorAll(".approveButton");

for(var i=0; i<approveButton.length; i++){
    
    approveButton[i].id = approveButton[i].getAttribute("id");
    approveButton[i].addEventListener("click", function(e){
    var id = e.currentTarget.id;
    id = id.split("-");
    var username = id[0];
    var courseID = id[1];

    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "refundRequestManage", action : 'APPROVE', username : username, courseID : courseID},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    //alert(username + " " + courseID);
    location.reload();
    
})
}


var declineButton = document.querySelectorAll(".declineButton");

for(var i=0; i<declineButton.length; i++){
    
    declineButton[i].id = declineButton[i].getAttribute("id");
    declineButton[i].addEventListener("click", function(e){
    var id = e.currentTarget.id;
    id = id.split("-");
    var username = id[0];
    var courseID = id[1];

    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "refundRequestManage", action : 'DECLINE', username : username, courseID : courseID},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    //alert(username + " " + courseID);
    location.reload();
    
})
}


