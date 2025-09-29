<?php
    session_start();
    include_once 'Properties/database.php';

    // Fetch personal data
    // Variable holders for extracted data
    $user_id = 1; // Change as needed

    // 1. personal_data -> CONCAT(lastname, firstname, middlename/middleinitial)
    $sql_fullname = "SELECT CONCAT(lastname, ', ', firstname, ' ', IF(middlename IS NOT NULL AND LENGTH(middlename) > 0, CONCAT(LEFT(middlename, 1), '.'), '')) AS full_name FROM personal_data WHERE id = ?";
    $stmt_fullname = $conn->prepare($sql_fullname);
    $stmt_fullname->bind_param('i', $user_id);
    $stmt_fullname->execute();
    $result_fullname = $stmt_fullname->get_result();
    $row_fullname = $result_fullname->fetch_assoc();
    $full_name = $row_fullname['full_name'];

    // 2. skills -> skill_name {if skills_shown is true}
    $sql_skills = "SELECT skill_name FROM skills WHERE id = ? AND skills_shown = TRUE";
    $stmt_skills = $conn->prepare($sql_skills);
    $stmt_skills->bind_param('i', $user_id);
    $stmt_skills->execute();
    $result_skills = $stmt_skills->get_result();
    $skills = [];
    while ($row_skill = $result_skills->fetch_assoc()) {
        $skills[] = $row_skill['skill_name'];
    }
    // 3. profession -> job_title {fetch all job titles for the user}
    $sql_profession = "SELECT job_title FROM profession WHERE id = ?";
    $stmt_profession = $conn->prepare($sql_profession);
    $stmt_profession->bind_param('i', $user_id);
    $stmt_profession->execute();
    $result_profession = $stmt_profession->get_result();
    $row_profession = $result_profession->fetch_assoc();
    $job_title = $row_profession ? $row_profession['job_title'] : '';

    // 4. message_data -> message_text {target the message_type number 1}
    $sql_message = "SELECT message_text FROM message_data WHERE id = ? AND message_type = 1";
    $stmt_message = $conn->prepare($sql_message);
    $stmt_message->bind_param('i', $user_id);
    $stmt_message->execute();
    $result_message = $stmt_message->get_result();
    $messages = [];
    while ($row_message = $result_message->fetch_assoc()) {
        $messages[] = $row_message['message_text'];
    }

    // 5. main_images -> image_path {target the image_id number 1}
    $sql_image = "SELECT image_path FROM main_images WHERE image_id = 1";
    $result_image = $conn->query($sql_image);
    $row_image = $result_image->fetch_assoc();
    $main_image_path = $row_image['image_path'];
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
                <p>My Experiences:</p>
                <div class="roles-container">
                    <?php
                        foreach ($job_title ? explode(',', $job_title) : [] as $title) {
                            echo '<div class="roles">' . htmlspecialchars(trim($title), ENT_QUOTES, 'UTF-8') . '</div>';
                        }
                    ?>
                </div>
                <p>My Skills:</p>
                <div class="roles-container">
                    <!-- for loop -->
                    <?php
                        foreach ($skills as $skill) {
                            echo '<div class="roles">' . htmlspecialchars($skill, ENT_QUOTES, 'UTF-8') . '</div>';
                        }
                    ?>
                </div>
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