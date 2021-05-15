var answerButton = document.querySelectorAll(".answerButton");

for(var i=0; i<answerButton.length; i++){
    
    answerButton[i].id = answerButton[i].getAttribute("id");
    answerButton[i].addEventListener("click", function(e){
    var id = e.currentTarget.id;
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const courseID = urlParams.get('courseID');
    id = id.split("-");
    var username = id[0];
    var time = id[1];
    var index = id[2];

    var answer = document.querySelector("#"+index).value;

    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "questionAnswer",username : username, course : courseID, time : time, answer: answer},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    alert(username + " " + courseID + " " + time + " " + answer);
    location.reload();
    
})
}

