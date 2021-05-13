var modal = document.querySelector(".modalbox");

// Get the button that opens the modal
var btn = document.querySelectorAll("#openModalBox");

// Get the <span> element that closes the modal
var span = document.querySelector("#close");

var regModal = document.querySelector("#modalreg");

// When the user clicks the button, open the modal

for(var i = 0; i < btn.length; i++){
	btn[i].addEventListener("click", function(){
		modal.style.display = "block";
	})
}

window.addEventListener("click", function(e){
	if(e.target == modal){
		modal.style.display = "none";
	}
})

span.addEventListener("click", function(){
	modal.style.display = "none";
})

regModal.addEventListener("click", function(){
	modal.style.display = "none";
})


var addCourse = document.querySelector(".addCourse");
addCourse.addEventListener("click", function(){
    
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
    $.ajax({
        type : "POST",  //type of method
        url  : "insert.php",  //your page
        data : { method: "course", action: "add", courseName: courseName, coursePrice : coursePrice, discount: discount, desc: desc },// passing the values
        success: function(res){  
                                //do what you want here...
                }
    });
    location.reload();

})