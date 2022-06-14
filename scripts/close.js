const close_button = document.querySelector("#session-messages > .close-button")

close_button.addEventListener('click', (e) => {
    e.target.parentElement.remove();
});
