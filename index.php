<?php
    session_start();
    include_once 'Properties/database.php';
    include_once 'Properties/api/getFullname.php';
    include_once 'Properties/api/getProfileImage.php';
    include_once 'Properties/api/getMessage.php';
    // Fetch personal data
    // Variable holders for extracted data
    $user_id = 1; // Change as needed

    $full_name = getFullName($conn, $user_id);
    $main_image_path = getProfileImagePath($conn, $user_id);
    $messages = getMessagesType1($conn, $user_id);

    // 2. skills -> skill_name {if skills_shown is true}
    $sql_skills = "SELECT skill_name FROM skills WHERE id = ? AND skills_shown = TRUE";
    $stmt_skills = $conn->prepare($sql_skills);
    if (!$stmt_skills) {
        die('Prepare failed for skills: ' . $conn->error);
    }
    $stmt_skills->bind_param('i', $user_id);
    $stmt_skills->execute();
    $result_skills = $stmt_skills->get_result();
    $skills = [];
    while ($row_skill = $result_skills->fetch_assoc()) {
        $skills[] = $row_skill['skill_name'];
    }
    // 3. experiences -> job_title {fetch only current/visible job titles}
    $sql_profession = "SELECT job_title FROM profession WHERE id = ? AND is_current = TRUE";
    $stmt_profession = $conn->prepare($sql_profession);
    if (!$stmt_profession) {
        // If the table doesn't exist, act like there are no experiences
        $job_titles = [];
        $job_title = '';
    } else {
        $stmt_profession->bind_param('i', $user_id);
        $stmt_profession->execute();
        $result_profession = $stmt_profession->get_result();
        $job_titles = [];
        while ($row_profession = $result_profession->fetch_assoc()) {
            $job_titles[] = $row_profession['job_title'];
        }
        $job_title = implode(',', $job_titles);
    }

    // Flags to control which section to show on the highlight page
    $hasProfessions = !empty($job_titles);
    $hasSkills = !empty($skills);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Properties/Style/Index.css">
    <link rel="stylesheet" href="Properties/Style/Loader.css">
    <link rel="stylesheet" href="Properties/Style/placeholder.css">
    <script src="Properties/Script/Snake.js" defer></script>
    <script src="Properties/Script/spin.js" defer></script>
    <title>Portfolio</title>
</head>
<body>
    <div class="background-container" id="background" >
        <article class="" id="article">
            <div class="profile-container">
                <div class="profile-front">
                    <img id="profile-img" alt="image_profile">
                    <script>
                        <?php
                            echo "const mainImagePath = '" . addslashes($main_image_path) . "';";
                        ?>
                        const imgEl = document.getElementById("profile-img");
                        const fallbackPath = "Properties/Images/Defaults_Profile.webp";

                        if (mainImagePath) {
                            fetch(mainImagePath, { method: 'HEAD' })
                                .then(response => {
                                    if (response.ok) {
                                        imgEl.src = mainImagePath;
                                    } else {
                                        imgEl.src = fallbackPath;
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
        </article>
        <div class="loading-container" id="idle">
            <span class="loader"></span>
            <span class="loading-txt">Loading...</span>
        </div>
        <section id="section">
            <div class="top">
                <div class="message">
                    <h1>Hello, I'm <?php echo $full_name?></h1>
                    <p>"<?php echo implode(" ", $messages); ?>"</p>
                </div>
                <?php if ($hasProfessions): ?>
                    <p>My Experiences:</p>
                    <div class="roles-container">
                        <?php
                            foreach ($job_titles as $title) {
                                echo '<div class="roles">' . htmlspecialchars(trim($title), ENT_QUOTES, 'UTF-8') . '</div>';
                            }
                        ?>
                    </div>
                <?php elseif ($hasSkills): ?>
                    <p>My Skills:</p>
                    <div class="roles-container">
                        <?php
                            foreach ($skills as $skill) {
                                echo '<div class="roles">' . htmlspecialchars($skill, ENT_QUOTES, 'UTF-8') . '</div>';
                            }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="down">
                <button class="cv" type="button" onclick="downloadCV()">
                    <span>DOWNLOAD CV</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M10 3V13M10 13L6 9M10 13L14 9M4 17H16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <button class="view" type="button" aria-label="View Profile" onclick="viewMain()">
                    <span>VIEW PROFILE</span>
                    <svg width="30" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 10C2.73 5.61 7.27 2.5 12 2.5C16.73 2.5 21.27 5.61 23 10C21.27 14.39 16.73 17.5 12 17.5C7.27 17.5 2.73 14.39 1 10Z" stroke="currentColor" stroke-width="2" fill="none"/>
                        <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                </button>
            </div>
        </section>
    </div>
</body>
</html>