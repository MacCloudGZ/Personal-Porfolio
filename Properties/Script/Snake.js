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
    try{
        // Find selected CV if any from radio list (if present on landing it won't exist). Fallback to latest.
        const chosen = document.querySelector('input[name="cvChoice"]:checked');
        const qs = chosen ? ('&file_id=' + encodeURIComponent(chosen.value)) : '';
        window.location.href = 'Properties/api/download_cv.php?id=1' + qs;
    }catch(e){
        window.location.href = 'Properties/api/download_cv.php?id=1';
    }
}