<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="../Properties/Style/main.css">
    <script src="index.js"defer></script>
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
            <button id="finished-btn">Finished</button>
            <?php
                // Use server-side origin if present to survive refresh
                $from = isset($_SESSION['edit_origin']) ? $_SESSION['edit_origin'] : null;
                if ($from) {
                    echo '<script>window.__EDIT_ORIGIN__ = ' . json_encode($from) . ';</script>';
                }
            ?>
        </div>
    </header>
    <div class="sections-background-container"> 
        <section id="profile-image">
            <h2>Profile Image</h2>
            <form id="image-upload-form" enctype="multipart/form-data">
                <input type="hidden" name="entity" value="main_images">
                <input type="hidden" name="action" value="upload">
                <input type="hidden" name="id" value="1">
                <div class="mega_box">
                    <div class="box">
                        <label for="profile-image-file">Choose image (JPG/PNG/WEBP, max 5MB)</label>
                        <input type="file" id="profile-image-file" name="file" accept="image/*" required>
                    </div>
                </div>
                <button type="submit">Upload Image</button>
            </form>
        </section>
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

        <section id="cv-files">
            <h2>CV / Files</h2>
            <div id="cv-list"></div>
            <form id="cv-upload-form" enctype="multipart/form-data">
                <input type="hidden" name="id" value="1">
                <div class="mega_box">
                    <div class="box">
                        <label for="cv-file">Choose file (PDF/ZIP, max 10MB)</label>
                        <input type="file" id="cv-file" name="file" accept=".pdf,.zip" required>
                    </div>
                </div>
                <button type="submit">Upload CV/File</button>
            </form>
        </section>
    </div>

    <script src="index.js"></script>
</body>
</html>
