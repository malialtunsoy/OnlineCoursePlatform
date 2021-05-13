var certButton = document.getElementById("certificateShare");
certButton.addEventListener("click", function(){
    var coursename = document.getElementById("coursename").innerText;
    console.log(coursename);
    var titleVal = "New Certificate";
    var postVal = "I succesfully finish my " + coursename + " course!";
    console.log("POSTED");
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "share", title : titleVal, post : postVal},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });

    window.location.href = "home";
})
