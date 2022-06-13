const emptyHeart = '\u2661';
const fullHeart = '\u2764';
const button = document.querySelector('.favorite-button');
const favorite = document.querySelector(".favorite")
button.addEventListener('click', toggle);

function toggle() {
  const request = new XMLHttpRequest();
  const like = favorite.innerText;
  if(like==emptyHeart) {
    favorite.textContent = fullHeart;
    request.open("post", "../actions/action.favorite.res.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({restaurant: res}));
  } else {
    favorite.textContent = emptyHeart;
    request.open("post", "../actions/action.unfavorite.res.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({restaurant: res}));
  }
}

function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}
