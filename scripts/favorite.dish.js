buttonDish = document.querySelector('.favorite-button-dish' + dish);
//favoriteDish = document.querySelector('.favorite-dish' + dish)
dish_map.set(buttonDish, dish);
buttonDish.addEventListener('click', toggle1);

function toggle1() {
    const request = new XMLHttpRequest();
    favoriteDish = document.querySelector('.favorite-dish' + dish_map.get(this));
    const like = favoriteDish.innerText;
    if(like==emptyHeart) {
        favoriteDish.textContent = fullHeart;
        request.open("post", "../actions/action.favorite.dish.php", true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(encodeForAjax({dish: dish_map.get(this)}));
    } else {
        favoriteDish.textContent = emptyHeart;
        request.open("post", "../actions/action.unfavorite.dish.php", true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(encodeForAjax({dish: dish_map.get(this)}));
    }
}
  
function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}