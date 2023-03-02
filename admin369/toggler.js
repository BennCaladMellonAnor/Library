var d1 = document.querySelector("#catalog");
var d2 = document.querySelector("#edit");
var d3 = document.querySelector("#access");

function catalog(){
    show(d1);
    hide(d2);
    hide(d3);
}

function edit(){
  show(d2);
  hide(d1);
  hide(d3);
}

function access(){
    show(d3);
    hide(d1);
    hide(d2);
}

function show(element){
    if(element.classList.contains("hide")){
        element.classList.remove("hide")
    } 
}
function hide(element){
    if(!element.classList.contains("hide")){
        element.classList.add("hide")
    } 
}