var modal = document.querySelector(".modalbox");

// Get the button that opens the modal
var btn = document.querySelector("#ask");

// Get the <span> element that closes the modal
var span = document.querySelector("#close");

var regModal = document.querySelector("#modalreg");

// When the user clicks the button, open the modal 
btn.addEventListener("click", function(){
	modal.style.display = "block";
})

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