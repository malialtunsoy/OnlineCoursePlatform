
var button = document.getElementById("modalreg");

button.addEventListener("click", function(){
    var titleVal = document.getElementById("title").value;
    var postVal = document.getElementById("questionInput").value;
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "share", title : titleVal, post : postVal},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
})

