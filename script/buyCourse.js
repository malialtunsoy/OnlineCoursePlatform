var button = document.getElementById("buyButton");
button.addEventListener("click", function(){
    var fee = document.getElementById("price").innerText;
    fee = fee.substring(1, fee.length);
    var balance = document.getElementById("balance").innerText;
    balance = balance.substring(10);
    var courseID = window.location.href;
    courseID = courseID[courseID.length-1]
    console.log(fee + balance + courseID);
    console.log("POSTED");
    if(parseInt(balance) < parseInt(fee) ){
        alert("You don't have enough money in your balance.");
    }
    else{
        $.ajax({
            type : "POST",  //type of method
            url  : "insert.php",  //your page
            data : { method: "buy", balance : balance, fee : fee, course: courseID},// passing the values
            success: function(res){  
                                    //do what you want here...
                    }
        });
    }
    
    location.reload();
});

var wishButton = document.getElementById("wishButton");
wishButton.addEventListener("click", function(){
    var courseID = window.location.href;
    courseID = courseID[courseID.length-1];
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "wish", course: courseID},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
        
    location.reload();
});
