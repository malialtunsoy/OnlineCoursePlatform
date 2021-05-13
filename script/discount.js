var discountButton = document.getElementById("discountButton");
discountButton.addEventListener("click", function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const courseID = urlParams.get('courseID');
    var username = document.getElementById("creatorUsername").innerText;
    var discount = document.getElementById("discountAmount").value;

    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "discount", creator : username, course : courseID, discount: discount},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });

    alert("Discount offer send: $" + discount);
    
})