var noteUpdate = document.getElementById("noteUpdate");
noteUpdate.addEventListener("click", function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const lectureID = urlParams.get('lectureID');

    var noteText = document.getElementById("noteText").value;
    console.log(lectureID + noteText);
   
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "note", lectureID : lectureID, noteText : noteText},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });

    alert("Note updated.");  
    
})

try{
    var next = document.getElementById("next");
    next.addEventListener("click", function(){
        console.log("next");
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const lectureID = urlParams.get('lectureID');
        
        $.ajax({
            type : "POST",  //type of method
            url  : "insert.php",  //your page
            data : { method: "watch", action : "watch",  lectureID : lectureID},// passing the values
            success: function(res){  
                                    //do what you want here...
                    }
        });
    })
}
catch(err){

}

try{
    var prev = document.getElementById("prev");
    prev.addEventListener("click", function(){
        console.log("prev");
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const lectureID = urlParams.get('lectureID');
        
        $.ajax({
            type : "POST",  //type of method
            url  : "insert.php",  //your page
            data : { method: "watch", action : "unwatch",  lectureID : lectureID},// passing the values
            success: function(res){  
                                    //do what you want here...
                    }
        });
    })
}
catch(err){

}


