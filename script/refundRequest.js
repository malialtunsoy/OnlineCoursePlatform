var button = document.getElementById("modalreg");
button.addEventListener("click", function(){
    var titleVal = document.getElementById("title").value;
    var courseID = window.location.href;
    courseID = courseID[courseID.length-1]
    var complaintReason = document.getElementById("refundReason").value;
    console.log(titleVal + courseID + complaintReason);
    console.log("POSTED");
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "refund", title : titleVal, course : courseID, reason: complaintReason},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
})
