function tab_rotation(input){
    const tab1 = document.getElementById("tab1");
    const tab2 = document.getElementById("tab2");
    const tab3 = document.getElementById("tab3");
    const article1 = document.getElementById("article1");
    const article2 = document.getElementById("article2");
    const article3 = document.getElementById("article3");
    switch (input){
        case 1:
            if(!tab1.classList.contains("active")){
                if(!tab2.classList.contains("active")){
                    tab3.classList.remove("active");
                }else{
                    tab2.classList.remove("active");
                }
                tab1.classList.add("active");
                article_rotation(1);
            }
            break;
        case 2:
            if(!tab2.classList.contains("active")){
                if(!tab1.classList.contains("active")){
                    tab3.classList.remove("active");
                }else{
                    tab1.classList.remove("active");
                }
                tab2.classList.add("active");
                article_rotation(2);
            }
            break;
        case 3:
            if(!tab3.classList.contains("active")){
                if(!tab1.classList.contains("active")){
                    tab2.classList.remove("active");
                }else{
                    tab1.classList.remove("active");
                }
                tab3.classList.add("active");
                article_rotation(3);
            }
    }
}
function article_rotation(data){
    const article1 = document.getElementById("article1");
    const article2 = document.getElementById("article2");
    const article3 = document.getElementById("article3");
    const out_duration = 2000;
    const in_duration = 2500;
    switch(data){
        case 1:
            if(!article1.classList.contains("active")){
                if(article3.classList.contains("active")){
                    article3.classList.add("box-out");
                    setTimeout(() => {
                        article3.classList.remove("active");
                        article3.classList.remove("box-out");
                    }, out_duration);
                    console.log("Article out 3");
                }
                if(article2.classList.contains("active")){
                    article2.classList.add("box-out");
                    setTimeout(() => {
                        article2.classList.remove("active");
                        article2.classList.remove("box-out");
                    }, out_duration);                    
                    console.log("Article out 2");
                }
                article1.classList.add("active");
                article1.classList.add("box-in");
                setTimeout(() => {
                    article1.classList.remove("box-in")
                }, in_duration);
                console.log("Article in "+data);
            }
            break;
        case 2:
            if(!article2.classList.contains("active")){
                if(article3.classList.contains("active")){
                    article3.classList.add("box-out");
                    setTimeout(() => {
                        article3.classList.remove("active");
                        article3.classList.remove("box-out");
                    }, out_duration);
                    console.log("Article out 3");
                }
                if(article1.classList.contains("active")){
                    article1.classList.add("box-out");
                    setTimeout(() => {
                        article1.classList.remove("active");
                        article1.classList.remove("box-out");
                    }, out_duration);
                    console.log("Article out 1");
                }
                article2.classList.add("active");
                article2.classList.add("box-in");
                setTimeout(() => {
                    article2.classList.remove("box-in")
                }, in_duration);
                console.log("Article in "+data);
            }
            break;
        case 3:
            if(!article3.classList.contains("active")){
                if(article1.classList.contains("active")){
                    article1.classList.add("box-out");
                    setTimeout(() => {
                        article1.classList.remove("active");
                        article1.classList.remove("box-out");
                    }, out_duration);
                    console.log("Article out 1");
                }
                if(article2.classList.contains("active")){
                    article2.classList.add("box-out");
                    setTimeout(() => {
                        article2.classList.remove("active");
                        article2.classList.remove("box-out");
                    }, out_duration);
                    console.log("Article out 2");
                }
                article3.classList.add("active");
                article3.classList.add("box-in");
                setTimeout(() => {
                    article3.classList.remove("box-in")
                }, in_duration);
                    console.log("Article in "+data);
            }
            break;
        default:
            setTimeout(() => {
                    article1.classList.remove("box-in")
                }, in_duration);
            break;
    }
}