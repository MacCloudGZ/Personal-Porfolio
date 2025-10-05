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
    $box1_info = getTargetTable(2);
    $box2_info = getTargetTable(3);
    $box3_info = getTargetTable(4);
    $box4_info = getTargetTable(5);
    $box5_info = getTargetTable(6);
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
                    <div class="tabs active" id="activetab" onclick="no('activetab')">MAIN</div>
                    <div id="Projects" onclick="access_page('Home','Projects')" class="tabs">PROJECTS</div>
                    <div id="Contacts" onclick="access_page('Home','Contacts')" class="tabs">CONTACTS</div>
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
                <!-- Main content boxes -->
                <div class="message-box" id="0">
                    <?php echo "<span>". implode(" ",$messages_type2) ."</span>"; ?>
                </div>
                <?php if (!empty($box1_info)) { ?>
                <?php 
                    $hasContacts = isset($box1_info['contacts']) && is_array($box1_info['contacts']);
                    $hasSkills = isset($box1_info['skills']) && is_array($box1_info['skills']);
                    $hasEducation = isset($box1_info['education']) && is_array($box1_info['education']);
                    $hasDescriptions = isset($box1_info['descriptions']) && is_array($box1_info['descriptions']);
                    $hasProfessions = isset($box1_info['professions']) && is_array($box1_info['professions']);

                    if ($hasContacts) {
                        $box1_title = 'CONTACT INFO';
                    } elseif ($hasSkills) {
                        $box1_title = 'SKILLS';
                    } elseif ($hasEducation) {
                        $box1_title = 'EDUCATIONAL BACKGROUND';
                    } elseif ($hasDescriptions) {
                        $box1_title = 'FUN / PERSONAL TOUCH';
                    } elseif ($hasProfessions) {
                        $box1_title = 'PROFESSION';
                    } else {
                        $box1_title = 'INFO';
                    }

                    $recognizedKeys = ['contacts','skills','education','descriptions','professions'];
                ?>
                <div class="box-container" id="b1">
                    <div><?php echo $box1_title; ?></div>
                    <hr>
                    <table class="table">
                        <?php if ($hasContacts): ?>
                            <?php foreach ($box1_info['contacts'] as $contact): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($contact['contact_type']); ?></td>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($contact['contact_value']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($hasSkills): ?>
                            <?php foreach ($box1_info['skills'] as $skill): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($skill['skill_name']); ?></td>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($skill['proficiency_level']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($hasEducation): ?>
                            <?php foreach ($box1_info['education'] as $edu): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($edu['institution_info']); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars(($edu['start_date'] ?? '') . (isset($edu['end_date']) && $edu['end_date'] ? ' to ' . $edu['end_date'] : '')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($hasDescriptions): ?>
                            <?php foreach ($box1_info['descriptions'] as $desc): ?>
                                <tr>
                                    <td> - <?php echo htmlspecialchars($desc); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($hasProfessions): ?>
                            <?php foreach ($box1_info['professions'] as $prof): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($prof['job_title']); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($prof['company_name'] ?? ''); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars(($prof['start_date'] ?? '') . (isset($prof['end_date']) && $prof['end_date'] ? ' to ' . $prof['end_date'] : ($prof['is_current'] ? ' (Current)' : ''))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php foreach ($box1_info as $genericKey => $genericValue): ?>
                            <?php if (!in_array($genericKey, $recognizedKeys, true)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', (string)$genericKey))); ?></td>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars(is_array($genericValue) ? json_encode($genericValue) : (string)$genericValue); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php } ?>
                <?php if (!empty($box3_info)) { ?>
                <?php 
                    $b2HasContacts = isset($box3_info['contacts']) && is_array($box3_info['contacts']);
                    $b2HasSkills = isset($box3_info['skills']) && is_array($box3_info['skills']);
                    $b2HasEducation = isset($box3_info['education']) && is_array($box3_info['education']);
                    $b2HasDescriptions = isset($box3_info['descriptions']) && is_array($box3_info['descriptions']);
                    $b2HasProfessions = isset($box3_info['professions']) && is_array($box3_info['professions']);

                    if ($b2HasContacts) {
                        $box2_title = 'CONTACT INFO';
                    } elseif ($b2HasSkills) {
                        $box2_title = 'SKILLS';
                    } elseif ($b2HasEducation) {
                        $box2_title = 'EDUCATIONAL BACKGROUND';
                    } elseif ($b2HasDescriptions) {
                        $box2_title = 'FUN / PERSONAL TOUCH';
                    } elseif ($b2HasProfessions) {
                        $box2_title = 'PROFESSION';
                    } else {
                        $box2_title = 'INFO';
                    }

                    $b2RecognizedKeys = ['contacts','skills','education','descriptions','professions'];
                ?>
                <div class="box-container" id="b2">
                    <div><?php echo $box2_title; ?></div>
                    <hr>
                    <table class="table">
                        <?php if ($b2HasContacts): ?>
                            <?php foreach ($box3_info['contacts'] as $contact): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($contact['contact_type']); ?></td>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($contact['contact_value']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($b2HasSkills): ?>
                            <?php foreach ($box3_info['skills'] as $skill): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($skill['skill_name']); ?></td>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($skill['proficiency_level']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($b2HasEducation): ?>
                            <?php foreach ($box3_info['education'] as $edu): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($edu['institution_info']); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars(($edu['start_date'] ?? '') . (isset($edu['end_date']) && $edu['end_date'] ? ' to ' . $edu['end_date'] : '')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($b2HasDescriptions): ?>
                            <?php foreach ($box3_info['descriptions'] as $desc): ?>
                                <tr>
                                    <td> - <?php echo htmlspecialchars($desc); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($b2HasProfessions): ?>
                            <?php foreach ($box3_info['professions'] as $prof): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($prof['job_title']); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($prof['company_name'] ?? ''); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars(($prof['start_date'] ?? '') . (isset($prof['end_date']) && $prof['end_date'] ? ' to ' . $prof['end_date'] : ($prof['is_current'] ? ' (Current)' : ''))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php foreach ($box3_info as $genericKey => $genericValue): ?>
                            <?php if (!in_array($genericKey, $b2RecognizedKeys, true)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', (string)$genericKey))); ?></td>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars(is_array($genericValue) ? json_encode($genericValue) : (string)$genericValue); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php } ?>
                <div class="box-container" id="b3">
                    <?php if (!empty($box5_info)) { ?>
                        <?php 
                            $b3aHasContacts = isset($box5_info['contacts']) && is_array($box5_info['contacts']);
                            $b3aHasSkills = isset($box5_info['skills']) && is_array($box5_info['skills']);
                            $b3aHasEducation = isset($box5_info['education']) && is_array($box5_info['education']);
                            $b3aHasDescriptions = isset($box5_info['descriptions']) && is_array($box5_info['descriptions']);
                            $b3aHasProfessions = isset($box5_info['professions']) && is_array($box5_info['professions']);

                            if ($b3aHasContacts) {
                                $box3a_title = 'CONTACT INFO';
                            } elseif ($b3aHasSkills) {
                                $box3a_title = 'SKILLS';
                            } elseif ($b3aHasEducation) {
                                $box3a_title = 'EDUCATIONAL BACKGROUND';
                            } elseif ($b3aHasDescriptions) {
                                $box3a_title = 'FUN / PERSONAL TOUCH';
                            } elseif ($b3aHasProfessions) {
                                $box3a_title = 'PROFESSION';
                            } else {
                                $box3a_title = 'INFO';
                            }

                            $b3aRecognizedKeys = ['contacts','skills','education','descriptions','professions'];
                        ?>
                        <div><?php echo $box3a_title; ?></div>
                        <hr>
                        <table class="table">
                            <?php if ($b3aHasContacts): ?>
                                <?php foreach ($box5_info['contacts'] as $contact): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($contact['contact_type']); ?></td>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars($contact['contact_value']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($b3aHasSkills): ?>
                                <?php foreach ($box5_info['skills'] as $skill): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($skill['skill_name']); ?></td>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars($skill['proficiency_level']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($b3aHasEducation): ?>
                                <?php foreach ($box5_info['education'] as $edu): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($edu['institution_info']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars(($edu['start_date'] ?? '') . (isset($edu['end_date']) && $edu['end_date'] ? ' to ' . $edu['end_date'] : '')); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($b3aHasDescriptions): ?>
                                <?php foreach ($box5_info['descriptions'] as $desc): ?>
                                    <tr>
                                        <td> - <?php echo htmlspecialchars($desc); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($b3aHasProfessions): ?>
                                <?php foreach ($box5_info['professions'] as $prof): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($prof['job_title']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars($prof['company_name'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars(($prof['start_date'] ?? '') . (isset($prof['end_date']) && $prof['end_date'] ? ' to ' . $prof['end_date'] : ($prof['is_current'] ? ' (Current)' : ''))); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php foreach ($box5_info as $genericKey => $genericValue): ?>
                                <?php if (!in_array($genericKey, $b3aRecognizedKeys, true)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', (string)$genericKey))); ?></td>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars(is_array($genericValue) ? json_encode($genericValue) : (string)$genericValue); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </table>
                    <?php } ?>
                    <br>
                    <?php if (!empty($box2_info)) { ?>
                        <?php 
                            $b3bHasContacts = isset($box2_info['contacts']) && is_array($box2_info['contacts']);
                            $b3bHasSkills = isset($box2_info['skills']) && is_array($box2_info['skills']);
                            $b3bHasEducation = isset($box2_info['education']) && is_array($box2_info['education']);
                            $b3bHasDescriptions = isset($box2_info['descriptions']) && is_array($box2_info['descriptions']);
                            $b3bHasProfessions = isset($box2_info['professions']) && is_array($box2_info['professions']);

                            if ($b3bHasContacts) {
                                $box3b_title = 'CONTACT INFO';
                            } elseif ($b3bHasSkills) {
                                $box3b_title = 'SKILLS';
                            } elseif ($b3bHasEducation) {
                                $box3b_title = 'EDUCATIONAL BACKGROUND';
                            } elseif ($b3bHasDescriptions) {
                                $box3b_title = 'FUN / PERSONAL TOUCH';
                            } elseif ($b3bHasProfessions) {
                                $box3b_title = 'PROFESSION';
                            } else {
                                $box3b_title = 'INFO';
                            }

                            $b3bRecognizedKeys = ['contacts','skills','education','descriptions','professions'];
                        ?>
                        <div><?php echo $box3b_title; ?></div>
                        <hr>
                        <table class="table">
                            <?php if ($b3bHasContacts): ?>
                                <?php foreach ($box2_info['contacts'] as $contact): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($contact['contact_type']); ?></td>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars($contact['contact_value']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($b3bHasSkills): ?>
                                <?php foreach ($box2_info['skills'] as $skill): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($skill['skill_name']); ?></td>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars($skill['proficiency_level']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($b3bHasEducation): ?>
                                <?php foreach ($box2_info['education'] as $edu): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($edu['institution_info']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars(($edu['start_date'] ?? '') . (isset($edu['end_date']) && $edu['end_date'] ? ' to ' . $edu['end_date'] : '')); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($b3bHasDescriptions): ?>
                                <?php foreach ($box2_info['descriptions'] as $desc): ?>
                                    <tr>
                                        <td> - <?php echo htmlspecialchars($desc); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($b3bHasProfessions): ?>
                                <?php foreach ($box2_info['professions'] as $prof): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($prof['job_title']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars($prof['company_name'] ?? ''); ?></td>
                                    </tr>
                                    <tr>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars(($prof['start_date'] ?? '') . (isset($prof['end_date']) && $prof['end_date'] ? ' to ' . $prof['end_date'] : ($prof['is_current'] ? ' (Current)' : ''))); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php foreach ($box2_info as $genericKey => $genericValue): ?>
                                <?php if (!in_array($genericKey, $b3bRecognizedKeys, true)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', (string)$genericKey))); ?></td>
                                        <th>-</th>
                                        <td><?php echo htmlspecialchars(is_array($genericValue) ? json_encode($genericValue) : (string)$genericValue); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </table>                    
                    <?php } ?>
                </div>
                <?php if (!empty($box4_info)) { ?>
                <?php 
                    $b4HasContacts = isset($box4_info['contacts']) && is_array($box4_info['contacts']);
                    $b4HasSkills = isset($box4_info['skills']) && is_array($box4_info['skills']);
                    $b4HasEducation = isset($box4_info['education']) && is_array($box4_info['education']);
                    $b4HasDescriptions = isset($box4_info['descriptions']) && is_array($box4_info['descriptions']);
                    $b4HasProfessions = isset($box4_info['professions']) && is_array($box4_info['professions']);

                    if ($b4HasContacts) {
                        $box4_title = 'CONTACT INFO';
                    } elseif ($b4HasSkills) {
                        $box4_title = 'SKILLS';
                    } elseif ($b4HasEducation) {
                        $box4_title = 'EDUCATIONAL BACKGROUND';
                    } elseif ($b4HasDescriptions) {
                        $box4_title = 'FUN / PERSONAL TOUCH';
                    } elseif ($b4HasProfessions) {
                        $box4_title = 'PROFESSION';
                    } else {
                        $box4_title = 'INFO';
                    }

                    $b4RecognizedKeys = ['contacts','skills','education','descriptions','professions'];
                ?>
                <div class="box-container" id="b4">
                    <div><?php echo $box4_title; ?></div>
                    <hr>
                    <table class="table">
                        <?php if ($b4HasContacts): ?>
                            <?php foreach ($box4_info['contacts'] as $contact): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($contact['contact_type']); ?></td>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($contact['contact_value']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($b4HasSkills): ?>
                            <?php foreach ($box4_info['skills'] as $skill): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($skill['skill_name']); ?></td>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($skill['proficiency_level']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($b4HasEducation): ?>
                            <?php foreach ($box4_info['education'] as $edu): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($edu['institution_info']); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($edu['degree'] ?? ''); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars(($edu['start_date'] ?? '') . (isset($edu['end_date']) && $edu['end_date'] ? ' to ' . $edu['end_date'] : '')); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($b4HasDescriptions): ?>
                            <?php foreach ($box4_info['descriptions'] as $desc): ?>
                                <tr>
                                    <td> - <?php echo htmlspecialchars($desc); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($b4HasProfessions): ?>
                            <?php foreach ($box4_info['professions'] as $prof): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($prof['job_title']); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars($prof['company_name'] ?? ''); ?></td>
                                </tr>
                                <tr>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars(($prof['start_date'] ?? '') . (isset($prof['end_date']) && $prof['end_date'] ? ' to ' . $prof['end_date'] : ($prof['is_current'] ? ' (Current)' : ''))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php foreach ($box4_info as $genericKey => $genericValue): ?>
                            <?php if (!in_array($genericKey, $b4RecognizedKeys, true)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', (string)$genericKey))); ?></td>
                                    <th>-</th>
                                    <td><?php echo htmlspecialchars(is_array($genericValue) ? json_encode($genericValue) : (string)$genericValue); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
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