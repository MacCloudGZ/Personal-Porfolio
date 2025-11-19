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

function access_page(currentpage,targetpage){
    // for debugging purpose in case of wrong redirection
    if(currentpage === targetpage){
        no(targetpage);
        console.log('You are already in the target page.');
        return;
    }
    transition_page();
    setTimeout(() => {
        console.log('Access Granted!')
        setTimeout(() => {
            switch(targetpage){
                case 'Home':
                    window.location.href ="../main";
                    break;
                case 'Projects':
                    window.location.href ="../projects";
                    break;
                case 'Contacts':
                    window.location.href ="../contacts";
                    break;
                default:
                    window.location.href ="../../Error.html";
                    break;
            }
        }, 500);
    },1000);
}

let lastRandomNum = null; // store previous number

function transition_page() {
    const article = document.getElementById('article');
    const idle = document.getElementById('idle');
    const section = document.getElementById('section');
    const background = document.getElementById('background');
    let randomNum;
    // Keep generating until it's different from lastRandomNum
    do {
        randomNum = Math.floor(Math.random() * 3) + 1;
    } while (randomNum === lastRandomNum);
    lastRandomNum = randomNum; // update for next call
    switch (randomNum) {
        // case 1:
        default:
            article.classList.add('out');
            break;
        // case 2:
        //     article.classList.add('left');
        //     break;
        // case 3:
        //     article.classList.add('right');
        //     break;
    }
    switch (randomNum) {
        case 1:
            section.classList.add('out');
            break;
        case 2:
            section.classList.add('left');
            break;
        case 3:
            section.classList.add('up');
            break;
    }
    setTimeout(() => {
        background.style.cursor = 'wait';
        if (idle) {
            idle.classList.add('active');
        } else {
            console.warn("Element with id 'idle' not found.");
        }
        section.style.display = 'none';
        article.style.display = 'none';
        console.log('Accessing TargetPage');
    }, 400);
}


function close_edit(){
    const container = document.querySelector('.edit_container');
    container.classList.remove('open');
}
function submit_edit(){
    const username = document.getElementById('edit_username')?.value?.trim() || '';
    const password = document.getElementById('edit_password')?.value || '';
    const submitBtn = document.getElementById('edit_submit');
    const container = document.querySelector('.edit_container');
    // Determine origin: Home/Projects/Contacts based on current path
    const path = window.location.pathname;
    let origin = 'Home';
    if (/\/0\/projects\b/i.test(path)) origin = 'Projects';
    else if (/\/0\/contacts\b/i.test(path)) origin = 'Contacts';
    if (!username || !password){
        no('edit_submit');
        console.warn('Missing username or password');
        return;
    }

    submitBtn.disabled = true;
	fetch('../../Properties/api/logins_submittion.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
		credentials: 'same-origin',
		body: JSON.stringify({ username, password, origin })
    })
    .then(async (res) => {
        let data = {};
        try { data = await res.json(); } catch(e) {}
        if (res.ok && data.success){
            close_edit();
            transition_editpage(origin);
        } else {
            document.title = 'ACCESS DENIED';
            no('edit_container');
            console.warn(data.message || 'Access denied');
        }
    })
    .catch((e) => {
        document.title = 'ACCESS DENIED';
        no('edit_container');
        console.error('Login request failed', e);
    })
    .finally(() => {
        submitBtn.disabled = false;
    });
}
function transition_editpage(origin){
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
			const from = origin || 'Home';
			const base = `${window.location.origin}/Personal-Porfolio`;
			window.location.href = `${base}/edit/?from=${encodeURIComponent(from)}`;
		}, 500);
    }, 1000);
    
}