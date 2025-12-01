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
    $box4_info = getTargetTable(2);
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
        </article>
        <div class="loading-container" id="idle">
            <span class="loader"></span>
            <span class="loading-txt">Loading...</span>
        </div>
        <section id="section" class="">
            <div class="header-section ">
                <div class="title-cart">PERSONAL PORTFOLIO</div>
                <div class="tabs-container">
                    <div class="tabs" id="Home" onclick="access_page('Contacts','Home')">MAIN</div>
                    <div id="Projects" onclick="access_page('Contacts','Projects')" class="tabs">PROJECTS</div>
                    <div id="activetab" onclick="no('activetab')" class="tabs active">CONTACTS</div>
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
                <?php if (!empty($box4_info)) { ?>
                <div class="box-container" id="b4">
                    <div><?php echo getBoxTitle($box4_info); ?></div>
                    <hr>
                    <table class="datable">
                        <?php renderBoxRows($box4_info); ?>
                    </table>
                </div>
                <?php } ?> 
            </div>
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