

function no(targetid){
    const adido = document.getElementById(targetid);
    adido.classList.add('dontwanna');
    setTimeout(() => {
        adido.classList.remove('dontwanna');
    }, 2000);
}

function edit_function(){
   no('editicon');
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