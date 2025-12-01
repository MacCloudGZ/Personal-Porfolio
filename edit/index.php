<?php
    session_start();
    if (!isset($_SESSION['edit_permitted']) || $_SESSION['edit_permitted'] !== true) {
        header('Location: ../Error.html');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="../Properties/Style/main.css">
    <script src="index.js" defer></script>
    <script src="tabs.js" defer></script>
    <title>Portfolio Editor</title>
</head>
<body>
    <header>
        <h1>PORTFOLIO EDIT</h1>
        <div class="con">
            <button id="finished-btn">
                <span>Finished</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>

            </button>
            <?php
                // Use server-side origin if present to survive refresh
                $from = isset($_SESSION['edit_origin']) ? $_SESSION['edit_origin'] : null;
                if ($from) {
                    echo '<script>window.__EDIT_ORIGIN__ = ' . json_encode($from) . ';</script>';
                }
            ?>
        </div>
    </header>
    <article>
        <aside>
            <div class="icons-container">
                <div class="icon-handler active" data-target="file-image">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10 4H4a2 2 0 0 0-2 2v12c0 1.1.9 2 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-8l-2-2z"/>
                        </svg>
                    </div>
                    <div class="icon-name">Files and Images</div>
                </div>
                <div class="icon-handler" data-target="personal-information">
                    <div class="icon">
                        <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M9.6,3.32a3.86,3.86,0,1,0,3.86,3.85A3.85,3.85,0,0,0,9.6,3.32M16.35,11a.26.26,0,0,0-.25.21l-.18,1.27a4.63,4.63,0,0,0-.82.45l-1.2-.48a.3.3,0,0,0-.3.13l-1,1.66a.24.24,0,0,0,.06.31l1,.79a3.94,3.94,0,0,0,0,1l-1,.79a.23.23,0,0,0-.06.3l1,1.67c.06.13.19.13.3.13l1.2-.49a3.85,3.85,0,0,0,.82.46l.18,1.27a.24.24,0,0,0,.25.2h1.93a.24.24,0,0,0,.23-.2l.18-1.27a5,5,0,0,0,.81-.46l1.19.49c.12,0,.25,0,.32-.13l1-1.67a.23.23,0,0,0-.06-.3l-1-.79a4,4,0,0,0,0-.49,2.67,2.67,0,0,0,0-.48l1-.79a.25.25,0,0,0,.06-.31l-1-1.66c-.06-.13-.19-.13-.31-.13L19.5,13a4.07,4.07,0,0,0-.82-.45l-.18-1.27a.23.23,0,0,0-.22-.21H16.46M9.71,13C5.45,13,2,14.7,2,16.83v1.92h9.33a6.65,6.65,0,0,1,0-5.69A13.56,13.56,0,0,0,9.71,13m7.6,1.43a1.45,1.45,0,1,1,0,2.89,1.45,1.45,0,0,1,0-2.89Z">
                                </path>
                            </g>
                        </svg>
                    </div>
                    <div class="icon-name">Personal Information</div>
                </div>
                <div class="icon-handler" data-target="project-managers">
                    <div class="icon">
                        <svg viewBox="0 -8.25 512 512" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"> 
                                <defs> 
                                    <style>.cls-1{fill:none;stroke:#000000;stroke-linecap:round;stroke-linejoin:round;stroke-width:20px;}</style> 
                                </defs>
                                 <g data-name="Layer 2" id="Layer_2"> 
                                    <g data-name="E440, Archive, cabinet, drawer" id="E440_Archive_cabinet_drawer"> 
                                        <path class="cls-1" d="M371.47,304.77l-20.08,40.16H160.61l-20.08-40.16H40.12A30.12,30.12,0,0,0,10,334.89V455.38A30.12,30.12,0,0,0,40.12,485.5H471.88A30.12,30.12,0,0,0,502,455.38V334.89a30.12,30.12,0,0,0-30.12-30.12Z"></path> 
                                        <rect class="cls-1" height="40.16" rx="20.08" width="251.02" x="130.49" y="395.14"></rect> 
                                        <path class="cls-1" d="M502,324.85,456.49,88.22a30.13,30.13,0,0,0-29.58-24.43H254.05"></path> 
                                        <path class="cls-1" d="M10,324.85,55.5,88.22a30.13,30.13,0,0,1,25-24.08"></path> 
                                        <path class="cls-1" d="M80.29,304.77v-99a21.51,21.51,0,0,1,21.51-21.52H215.71A21.5,21.5,0,0,1,236,198.6l17.84,39.47H410.2a21.51,21.51,0,0,1,21.51,21.51v45.19"></path> 
                                        <path class="cls-1" d="M80.29,304.77v-180a21.5,21.5,0,0,1,21.51-21.51H215.71A21.51,21.51,0,0,1,236,117.55L253.82,157H410.2a21.51,21.51,0,0,1,21.51,21.52V304.77"></path> 
                                        <path class="cls-1" d="M431.71,253.45a21,21,0,0,0,.25-3.19V85.31a21.52,21.52,0,0,0-21.52-21.52H254.05L236.22,24.32A21.5,21.5,0,0,0,216,10H102A21.51,21.51,0,0,0,80.53,31.52v90"></path> 
                                    </g> 
                                </g> 
                            </g>
                        </svg>
                    </div>
                    <div class="icon-name">Projects Managers</div>
                </div>
                <div class="icon-handler" data-target="project-catalog">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 3h18v2H3V3zm0 4h18v2H3V7zm0 4h12v2H3v-2zm0 4h12v2H3v-2z"/></svg>
                    </div>
                    <div class="icon-name">Projects Catalog</div>
                </div>
                <div class="icon-handler" data-target="edit-access">
                    <div class="icon">
                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"> 
                                <defs> 
                                    <style>.cls-1{fill:none;stroke:#000000;stroke-linecap:round;stroke-linejoin:round;stroke-width:20px;}</style> 
                                </defs> 
                                <g data-name="Layer 2" id="Layer_2"> 
                                    <g data-name="E428, Control, media, multimedia, player, stop" id="E428_Control_media_multimedia_player_stop"> 
                                        <rect class="cls-1" height="492" rx="50.2" width="492" x="10" y="10"></rect> 
                                        <line class="cls-1" x1="87.59" x2="87.59" y1="391.67" y2="232.61"></line> 
                                        <line class="cls-1" x1="87.59" x2="87.59" y1="157.76" y2="120.33"></line> 
                                        <circle class="cls-1" cx="87.59" cy="195.18" r="37.42"></circle> 
                                        <line class="cls-1" x1="199.86" x2="199.86" y1="391.67" y2="351.39"></line> 
                                        <line class="cls-1" x1="199.86" x2="199.86" y1="276.54" y2="120.33"></line> 
                                        <circle class="cls-1" cx="199.86" cy="313.96" r="37.42"></circle> 
                                        <line class="cls-1" x1="312.14" x2="312.14" y1="391.67" y2="232.61"></line> 
                                        <line class="cls-1" x1="312.14" x2="312.14" y1="157.76" y2="120.33"></line> 
                                        <circle class="cls-1" cx="312.14" cy="195.18" r="37.42"></circle> 
                                        <line class="cls-1" x1="424.41" x2="424.41" y1="391.67" y2="305.75"></line> 
                                        <line class="cls-1" x1="424.41" x2="424.41" y1="230.9" y2="120.33"></line> 
                                        <circle class="cls-1" cx="424.41" cy="268.32" r="37.42"></circle> 
                                    </g> 
                                </g> 
                            </g>
                        </svg>
                    </div>
                    <div class="icon-name">Edit Access</div>
                </div>
                <div class="icon-handler" data-target="logs-history">
                    <div class="icon">
                        <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"> 
                                <defs> 
                                    <style>
                                        .cls-1{
                                            fill:none;
                                            stroke:#000000;
                                            stroke-linecap:round;
                                            stroke-linejoin:round;
                                            stroke-width:20px;
                                        }
                                    </style> 
                                </defs> 
                                <g data-name="Layer 2" id="Layer_2"> 
                                    <g data-name="E425, History, log, manuscript" id="E425_History_log_manuscript"> 
                                        <path class="cls-1" d="M75.11,117h0A21.34,21.34,0,0,1,53.83,95.57V31.39A21.34,21.34,0,0,1,75.11,10h0A21.34,21.34,0,0,1,96.39,31.39V95.57A21.34,21.34,0,0,1,75.11,117Z"></path> 
                                        <rect class="cls-1" height="64.17" width="319.22" x="96.39" y="31.39"></rect> 
                                        <rect class="cls-1" height="320.87" width="319.22" x="96.39" y="95.57"></rect> 
                                        <path class="cls-1" d="M34.34,39.08H53.83a0,0,0,0,1,0,0v48.8a0,0,0,0,1,0,0H34.34A24.34,24.34,0,0,1,10,63.54v-.13A24.34,24.34,0,0,1,34.34,39.08Z"></path> 
                                        <path class="cls-1" d="M436.89,117h0a21.34,21.34,0,0,0,21.28-21.39V31.39A21.34,21.34,0,0,0,436.89,10h0a21.34,21.34,0,0,0-21.28,21.39V95.57A21.34,21.34,0,0,0,436.89,117Z"></path> 
                                        <path class="cls-1" d="M482.51,39.08H502a0,0,0,0,1,0,0v48.8a0,0,0,0,1,0,0H482.51a24.34,24.34,0,0,1-24.34-24.34v-.13a24.34,24.34,0,0,1,24.34-24.34Z" transform="translate(960.17 126.96) rotate(-180)"></path> 
                                        <path class="cls-1" d="M75.11,395h0a21.34,21.34,0,0,0-21.28,21.39v64.18A21.34,21.34,0,0,0,75.11,502h0a21.34,21.34,0,0,0,21.28-21.39V416.43A21.34,21.34,0,0,0,75.11,395Z"></path> 
                                        <rect class="cls-1" height="64.17" width="319.22" x="96.39" y="416.43"></rect> 
                                        <path class="cls-1" d="M34.34,424.12H53.83a0,0,0,0,1,0,0v48.8a0,0,0,0,1,0,0H34.34A24.34,24.34,0,0,1,10,448.58v-.13A24.34,24.34,0,0,1,34.34,424.12Z"></path> 
                                        <path class="cls-1" d="M436.89,395h0a21.34,21.34,0,0,1,21.28,21.39v64.18A21.34,21.34,0,0,1,436.89,502h0a21.34,21.34,0,0,1-21.28-21.39V416.43A21.34,21.34,0,0,1,436.89,395Z"></path> 
                                        <path class="cls-1" d="M482.51,424.12H502a0,0,0,0,1,0,0v48.8a0,0,0,0,1,0,0H482.51a24.34,24.34,0,0,1-24.34-24.34v-.13a24.34,24.34,0,0,1,24.34-24.34Z" transform="translate(960.17 897.04) rotate(-180)"></path> 
                                        <line class="cls-1" x1="143.41" x2="256" y1="140.11" y2="140.11"></line> 
                                        <line class="cls-1" x1="143.41" x2="371.26" y1="186.47" y2="186.47"></line> 
                                        <line class="cls-1" x1="143.41" x2="371.26" y1="232.82" y2="232.82"></line> 
                                        <line class="cls-1" x1="143.41" x2="371.26" y1="279.18" y2="279.18"></line> 
                                        <line class="cls-1" x1="143.41" x2="371.26" y1="325.53" y2="325.53"></line> 
                                        <line class="cls-1" x1="256" x2="371.26" y1="371.89" y2="371.89"></line> 
                                    </g> 
                                </g> 
                            </g>
                        </svg>
                    </div>
                    <div class="icon-name">Logs History</div>
                </div>
            </div>
        </aside>
        <div class="sections-background-container active" id="file-image-section">
            <div class="header-tab-handler">
                <div class="header-tab current-tab" id="fis-tab-1" onclick="areafunction('fis','profile-image')">
                    <h3>Profile Image</h3>
                </div>
                <div class="header-tab" id="fis-tab-2" onclick="areafunction('fis','cv-files')">
                    <h3>CV / Files</h3>
                </div>
            </div> 
            <section id="profile-image" class="current-section">
                <form id="image-upload-form" enctype="multipart/form-data">
                    <input type="hidden" name="entity" value="main_images">
                    <input type="hidden" name="action" value="upload">
                    <input type="hidden" name="id" value="1">
                    <div class="mega_box">
                            <label for="profile-image-file .bns">Choose image (JPG/PNG/WEBP, max 5MB)</label>
                            <input type="file" id="profile-image-file" name="file" accept="image/*" required>
                    </div>
                    <button type="submit">Upload Image</button>
                </form>
            </section>
            <section id="cv-files">
                <div id="cv-list"></div>
                <form id="cv-upload-form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="1">
                    <div class="mega_box">
                        <label for="cv-file">Choose file (PDF/ZIP, max 10MB)</label>
                        <input type="file" id="cv-file" name="file" accept=".pdf,.zip" required>
                    </div>
                    <button type="submit">Upload CV/File</button>
                </form>
            </section>
        </div>
        <div class="sections-background-container" id="personal-information-section">
            <div class="header-tab-handler">
                <div class="header-tab current-tab" id="pis-tab-1" onclick="areafunction('pis','personal-info')">
                    <h3>Personal Information</h3>
                </div>
                <div class="header-tab" id="pis-tab-2" onclick="areafunction('pis','address')">
                    <h3>Address</h3>
                </div>
                <div class="header-tab" id="pis-tab-3" onclick="areafunction('pis','contact-info')">
                    <h3>Contact Information</h3>
                </div>
                <div class="header-tab" id="pis-tab-4" onclick="areafunction('pis','education')">
                    <h3>Educational Background</h3>
                </div>
                <div class="header-tab" id="pis-tab-5" onclick="areafunction('pis','skills')">
                    <h3>Skills</h3>
                </div>
                <div class="header-tab" id="pis-tab-6" onclick="areafunction('pis','personal-touch')">
                    <h3>Fun / Personal Touch</h3>
                </div>
                <div class="header-tab" id="pis-tab-7" onclick="areafunction('pis','messages')">
                    <h3>Message Data</h3>
                </div>
            </div> 
            <section id="personal-info" class="current-section">
                <form id="personal-form">
                    <input type="hidden" id="personal-id" value="1">
                    <div class="mega_box">
                        <div class="box">
                            <label for="firstname">First Name:</label>
                            <input type="text" id="firstname" name="firstname" required>
                        </div>
                        <div class="box">
                            <label for="middlename">Middle Name:</label>
                            <input type="text" id="middlename" name="middlename">
                        </div>  
                        <div class="box">
                            <label for="lastname">Last Name:</label>
                            <input type="text" id="lastname" name="lastname" required>
                        </div>
                        <div class="box">
                            <label for="suffix">Suffix:</label>
                            <input type="text" id="suffix" name="suffix">
                        </div>
                    </div>
                    <div class="mega_box">
                        <div class="box"> 
                            <label for="birthdate">Birth Date:</label>
                            <input type="date" id="birthdate" name="birthdate">
                        </div>
                        <div class="box">
                            <label for="sex">Sex:</label>
                            <select id="sex" name="sex">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="box">
                            <label for="status_id">Job Status:</label>
                            <select id="status_id" name="status_id">
                                <option value="1">Employed</option>
                                <option value="2">Free-Lance</option>
                                <option value="3">Unemployed</option>
                                <option value="4">Retired</option>
                            </select>
                        </div>
                        </select>
                    </div>
                    <button type="submit">Update Personal Info</button>
                </form>
            </section>
            <section id="address">
                <form id="address-form">
                    <div class="mega_box">
                        <div id="address-list">
                            <!-- Address data will be loaded here -->
                        </div>
                    </div>
                    <div class="mega_box">
                        <div class="box">
                            <input type="hidden" id="address-person-id" value="1">
                        </div>
                        <div class="box">
                            <label for="address_line1">Address Line 1:</label>
                            <input type="text" id="address_line1" name="address_line1" required>
                        </div>
                        <div class="box">
                            <label for="address_line2">Address Line 2:</label>
                            <input type="text" id="address_line2" name="address_line2">
                        </div>
                        <div class="box">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" required>
                        </div>
                        <div class="box">
                            <label for="state">State:</label>
                            <input type="text" id="state" name="state" required>
                        </div>
                        <div class="box">
                            <label for="zip_code">Zip Code:</label>
                            <input type="text" id="zip_code" name="zip_code" required>
                        </div>
                        <div class="box">
                            <label for="country">Country:</label>
                            <input type="text" id="country" name="country" required>
                        </div>
                    </div>
                    <button type="submit">Save Address</button>
                </form>
            </section>
            <section id="contact-info">
                    <div class="mega_box">
                        <h3>Contact Information</h3>
                        <div id="contact-list">
                            <!-- Contact items will be dynamically loaded here -->
                        </div>
                    </div>
                <form id="contact-form">
                    <input type="hidden" id="contact-person-id" value="1">
                    <div class="mega_box">
                        <h3>Add New Contact</h3>
                        <div class="box">
                            <label for="contact-type">Contact Type:</label>
                            <input type="text" id="contact-type" name="contact_type" required>                
                        </div>
                        <div class="box">
                            <label for="contact-value">Contact Value:</label>  
                            <input type="text" id="contact-value" name="contact_value" required>    
                        </div>
                    </div>                
                    <button type="submit">Add Contact</button>
                </form>
            </section>
            <section id="education">
                <div id="education-list">
                    <!-- Education items will be dynamically loaded here -->
                </div>
                
                <h3>Add New Education</h3>
                <form id="education-form">
                    <input type="hidden" id="education-person-id" value="1">
                    
                    <label for="institution-name">Institution Name:</label>
                    <input type="text" id="institution-name" name="institution_name" required>
                    
                    <label for="degree">Degree:</label>
                    <input type="text" id="degree" name="degree">
                    
                    <label for="field-of-study">Field of Study:</label>
                    <input type="text" id="field-of-study" name="field_of_study">
                    
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start-date" name="start_date">
                    
                    <label for="end-date">End Date:</label>
                    <input type="date" id="end-date" name="end_date">
                    
                    <button type="submit">Add Education</button>
                </form>
            </section>
            <section id="skills">
                <div id="skills-list">
                    <!-- Skills will be dynamically loaded here -->
                </div>
                
                <h3>Add New Skill</h3>
                <form id="skills-form">
                    <input type="hidden" id="skills-person-id" value="1">
                    
                    <label for="skill-name">Skill Name:</label>
                    <input type="text" id="skill-name" name="skill_name" required>
                    
                    <label for="proficiency-level">Proficiency Level (1-10):</label>
                    <input type="number" id="proficiency-level" name="proficiency_level" min="1" max="10" required>
                    
                    <button type="submit">Add Skill</button>
                </form>
            </section>
            <section id="personal-touch">
                <div id="personal-touch-list">
                    <!-- Personal touch items will be dynamically loaded here -->
                </div>
                
                <h3>Add New Personal Touch</h3>
                <form id="personal-touch-form">
                    <input type="hidden" id="touch-person-id" value="1">
                    
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                    
                    <button type="submit">Add Personal Touch</button>
                </form>
            </section>
            <section id="messages">
                <div id="messages-list">
                    <!-- Messages will be dynamically loaded here -->
                </div>
                
                <h3>Add New Message</h3>
                <form id="messages-form">
                    <input type="hidden" id="message-person-id" value="1">
                    
                    <label for="message-text">Message Text:</label>
                    <textarea id="message-text" name="message_text" rows="4" required></textarea>
                    
                    <label for="message-type">Message Type:</label>
                    <input type="number" id="message-type" name="message_type" required>
                    
                    <button type="submit">Add Message</button>
                </form>
            </section>

            <!-- Main Images excluded by request -->
        </div>
        <div class="sections-background-container" id="project-managers-section">
            <div class="header-tab-handler">
                <div class="header-tab current-tab" id="pms-tab-1" onclick="areafunction('pms','projects')">
                    <h3>Manual Projects</h3>
                </div>
                <div class="header-tab" id="pms-tab-2" onclick="areafunction('pms','github-bind')">
                    <h3>GitHub Account Binds</h3>
                </div>
                <div class="header-tab" id="pms-tab-2" onclick="areafunction('pms','git-sync-settings')">
                    <h3>Sync Settings</h3>
                </div>
            </div> 
            <section id="projects" class="current-section">
                <div class="mega_box">
                    <form id="manual-project-form">
                        <input type="hidden" id="manual-project-id">
                        <div class="box">
                            <label for="manual-project-name">Project Name:</label>
                            <input type="text" id="manual-project-name" required>
                        </div>
                        <div class="box">
                            <label for="manual-project-desc">Description:</label>
                            <textarea id="manual-project-desc" rows="3"></textarea>
                        </div>
                        <div class="box">
                            <label for="manual-project-date">Date Created:</label>
                            <input type="date" id="manual-project-date" required>
                        </div>
                        <div class="box">
                            <label for="manual-project-visible">Visibility:</label>
                            <select id="manual-project-visible">
                                <option value="public">public</option>
                                <option value="private">private</option>
                                <option value="partially">partially</option>
                            </select>
                        </div>
                        <button type="submit" id="manual-save-btn">Save Project</button>
                        <button type="button" id="manual-reset-btn">Reset</button>
                    </form>
                    <table class="table" id="manual-projects-table"></table>
                </div>
            </section>
            <section id="github-bind">
                <div class="mega_box">
                    <form id="bind-form">
                        <input type="hidden" id="bind-id">
                        <div class="box">
                            <label for="bind-link">GitHub Profile URL:</label>
                            <input type="url" id="bind-link" placeholder="https://github.com/<username>" required>
                        </div>
                        <button type="submit" id="bind-save-btn">Add Bind</button>
                        <button type="button" id="bind-reset-btn">Reset</button>
                    </form>
                    <table class="table" id="binds-table"></table>
                </div>
            </section>
            <section id="git-sync-settings">
                <div class="mega_box">
                    <form id="config-form">
                        <div class="box">
                            <label for="cfg-time">Update Time:</label>
                            <input type="time" id="cfg-time" required>
                        </div>
                        <div class="box">
                            <label for="cfg-schedule">Schedule:</label>
                            <select id="cfg-schedule">
                                <option value="day">day</option>
                                <option value="week">week</option>
                                <option value="month">month</option>
                            </select>
                        </div>
                        <button type="submit" id="cfg-save-btn">Save Config</button>
                        <button type="button" id="sync-now-btn">Sync Now</button>
                    </form>
                    <div class="box">
                        <small>Sync Now sequence: clears `temp_github_project`, then refills from GitHub using bound accounts.</small>
                    </div>
                </div>
            </section>
        </div>
        <div class="sections-background-container" id="project-catalog-section">
            <div class="header-tab-handler">
                <div class="header-tab current-tab" id="pcs-tab-1" onclick="areafunction('pcs','project-catalog')">
                    <h3>Projects Catalog</h3>
                </div>
                <div class="header-tab" id="pcs-tab-2" onclick="areafunction('pcs','github-projects')">
                    <h3>GitHub Projects (Read-only)</h3>
                </div>
            </div> 
            <section id="project-catalog" class="current-section">
                <div class="mega_box">
                    <table class="table" id="catalog-table"></table>
                </div>
                <script>
                    (function(){
                        const api = '../Properties/api/project_manager.php';
                        function fmtDate(d){ return (d||'').slice(0,10); }
                        function loadCatalog(){
                            fetch(`${api}?action=list_all`).then(r=>r.json()).then(j=>{
                                if (!j.success) return;
                                const rows = j.data || [];
                                const t = document.getElementById('catalog-table');
                                let html = '<tr><th>Source</th><th>Name</th><th>Description</th><th>Created</th><th>Visibility</th><th>Actions</th></tr>';
                                for (const r of rows){
                                    const isManual = r.source === 'manual';
                                    html += `<tr>`+
                                        `<td>${r.source}</td>`+
                                        `<td>${r.name ?? ''}</td>`+
                                        `<td>${r.description ?? ''}</td>`+
                                        `<td>${fmtDate(r.created)}</td>`+
                                        `<td>${r.isvisible ?? ''}</td>`+
                                        `<td>`+
                                            `${isManual ? `<button data-act=\"edit\" data-id=\"${r.id}\" data-name=\"${encodeURIComponent(r.name||'')}\" data-desc=\"${encodeURIComponent(r.description||'')}\" data-date=\"${fmtDate(r.created)}\" data-vis=\"${r.isvisible}\">Edit</button><button data-act=\"del\" data-id=\"${r.id}\">Delete</button>` : `<button data-act=\"import\" data-id=\"${r.id}\">Import to Manual</button>`}`+
                                        `</td>`+
                                    `</tr>`;
                                }
                                t.innerHTML = html;
                                t.onclick = (e)=>{
                                    const btn = e.target.closest('button');
                                    if (!btn) return;
                                    const act = btn.getAttribute('data-act');
                                    const id = parseInt(btn.getAttribute('data-id'));
                                    if (act === 'edit'){
                                        // prefill manual edit form in the manager section
                                        document.querySelector('[data-target="project-managers"]').click();
                                        document.getElementById('manual-project-id').value = id;
                                        document.getElementById('manual-project-name').value = decodeURIComponent(btn.getAttribute('data-name'));
                                        document.getElementById('manual-project-desc').value = decodeURIComponent(btn.getAttribute('data-desc'));
                                        document.getElementById('manual-project-date').value = btn.getAttribute('data-date');
                                        document.getElementById('manual-project-visible').value = btn.getAttribute('data-vis') || 'public';
                                    } else if (act === 'del'){
                                        if (!confirm('Delete this manual project?')) return;
                                        fetch(api, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'manual_delete', project_id:id }) })
                                            .then(r=>r.json()).then(()=>{ loadCatalog(); }).catch(console.error);
                                    } else if (act === 'import'){
                                        fetch(api, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'manual_import_from_temp', gitproject_id:id }) })
                                            .then(r=>r.json()).then(j=>{
                                                if (!j.success) { alert(j.message||'Import failed'); return; }
                                                loadCatalog();
                                            }).catch(console.error);
                                    }
                                };
                            });
                        }
                        // Load once on render; switching tabs will keep content until refreshed
                        loadCatalog();
                    })();
                </script>
            </section>
            <section id="github-projects">
                <div class="mega_box">
                    <table class="table" id="temp-github-table"></table>
                </div>
                <script>
                    (function(){
                        const api = '../Properties/api/project_manager.php';

                        function fmtDate(d){
                            if (!d) return '';
                            return String(d).slice(0,10);
                        }

                        function renderManualProjects(rows){
                            const t = document.getElementById('manual-projects-table');
                            let html = '<tr><th>ID</th><th>Name</th><th>Date</th><th>Visible</th><th>Actions</th></tr>';
                            for (const r of rows){
                                html += `<tr>`+
                                    `<td>${r.project_id}</td>`+
                                    `<td>${r.project_name ?? ''}</td>`+
                                    `<td>${fmtDate(r.date_creation)}</td>`+
                                    `<td>${r.isvisible ?? ''}</td>`+
                                    `<td>`+
                                        `<button data-act="edit" data-id="${r.project_id}" data-name="${encodeURIComponent(r.project_name ?? '')}" data-desc="${encodeURIComponent(r.description ?? '')}" data-date="${fmtDate(r.date_creation)}" data-vis="${r.isvisible}">Edit</button>`+
                                        `<button data-act="del" data-id="${r.project_id}">Delete</button>`+
                                    `</td>`+
                                `</tr>`;
                            }
                            t.innerHTML = html;
                            t.onclick = (e) => {
                                const btn = e.target.closest('button');
                                if (!btn) return;
                                const act = btn.getAttribute('data-act');
                                const id = parseInt(btn.getAttribute('data-id')); 
                                if (act === 'edit'){
                                    document.getElementById('manual-project-id').value = id;
                                    document.getElementById('manual-project-name').value = decodeURIComponent(btn.getAttribute('data-name'));
                                    document.getElementById('manual-project-desc').value = decodeURIComponent(btn.getAttribute('data-desc'));
                                    document.getElementById('manual-project-date').value = btn.getAttribute('data-date');
                                    document.getElementById('manual-project-visible').value = btn.getAttribute('data-vis') || 'public';
                                } else if (act === 'del'){
                                    fetch(api, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'manual_delete', project_id:id }) })
                                        .then(r => r.json()).then(loadAll).catch(console.error);
                                }
                            };
                        }

                        function renderBinds(rows){
                            const t = document.getElementById('binds-table');
                            let html = '<tr><th>ID</th><th>GitHub URL</th><th>Status</th><th>Actions</th></tr>';
                            for (const r of rows){
                                html += `<tr>`+
                                    `<td>${r.account_bind_id}</td>`+
                                    `<td>${r.account_link ?? ''}</td>`+
                                    `<td>${(parseInt(r.is_verified)?'Verified':'Not verified')}</td>`+
                                    `<td>`+
                                        `${parseInt(r.is_verified)? '' : `<button data-act="req" data-id="${r.account_bind_id}">Request Code</button><button data-act=\"check\" data-id=\"${r.account_bind_id}\">Verify Now</button>`}`+
                                        `<button data-act="del" data-id="${r.account_bind_id}">Delete</button>`+
                                    `</td>`+
                                `</tr>`;
                            }
                            t.innerHTML = html;
                            t.onclick = (e) => {
                                const btn = e.target.closest('button');
                                if (!btn) return;
                                const act = btn.getAttribute('data-act');
                                const id = parseInt(btn.getAttribute('data-id'));
                                if (act === 'del'){
                                    if (!confirm('Remove this GitHub account bind?')) return;
                                    fetch(api, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'bind_delete', account_bind_id:id }) })
                                        .then(r => r.json()).then(loadAll).catch(console.error);
                                } else if (act === 'req'){
                                    fetch(api, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'bind_request_verify', account_bind_id:id }) })
                                        .then(r=>r.json()).then(j=>{
                                            if (!j.success) return;
                                            alert('Add this code to your GitHub bio, then click Verify Now: '+ (j.challenge||''));
                                        }).catch(console.error);
                                } else if (act === 'check'){
                                    fetch(api, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'bind_check_verify', account_bind_id:id }) })
                                        .then(r=>r.json()).then(j=>{
                                            if (j && j.success){
                                                alert('Bind verified!');
                                                loadAll();
                                            } else {
                                                alert((j && j.message) || 'Verification failed');
                                            }
                                        }).catch(console.error);
                                }
                            };
                        }

                        function renderTempGithub(rows){
                            const t = document.getElementById('temp-github-table');
                            let html = '<tr><th>ID</th><th>Name</th><th>Created</th><th>Visibility</th></tr>';
                            for (const r of rows){
                                html += `<tr>`+
                                    `<td>${r.id}</td>`+
                                    `<td>${r.name ?? ''}</td>`+
                                    `<td>${fmtDate(r.created)}</td>`+
                                    `<td>${r.isvisible ?? ''}</td>`+
                                `</tr>`;
                            }
                            t.innerHTML = html;
                        }

                        function loadAll(){
                            // manual
                            fetch(`${api}?action=manual_list`).then(r=>r.json()).then(j=>{ if(j.success) renderManualProjects(j.data||[]); });
                            // binds
                            fetch(`${api}?action=bind_list`).then(r=>r.json()).then(j=>{ if(j.success) renderBinds(j.data||[]); });
                            // config
                            fetch(`${api}?action=config_get`).then(r=>r.json()).then(j=>{ if(j.success && j.data){
                                document.getElementById('cfg-time').value = (j.data.update_time || '').slice(0,5);
                                document.getElementById('cfg-schedule').value = j.data.schedule || 'day';
                            }});
                            // temp list from combined but filter source=github
                            fetch(`${api}?action=list_all`).then(r=>r.json()).then(j=>{ if(j.success){
                                const g = (j.data||[]).filter(x => x.source==='github');
                                renderTempGithub(g);
                            }});
                        }

                        // Manual form
                        document.getElementById('manual-project-form').addEventListener('submit', (e) => {
                            e.preventDefault();
                            const pid = (document.getElementById('manual-project-id').value||'').trim();
                            const payload = {
                                action: pid ? 'manual_update' : 'manual_create',
                                project_id: pid ? parseInt(pid) : undefined,
                                project_name: document.getElementById('manual-project-name').value.trim(),
                                description: document.getElementById('manual-project-desc').value.trim(),
                                date_creation: document.getElementById('manual-project-date').value,
                                isvisible: document.getElementById('manual-project-visible').value
                            };
                            fetch(api, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(payload) })
                                .then(r=>r.json()).then(() => { resetManual(); loadAll(); }).catch(console.error);
                        });
                        document.getElementById('manual-reset-btn').addEventListener('click', (e)=>{ e.preventDefault(); resetManual(); });
                        function resetManual(){
                            document.getElementById('manual-project-id').value='';
                            document.getElementById('manual-project-name').value='';
                            document.getElementById('manual-project-desc').value='';
                            document.getElementById('manual-project-date').value='';
                            document.getElementById('manual-project-visible').value='public';
                        }

                        // Bind form
                        document.getElementById('bind-form').addEventListener('submit', (e) => {
                            e.preventDefault();
                            const link = document.getElementById('bind-link').value.trim();
                            if (!link) return;
                            fetch(api, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'bind_create', account_link: link }) })
                                .then(r=>r.json()).then(()=>{ document.getElementById('bind-link').value=''; loadAll(); }).catch(console.error);
                        });
                        document.getElementById('bind-reset-btn').addEventListener('click', (e)=>{ e.preventDefault(); document.getElementById('bind-link').value=''; });

                        // Config form
                        document.getElementById('config-form').addEventListener('submit', (e) => {
                            e.preventDefault();
                            const update_time = document.getElementById('cfg-time').value || '03:00';
                            const schedule = document.getElementById('cfg-schedule').value || 'day';
                            fetch(api, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'config_update', update_time: update_time+':00', schedule }) })
                                .then(r=>r.json()).then(()=>{ loadAll(); }).catch(console.error);
                        });
                        document.getElementById('sync-now-btn').addEventListener('click', (e) => {
                            e.preventDefault();
                            const btn = e.currentTarget;
                            const prevText = btn.textContent;
                            btn.disabled = true;
                            btn.textContent = 'Syncing...';
                            fetch(api, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ action:'sync_now' }) })
                                .then(r=>r.json())
                                .then(j=>{ if (!j.success) throw new Error(j.message || 'Sync failed'); loadAll(); })
                                .catch((err)=>{ console.error(err); alert(err.message || 'Sync failed'); })
                                .finally(()=>{ btn.disabled=false; btn.textContent = prevText; });
                        });

                        // Initial load
                        loadAll();
                    })();
                </script>
            </section>
        </div>
        <div class="sections-background-container" id="edit-access-section">
            <div class="header-tab-handler">
                <div class="header-tab current-tab" id="eas-tab-1" onclick="areafunction('eas','account')">                
                    <h3>Account Settings</h3>
                </div>
            </div> 
            <section id="account" class="current-section">
                <form id="account-form">
                    <input type="hidden" id="account-person-id" value="1">
                    
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password">
                    
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm_password">
                    
                    <button type="submit">Update Account</button>
                </form>
            </section>
        </div>
        <div class="sections-background-container" id="logs-history-section">
            <div class="header-tab-handler">
                <div class="header-tab current-tab" id="lhs-tab-1" onclick="areafunction('lhs','log-history')">                
                    <h3>Log History</h3>
                </div>
            </div> 
            <section id="log-history" class="current-section">
                <div class="mega_box">
                    <div class="box">
                        <button id="logs-refresh">Refresh</button>
                        <button id="logs-clear">Clear</button>
                    </div>
                    <table class="table" id="logs-table"></table>
                </div>
                <script>
                    (function(){
                        const api = '../Properties/api/logs.php';
                        function renderLogs(rows){
                            const t = document.getElementById('logs-table');
                            let html = '<tr><th>Time</th><th>User</th><th>Action</th><th>Details</th><th>IP</th></tr>';
                            for (const r of rows){
                                const time = r.time || '';
                                const user = r.user || '';
                                const action = r.action || '';
                                const ip = r.ip || '';
                                const det = r.details ? JSON.stringify(r.details) : '';
                                html += `<tr><td>${time}</td><td>${user}</td><td>${action}</td><td>${det}</td><td>${ip}</td></tr>`;
                            }
                            t.innerHTML = html;
                        }
                        function loadLogs(){
                            fetch(`${api}?action=list&limit=300`).then(r=>r.json()).then(j=>{ if(j.success) renderLogs(j.data||[]); });
                        }
                        const btnR = document.getElementById('logs-refresh');
                        if (btnR) btnR.addEventListener('click', (e)=>{ e.preventDefault(); loadLogs(); });
                        const btnC = document.getElementById('logs-clear');
                        if (btnC) btnC.addEventListener('click', (e)=>{ e.preventDefault(); fetch(api, { method:'POST', headers:{'Content-Type':'application/x-www-form-urlencoded'}, body:'action=clear' }).then(()=>loadLogs()); });
                        loadLogs();
                    })();
                </script>
            </section>
        </div>
    </article>
</body>
</html>
