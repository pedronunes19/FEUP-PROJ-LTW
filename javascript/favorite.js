const whiteHeart = '\u2661';
const blackHeart = '\u2764';
const button = document.querySelector('.favorite-button');
const favorite = document.querySelector(".favorite")
button.addEventListener('click', toggle);

function toggle() {
  const like = favorite.textContent;
  if(like==whiteHeart) {
    favorite.textContent = blackHeart;
  } else {
    favorite.textContent = whiteHeart;
  }
}