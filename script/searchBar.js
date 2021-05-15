var searchButton = document.querySelector(".searchButton");

searchButton.addEventListener("click", function(){
    var search = document.querySelector(".search").value;
    window.location.href = "search?search="+search;
})
