

function no(targetid){
    const adido = document.getElementById(targetid);
    adido.classList.add('dontwanna');
    setTimeout(() => {
        adido.classList.remove('dontwanna');
    }, 2000);
}

function edit_function(){
   const container = document.querySelector('.edit_container');
   container.classList.add('open');
}

function access_page(crruentpage,targetpage){
    switch(targetpage){
        case 'Home':
            
            break;
        default:
            window.location.href ="../../Error.html";
            break;
    }
}

function close_edit(){
    const container = document.querySelector('.edit_container');
    container.classList.remove('open');
}
function submit_edit(){
    let isDebugging = false;
    if(isDebugging){
        no('edit_submit');
        console.log('Debugging mode is on. Submission halted.');
        return;
    }else{
        // Submission logic here
        
        close_edit();
        transition_editpage();
    }
}
function transition_editpage(){
    const article = document.getElementById('article');
    const idle = document.getElementById('idle');
    const section = document.getElementById('section');
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
            window.location.href = "../../edit";
        }, 1000);
    }, 1000);
    
}