var solveButton = document.querySelectorAll(".solveButton");

for(var i=0; i<solveButton.length; i++){
    
    solveButton[i].id = solveButton[i].getAttribute("id");
    solveButton[i].addEventListener("click", function(e){
    var id = e.currentTarget.id;
    id = id.split("-");
    var username = id[0];
    var courseID = id[1];
    var title = id[2];

    var answer = document.querySelector("#"+e.currentTarget.id).value;

    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "complaint",username : username, courseID : courseID, title : title, answer: answer},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    //alert(username + " " + courseID + " " + title + " " + answer);
    location.reload();
    
})
}

