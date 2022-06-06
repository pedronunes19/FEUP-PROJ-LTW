const button = document.querySelector("#session-messages > .close-button")

button.addEventListener('click', (e) => {
    e.target.parentElement.remove();
});
