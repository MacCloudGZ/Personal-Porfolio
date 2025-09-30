<?php
    // main_images -> image_path {target the image_id number 1}
    function getProfileImagePath($conn, $user_id) {
        $sql_image = "SELECT image_path FROM main_images WHERE image_id = 1";
        $result_image = $conn->query($sql_image);
        if (!$result_image) {
            die('Query failed for main_images: ' . $conn->error);
        }
        $row_image = $result_image->fetch_assoc();
        return $row_image['image_path'];
    }
?>