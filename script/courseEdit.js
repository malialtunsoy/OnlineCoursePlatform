var modal = document.querySelector(".modalbox");

// Get the button that opens the modal
var btn = document.querySelectorAll(".openModalBox");

// Get the <span> element that closes the modal
var span = document.querySelector("#close");
// When the user clicks the button, open the modal

var editIndex;

for(var i = 0; i < btn.length; i++){
	console.log(i);
	btn[i].index = i;
    btn[i].lecindex = btn[i].getAttribute("id");
	btn[i].addEventListener("click", function(e){
        modal = document.querySelector(".modalbox");
		modal.style.display = "block";
        console.log("open0");
        editIndex = e.currentTarget.lecindex;
	})
}

window.addEventListener("click", function(e){
	if(e.target == modal){
		modal.style.display = "none";
	}
})

span.addEventListener("click", function(e){
    modal.style.display = "none";
})

var emodal = document.querySelector(".editModalbox");

// Get the button that opens the modal
var ebtn = document.querySelector("#openEditModalBox");

// Get the <span> element that closes the modal
var espan = document.querySelector("#editClose");

var eregModal = document.querySelector("#editModalreg");

// When the user clicks the button, open the modal


ebtn.addEventListener("click", function(){
	emodal.style.display = "block";
})


window.addEventListener("click", function(e){
	if(e.target == emodal){
		emodal.style.display = "none";
	}
})

espan.addEventListener("click", function(){
	emodal.style.display = "none";
})

eregModal.addEventListener("click", function(){
	emodal.style.display = "none";
})



var announceButton = document.getElementById("announceButton");
announceButton.addEventListener("click", function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const courseID = urlParams.get('courseID');
    var annTitle = document.getElementById("annTitle").value;
    var annContent = document.getElementById("annContent").value;

    console.log(courseID + annTitle + annContent);
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "announcement", title : annTitle, announcement : annContent, course: courseID},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });

    alert("Announcement made: " + annTitle);
    
})

var addLectureButton = document.getElementById("addLectureButton");
addLectureButton.addEventListener("click", function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const courseID = urlParams.get('courseID');
    var lecName = document.querySelectorAll("#exampleFormControlInput1")[0].value;
    var lecDesc = document.querySelector("#exampleFormControlTextarea1").value;
    var videoURL = document.querySelectorAll("#exampleFormControlInput1")[1].value;

    console.log(lecName + lecDesc + videoURL);
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "lecture", action: "new", course: courseID, lecName: lecName, lecDesc : lecDesc, video: videoURL},// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });

    location.reload();
    
})

var deleteButtons = document.querySelectorAll(".deleteButton");

for(var i = 0; i<deleteButtons.length;i++){
    
    deleteButtons[i].lecindex = deleteButtons[i].getAttribute("id");
    deleteButtons[i].addEventListener("click", function(e){
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const courseID = urlParams.get('courseID');
        var lecIndex = e.currentTarget.lecindex;
        $.ajax({
            type : "POST",  //type of method
            url  : "insert.php",  //your page
            data : { method: "lecture", action: "delete", course: courseID, lecture: lecIndex },// passing the values
            success: function(res){  
                                    //do what you want here...
                    }
        });
        location.reload();
        
    })

}

var editLecture = document.querySelector(".editLecture");
editLecture.addEventListener("click", function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const courseID = urlParams.get('courseID');

    var lecName = document.querySelector(".lecNameEdit").value;
    var lecDesc = document.querySelector(".lecDescEdit").value;
    var videoURL = document.querySelector(".videoURLEdit").value;
    console.log("EDIT");
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "lecture", action: "edit", course: courseID, lecture: editIndex, lecName: lecName, lecDesc : lecDesc, video: videoURL },// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    location.reload();

})

var editCourse = document.querySelector(".editCourse");
editCourse.addEventListener("click", function(){
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const courseID = urlParams.get('courseID');
    
    var courseName = document.querySelector(".courseNameEdit").value;
    var coursePrice = document.querySelector(".coursePriceEdit").value;
    var discount = document.querySelector(".courseDiscountEdit").checked;
    var desc = document.querySelector(".courseDescEdit").value;

    coursePrice = coursePrice.substring(1);
    if(discount){
        discount = 1;
    }
    else{
        discount = 0;
    }
    
    console.log("EDIT");
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "course", action: "edit", course: courseID, courseName: courseName, coursePrice : coursePrice, discount: discount, desc: desc },// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    location.reload();

})