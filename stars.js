var star1 = document.querySelector("#star1");
var star2 = document.querySelector("#star2");
var star3 = document.querySelector("#star3");
var star4 = document.querySelector("#star4");

var star1button = document.querySelector("#star1button");
var star2button = document.querySelector("#star2button");
var star3button = document.querySelector("#star3button");
var star4button = document.querySelector("#star4button");
console.log("setted");

star1button.addEventListener("click", function(){
    console.log("star1");
    refresh();
    star1.classList.add("checked");
});

star2button.addEventListener("click", function(){
    console.log("star1");
    refresh();
    star1.classList.add("checked");
    star2.classList.add("checked");
});

star3button.addEventListener("click", function(){
    refresh();
    star1.classList.add("checked");
    star2.classList.add("checked");
    star3.classList.add("checked");
});

star4button.addEventListener("click", function(){
    refresh();
    star1.classList.add("checked");
    star2.classList.add("checked");
    star3.classList.add("checked");
    star4.classList.add("checked");
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