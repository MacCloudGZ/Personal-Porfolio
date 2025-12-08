<?php 
    session_start();
    include_once '../../Properties/database.php';
    include_once '../../Properties/api/functions.php';
    include_once '../../Properties/api/getFullname.php';
    include_once '../../Properties/api/getProfileImage.php';
    include_once '../../Properties/api/getMessage.php';
    include_once '../../Properties/api/getJobStatus.php';
    $user_id = 1; // Change as needed
    
    $full_name = getFullName($conn, $user_id);
    $main_image_path = getProfileImagePath($conn, $user_id);
    $messages_type2 = getMessagesType2($conn, $user_id);
    $job_status_label = getJobStatusLabel($conn, $user_id);


    // Extract all table data
    $Main_info = getTargetTable(1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Properties/Style/Loader.css">
    <link rel="stylesheet" href="../../Properties/Style/placeholder.css">
    <link rel="stylesheet" href="../../Properties/Style/main.css">
    <link rel="stylesheet" href="../header.css">
    <link rel="stylesheet" href="section.css">
    <script src="../../Properties/Script/spin.js" defer></script>
    <script src="../index.js" defer></script>

    <title>PortFolio</title>
</head>
<body>
    <div class="background-container" id="background">
        <article id="article">
            <div class="profile-container">
                <div class="profile-front">
                    <img id="profile-img" alt="image_profile">
                    <script>
                        <?php
                            // echo "const mainImagePath = '" . addslashes($main_image_path) . "';";
                            echo "const mainImagePath = '" . addslashes("/Personal-Porfolio/" . ltrim($main_image_path, '/')) . "';";

                        ?>
                        const imgEl =document.getElementById("profile-img");
                        const fallbackPath = "../../Properties/Images/Default_Profile.webp";

                        if (mainImagePath) {
                            fetch(mainImagePath, { method: 'HEAD' })
                                .then(response => {
                                    if (response.ok) {
                                        imgEl.src = mainImagePath;
                                    } else {
                                        imgEl.src =fallbackPath;
                                    }
                                })
                                .catch(() => {
                                    imgEl.src = fallbackPath;
                                });
                        } else {
                            imgEl.src = fallbackPath;
                        }
                    </script>
                </div>
                <div class="border_back"></div>
            </div>
            <div class="label-container">
                <?php echo $full_name?>
            </div>
            <div class="label-container">
				<hr>
                <table class="table">
                    <?php foreach ($Main_info as $key => $value) { ?>
                        <tr>
                            <td><?php echo $key?></td> 
                        <tr>
                        <tr>
                            <th>-</th> 
                            <td><?php echo $value?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="download-sv">
                <button class="cv" type="button" onclick="downloadCV()">
                    <span>DOWNLOAD CV</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 3V13M10 13L6 9M10 13L14 9M4 17H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </article>
        <div class="loading-container" id="idle">
            <span class="loader"></span>
            <span class="loading-txt">Loading...</span>
        </div>
        <section id="section" class="">
            <div class="header-section ">
                <div class="title-cart">PERSONAL PORTFOLIO</div>
                <div class="tabs-container">
                    <div class="tabs" id="Home" onclick="access_page('Projects','Home')">MAIN</div>
                    <div id="activetab" onclick="no('activetab')" class="tabs active">PROJECTS</div>
                    <div id="Contacts" onclick="access_page('Projects','Contacts')" class="tabs">CONTACTS</div>
                </div>
                <div class="edit-button" id="edit_button" onclick="edit_function()">
                    <svg id="editicon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" viewBox="0 0 494.936 494.936" xml:space="preserve">
                        <g>
                            <g>
                                <path id="editicon_box" d="M389.844,182.85c-6.743,0-12.21,5.467-12.21,12.21v222.968c0,23.562-19.174,42.735-42.736,42.735H67.157    c-23.562,0-42.736-19.174-42.736-42.735V150.285c0-23.562,19.174-42.735,42.736-42.735h267.741c6.743,0,12.21-5.467,12.21-12.21    s-5.467-12.21-12.21-12.21H67.157C30.126,83.13,0,113.255,0,150.285v267.743c0,37.029,30.126,67.155,67.157,67.155h267.741    c37.03,0,67.156-30.126,67.156-67.155V195.061C402.054,188.318,396.587,182.85,389.844,182.85z"/>
                                <path id="editicon_pen" d="M483.876,20.791c-14.72-14.72-38.669-14.714-53.377,0L221.352,229.944c-0.28,0.28-3.434,3.559-4.251,5.396l-28.963,65.069    c-2.057,4.619-1.056,10.027,2.521,13.6c2.337,2.336,5.461,3.576,8.639,3.576c1.675,0,3.362-0.346,4.96-1.057l65.07-28.963    c1.83-0.815,5.114-3.97,5.396-4.25L483.876,74.169c7.131-7.131,11.06-16.61,11.06-26.692    C494.936,37.396,491.007,27.915,483.876,20.791z M466.61,56.897L257.457,266.05c-0.035,0.036-0.055,0.078-0.089,0.107    l-33.989,15.131L238.51,247.3c0.03-0.036,0.071-0.055,0.107-0.09L447.765,38.058c5.038-5.039,13.819-5.033,18.846,0.005    c2.518,2.51,3.905,5.855,3.905,9.414C470.516,51.036,469.127,54.38,466.61,56.897z"/>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
            <div class="section-container">
                <div class="box-container" id="projects-list">
                    <div>PROJECTS</div>
                    <hr>
                </div>
                <div id="projects-items"></div>
            </div>
            <script>
                (function(){
                    const api = '../../Properties/api/project_manager.php?action=list_all';
                    function fmtDate(d){ return (d||'').slice(0,10); }
                    fetch(api)
                        .then(r=>r.json())
                        .then(j=>{
                            if (!j.success) return;
                            let globe_icon = '';
                            let lock_icon = '';
                            globe_icon += `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">` +
                                    `<circle cx="12" cy="12" r="10"/>`+
                                    `<path d="M2 12h20"/>`+
                                    `<path d="M12 2c3 3 4.5 6.5 4.5 10s-1.5 7-4.5 10c-3-3-4.5-6.5-4.5-10S9 5 12 2z"/>`+
                                `</svg>`;
                            lock_icon += `<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">`+
                                `<rect x="5" y="10" width="14" height="11" rx="2" stroke="#000000" stroke-width="2"/>`+
                                `<path d="M7 10V7C7 4.79086 8.79086 3 11 3H13C15.2091 3 17 4.79086 17 7V10" stroke="#000000" stroke-width="2" stroke-linecap="round"/>`+
                                `<path d="M12 18V15" stroke="#000000" stroke-width="2" stroke-linecap="round"/>`+
                                `</svg>`;
                            const rows = j.data || [];
                            const t = document.getElementById('projects-items');
                            let github_image = `<img src="../../Properties/Images/Github-logo.png"/>`;
                            let default_image = `<img src="../../Properties/Images/manual-default-icon.png"/>`; 
                            let html = '';
                            // `<div class="project_link" onclick="window.location.href='${projectUrl}'">Link</div>
                            for (const r of rows){
                                const projectUrl = r.url || '';
                                html += `<div class="project_box ${r.source} ${r.isvisible}" >`+
                                    `<div class="project_source">`;
                                switch(r.source){
                                    case "github":
                                        html += github_image +`</div>`;
                                        break;
                                    case "manual":
                                        html += default_image + `</div>`;
                                        break;
                                    default:
                                        html += `${r.source}</div>`;
                                        break;
                                }
                                html += `<div class="project_details">`+
                                    `<div class="project_name">${r.name ?? ''}</div>`+
                                    `<div class="project_discription">${r.description ?? ''}</div>`+
                                    `</div>`+
                                    `<div class="project_created">${fmtDate(r.created)}</div>`+
                                    `<div class="project_visibility">`;
                                switch(r.isvisible){
                                    case "public":
                                        html += globe_icon+`</div>`+
                                        `<div class="project_redirect" onclick="window.location.href='${projectUrl}'" title="Redirect to ${r.source}">link</div>`+
                                        `</div>`;
                                        break;
                                    case "private":
                                        html += lock_icon+`</div>`+
                                        `</div>`;
                                        break;5
                                    default:
                                        html += globe_icon + `/` + lock_icon+`</div>`+
                                        `<div class="project_redirect" onclick="window.location.href='${projectUrl}'" title="Redirect to Link">link</div>`+
                                        `</div>`;
                                        break;
                                }
                            }
                            t.innerHTML = html;
                        })
                        .catch(console.error);
                })();
            </script>
        </section>
        <div class="edit_container" id="edit_container">
            <div class="edit-box">
                <span>ENTER CREDENTIAL FOR EDIT ACCESS</span>
                <input type="text" id="edit_username" placeholder="Enter Username">
                <input type="password" id="edit_password" placeholder="Enter Password">
                <div class="edit-action">
                    <button class="edit-cancel" id="edit_cancel" onclick="close_edit()">CANCEL</button>
                    <button class="edit-submit" id="edit_submit" onclick="submit_edit()">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>