const dishButton = document.getElementById("add-dish-button");
const menusButton = document.getElementById("add-menu-button");
const csrf = document.getElementById("csrf-form").value;
//console.log(document.getElementById("csrf-form"))

const resId = document.getElementsByClassName("restaurant-id-form");
const id = document.getElementsByClassName("id-form");
const amount = document.getElementsByClassName("amount-form");

dishButton.addEventListener('click', addDish);
menusButton.addEventListener('click', addMenu);

function addDish(){
    const request = new XMLHttpRequest();
    let res = resId[0].value; 
    let amount_value = amount[0].value;
    amount[0].value = null;
    let id_value = id[0].options[id[0].selectedIndex].value;
    request.open("post", "../actions/action.add_to_cart.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({type: "dish", id: id_value, amount: amount_value, 'restaurant-id': res, 'csrf': csrf}));
}

function addMenu(){
    const request = new XMLHttpRequest();
    let res = resId[1].value; 
    let amount_value = amount[1].value;
    amount[1].value = null;
    let id_value = id[1].options[id[1].selectedIndex].value;
    request.open("post", "../actions/action.add_to_cart.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({type: "menu", id: id_value, amount: amount_value, 'restaurant-id': res, 'csrf': csrf}));
}

function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
  }
  