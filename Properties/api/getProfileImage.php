<?php
    // main_images -> image_path {target the image with current_user = TRUE}
    function getProfileImagePath($conn, $user_id) {
        $sql_image = "SELECT image_path FROM main_images WHERE id = ? AND `current_user` = TRUE LIMIT 1";
        $stmt = $conn->prepare($sql_image);
        if (!$stmt) {
            die('Prepare failed for main_images: ' . $conn->error);
        }
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result_image = $stmt->get_result();
        if (!$result_image || $result_image->num_rows === 0) {
            // Fallback to image_id = 1 if no current_user image found (for backward compatibility)
            $fallback = $conn->query("SELECT image_path FROM main_images WHERE image_id = 1 LIMIT 1");
            if ($fallback && $fallback->num_rows > 0) {
                $row = $fallback->fetch_assoc();
                return $row['image_path'];
            }
            return 'Properties/Images/Default_Profile.webp'; // Default fallback
        }
        $row_image = $result_image->fetch_assoc();
        return $row_image['image_path'];
    }
?>