var button = document.getElementById("modalreg");
button.addEventListener("click", function(){
    var titleVal = document.getElementById("title").value;
    var questionVal = document.getElementById("questionInput").value;
    var courseID = window.location.href;
    courseID = courseID[courseID.length-1]
    console.log(titleVal + courseID + questionVal);
    console.log("POSTED");
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "ask", title : titleVal, course : courseID, question: questionVal},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
})
