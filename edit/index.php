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
    <?php
        session_start();
        if (!isset($_SESSION['edit_permitted']) || $_SESSION['edit_permitted'] !== true) {
            header('Location: ../Error.html');
            exit;
        }
    ?>
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
            <section id="profile-image">
                <h2>Profile Image</h2>
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
                <h2>CV / Files</h2>
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
            <section id="personal-info">
                <h2>Personal Information</h2>
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
                <h2>Address</h2>
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
                        <h2>Contact Information</h2>
                        <div id="contact-list">
                            <!-- Contact items will be dynamically loaded here -->
                        </div>
                    </div>
                <form id="contact-form">
                    <input type="hidden" id="contact-person-id" value="1">
                    <div class="mega_box">
                        <h2>Add New Contact</h2>
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

            <!-- Educational Background Section -->
            <section id="education">
                <h2>Educational Background</h2>
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

            <!-- Skills Section -->
            <section id="skills">
                <h2>Skills</h2>
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

            <!-- Fun/Personal Touch Section -->
            <section id="personal-touch">
                <h2>Fun / Personal Touch</h2>
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

            <!-- Message Data Section -->
            <section id="messages">
                <h2>Message Data</h2>
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
            <section id="projects">
                <h2>Projects</h2>
            </section>
        </div>
        <div class="sections-background-container" id="edit-access-section">
            <!-- Account Section -->
            <section id="account">
                <h2>Account Settings</h2>
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
            <section id="log-history">
                <h2>Log History</h2>
            </section>
        </div>
    </article>
</body>
</html>
