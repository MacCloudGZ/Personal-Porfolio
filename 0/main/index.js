

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

function access_page(page){
    switch(page){
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
    no('edit_submit');
}