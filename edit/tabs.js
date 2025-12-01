document.addEventListener('DOMContentLoaded', () => {
    // Get all tab buttons (icon handlers) and tab content sections
    const tabButtons = document.querySelectorAll('.icon-handler');
    const tabSections = document.querySelectorAll('.sections-background-container');

    // Function to switch tabs
    const switchTab = (targetId) => {
        // Remove active class from all sections and buttons
        tabSections.forEach(section => {
            section.classList.remove('active');
        });
        tabButtons.forEach(button => {
            button.classList.remove('active');
        });

        // Add active class to the selected section and button
        const targetSection = document.getElementById(`${targetId}-section`);
        const targetButton = document.querySelector(`[data-target="${targetId}"]`);
        
        if (targetSection) {
            targetSection.classList.add('active');
        }
        if (targetButton) {
            targetButton.classList.add('active');
        }
        try { localStorage.setItem('edit_active_tab', targetId); } catch(e) {}
    };

    // Add click event listeners to all tab buttons
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.dataset.target;
            switchTab(targetId);
        });
    });

    // Initialize with persisted tab or first tab
    const persisted = (() => { try { return localStorage.getItem('edit_active_tab'); } catch(e) { return null; } })();
    if (persisted && document.getElementById(`${persisted}-section`)) {
        switchTab(persisted);
    } else if (!document.querySelector('.sections-background-container.active')) {
        const firstButton = tabButtons[0];
        if (firstButton) {
            switchTab(firstButton.dataset.target);
        }
    }
});
var debuggmode = true;
function areafunction(clustersec, trsection){
    const section = clustersec;
    const targetsection = trsection;
    let body, totaltab, allsection, tab;
    let alltab = ["null"];
    switch(section){
        case "fis":
            if(debuggmode)console.log("Accessing cluster: "+clustersec+"\nTargeting: "+trsection);
            allsection = ["profile-image" , "cv-files"];
            totaltab = allsection.length;
            for(let x = 1; x <= totaltab; x++){
                alltab.push(clustersec+"tab"+x);
            }
            body = document.getElementById(targetsection);
            switch(targetsection){
                case allsection[0]:
                    tab = document.getElementById(alltab[1]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                case allsection[1]:
                    tab = document.getElementById(alltab[2]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                default:
                    if(debuggmode)console.log("invalid target section = "+trsection);
                    break;
            }
            break;
        case "pis":
            console.log("Accessing cluster: "+clustersec+"\nTargeting: "+trsection);
            allsection = ["personal-info" , "address","contact-info","education","skills","personal-touch","messages"];
            totaltab = allsection.length;
            for(let x = 1; x <= totaltab; x++){
                alltab.push(clustersec+"tab"+x);
            }
            body = document.getElementById(targetsection);
            switch(targetsection){
                case allsection[0]:
                    tab = document.getElementById(alltab[1]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                case allsection[1]:
                    tab = document.getElementById(alltab[2]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                case allsection[2]:
                    tab = document.getElementById(alltab[3]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                case allsection[3]:
                    tab = document.getElementById(alltab[4]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                case allsection[4]:
                    tab = document.getElementById(alltab[5]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                case allsection[5]:
                    tab = document.getElementById(alltab[6]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                case allsection[6]:
                    tab = document.getElementById(alltab[7]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                default:
                    console.log("invalid target section = "+trsection);
                    break;
            }
            break;
        case "pms":
            console.log("Accessing cluster: "+clustersec+"\nTargeting: "+trsection);
            allsection = ["projects","github-bind","git-sync-settings"];
            totaltab = allsection.length;
            for(let x = 1; x <= totaltab; x++){
                alltab.push(clustersec+"tab"+x);
            }
            body = document.getElementById(targetsection);
            switch(targetsection){
                case allsection[0]:
                    tab = document.getElementById(alltab[1]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                case allsection[1]:
                    tab = document.getElementById(alltab[2]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                case allsection[2]:
                    tab = document.getElementById(alltab[3]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                default:
                    console.log("invalid target section = "+trsection);
                    break;
            }
            break;
        case "pcs":
            console.log("Accessing cluster: "+clustersec+"\nTargeting: "+trsection);
            allsection = ["project-catalog","github-projects"];
            totaltab = allsection.length;
            for(let x = 1; x <= totaltab; x++){
                alltab.push(clustersec+"tab"+x);
            }
            body = document.getElementById(targetsection);
            switch(targetsection){
                case allsection[0]:
                    tab = document.getElementById(alltab[1]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                case allsection[1]:
                    tab = document.getElementById(alltab[2]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                default:
                    console.log("invalid target section = "+trsection);
                    break;
            }
            break;
        case "eas":
            console.log("Accessing cluster: "+clustersec+"\nTargeting: "+trsection);
            allsection = ["account"];
            totaltab = allsection.length;
            for(let x = 1; x <= totaltab; x++){
                alltab.push(clustersec+"tab"+x);
            }
            body = document.getElementById(targetsection);
            switch(targetsection){
                case allsection[0]:
                    tab = document.getElementById(alltab[1]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                default:
                    console.log("invalid target section = "+trsection);
                    break;
            }
            break;
        case "lhs":
            console.log("Accessing cluster: "+clustersec+"\nTargeting: "+trsection);
            allsection = ["log-history"];
            totaltab = allsection.length;
            for(let x = 1; x <= totaltab; x++){
                alltab.push(clustersec+"tab"+x);
            }
            body = document.getElementById(targetsection);
            switch(targetsection){
                case allsection[0]:
                    tab = document.getElementById(alltab[1]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                default:
                    console.log("invalid target section = "+trsection);
                    break;
            }
            break;
        case "beta"://template
            if(debuggmode){console.log("Accessing cluster: "+clustersec+"\nTargeting: "+trsection);}
            allsection = ["profile-image" , "action-image"];
            totaltab = 2;
            for(let x = 1; x <= totaltab; x++){
                alltab.push(clustersec+"tab"+x);
            }
            let teseract = -1;
            for(let x = 0;x < allsection.length;x++){
                if(allsection[x]==targetsection){
                    teseract = x;
                    break;
                }
            }
            switch(targetsection){
                case allsection[teseract]:
                    body = document.getElementById(allsection[teseract]);
                    tab = document.getElementById(alltab[teseract + 1]);
                    if (body && !body.classList.contains("current-section")){
                        allsection.forEach(secId => {
                            const secEl = document.getElementById(secId);
                            if (secEl) secEl.classList.remove("current-section");
                            if(debuggmode)console.log("section "+secEl+": current-section remove")
                        });
                        body.classList.add("current-section");
                        alltab.forEach(tabId => {
                            const tabEl = document.getElementById(tabId);
                            if (tabEl) tabEl.classList.remove("current-tab");
                        });
                        if (tab) tab.classList.add("current-tab");
                    } else if (!body) {
                        if(debuggmode)console.log("target section element not found: "+targetsection);
                    } else {
                        if(debuggmode)console.log("already on "+targetsection);
                    }
                    break;
                default:
                    if(debuggmode)console.log("invalid target section = "+trsection);
                    break;
            }
            break;
        default:
            if(debuggmode)console.log("Unknown section label =" + section);
            break;
    }
}