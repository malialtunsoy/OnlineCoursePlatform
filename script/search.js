
var searchButton = document.querySelector("#searchButton");

searchButton.addEventListener("click", function(){
    var search = document.querySelector("#search").value;
    var min = document.querySelector("#min").value;
    var max = document.querySelector("#max").value;

    window.location.href = "search?search="+search+"&lower="+min+"&upper="+max;

})
