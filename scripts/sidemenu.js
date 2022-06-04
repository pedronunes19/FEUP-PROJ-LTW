function clickNav(){
  if (nav==0){
    openNav();
    nav=1;
  }
  else{
    closeNav();
    nav=0;
  }
}


function openNav() {
    document.getElementById("search-menu").style.width = "20em";
    document.getElementsByClassName("openbtn")[0].style.marginLeft = "16em";
  }
  

function closeNav() {
  document.getElementById("search-menu").style.width = "0";
  document.getElementsByClassName("openbtn")[0].style.marginLeft = "0em";
}