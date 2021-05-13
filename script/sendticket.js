var button = document.getElementById("sendTicket");
button.addEventListener("click", function(){
    var titleVal = document.getElementById("title").value;
    var selectedCourse = document.getElementById("selectedCourse").value[0];
    var complaintReason = document.getElementById("complaintReason").value;
    
    console.log("POSTED");
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "ticket", title : titleVal, course : selectedCourse, reason: complaintReason},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    window.location.href = "home";
})
