const border_back = document.querySelector('.border_back');

setInterval(() => {
    border_back.classList.toggle('spin');
}, 10000);

function viewMain(){
    const article = document.getElementById('article');
    const section = document.getElementById('section');
    const idle = document.getElementById('idle');
    const background = document.getElementById('background');
    article.classList.add('out');
    section.classList.add('out');
    setTimeout(() => {
        background.style.cursor = 'wait';
        if (idle) {
            idle.classList.add('active');
        } else {
            console.warn("Element with id 'idle' not found.");
        }
        section.style.display = 'none';
        article.style.display = 'none';
        console.log('Accessing MainPage');
    }, 400);
    setTimeout(() => {
        console.log('Access Granted!')
        setTimeout(() => {
            window.location.href = "0/main";
        }, 1000);
    }, 1000);
}

function downloadCV(){
    console.log('Sending Request for download DV');

    console.log('server disconnected!');
}