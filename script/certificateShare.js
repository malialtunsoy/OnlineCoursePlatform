console.log("HEY");
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

    alert("Post shared!");
})

var star1 = document.querySelector("#star1");
var star2 = document.querySelector("#star2");
var star3 = document.querySelector("#star3");
var star4 = document.querySelector("#star4");

var star1button = document.querySelector("#star1button");
var star2button = document.querySelector("#star2button");
var star3button = document.querySelector("#star3button");
var star4button = document.querySelector("#star4button");
var count = 0;
console.log("setted");

star1button.addEventListener("click", function(){
    console.log("star1");
    refresh();
    star1.classList.add("checked");
    count = 1;
});

star2button.addEventListener("click", function(){
    console.log("star1");
    refresh();
    star1.classList.add("checked");
    star2.classList.add("checked");
    count = 2;
});

star3button.addEventListener("click", function(){
    refresh();
    star1.classList.add("checked");
    star2.classList.add("checked");
    star3.classList.add("checked");
    count = 3;
});

star4button.addEventListener("click", function(){
    refresh();
    star1.classList.add("checked");
    star2.classList.add("checked");
    star3.classList.add("checked");
    star4.classList.add("checked");
    count = 4;
});

function refresh(){
    set();
    star1.classList.remove("checked");
    star2.classList.remove("checked");
    star3.classList.remove("checked");
    star4.classList.remove("checked");
};

function set(){
    star1 = document.querySelector("#star1");
    star2 = document.querySelector("#star2");
    star3 = document.querySelector("#star3");
    star4 = document.querySelector("#star4");
};

var ratetButton = document.getElementById("rateButton");
ratetButton.addEventListener("click", function(){
    var courseID = window.location.href;
    courseID = courseID[courseID.length-1]
    if(count == 0){
        alert("You should rate the course first!");
    }
    else{
        $.ajax({
            type : "POST",  //type of method
            url  : "insert.php",  //your page
            data : { method: "rate", course : courseID, rating : count},// passing the values
            success: function(res){  
                                    //do what you want here...
                    }
        });
    
        alert("You rate " + count + " stars!");
    }
    
})