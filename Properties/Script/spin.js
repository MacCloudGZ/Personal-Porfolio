const border_back = document.querySelector('.border_back');

setInterval(() => {
    border_back.classList.toggle('spin');
}, 10000);