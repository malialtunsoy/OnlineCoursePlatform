var modal = document.querySelectorAll(".modalbox");

// Get the button that opens the modal
var btn = document.querySelectorAll("#openModalBox");

// Get the <span> element that closes the modal
var span = document.querySelectorAll("#close");

var regModal = document.querySelectorAll("#modalreg");

// When the user clicks the button, open the modal

for(var i = 0; i < btn.length; i++){
	console.log(i);
	btn[i].index = i;
	btn[i].addEventListener("click", function(e){
		modal[e.currentTarget.index].style.display = "block";
	})
}


window.addEventListener("click", function(e){
	for(var i = 0; i < modal.length; i++){
		if(e.target == modal[i]){
			modal[i].style.display = "none";
		}
	}
})


for(var i = 0; i < span.length; i++){
	span[i].index = i;
	span[i].addEventListener("click", function(e){
		modal[e.currentTarget.index].style.display = "none";
	})
}

for(var i = 0; i < regModal.length; i++){
	regModal[i].index = i;
	regModal[i].addEventListener("click", function(e){
		modal[e.currentTarget.index].style.display = "none";
	})
}


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