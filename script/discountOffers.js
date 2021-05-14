var approveButton = document.querySelectorAll(".approveButton");

for(var i=0; i<approveButton.length; i++){
    
    approveButton[i].id = approveButton[i].getAttribute("id");
    approveButton[i].addEventListener("click", function(e){
    var id = e.currentTarget.id;
    id = id.split("-");
    var admin = id[0];
    var courseID = id[1];
    var newPrice = id[2];

    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "discountOffer", action : 'APPROVE', admin : admin, courseID : courseID, newPrice : newPrice},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    //alert(admin + " " + courseID + " " + newPrice);
    location.reload();
    
})
}


var declineButton = document.querySelectorAll(".declineButton");

for(var i=0; i<declineButton.length; i++){
    
    declineButton[i].id = declineButton[i].getAttribute("id");
    declineButton[i].addEventListener("click", function(e){
    var id = e.currentTarget.id;
    id = id.split("-");
    var admin = id[0];
    var courseID = id[1];
    var newPrice = id[2];

    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "discountOffer", action : 'DECLINE', admin : admin, courseID : courseID, newPrice : newPrice},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    //alert(admin + " " + courseID + " " + newPrice);
    location.reload();
    
})
}


