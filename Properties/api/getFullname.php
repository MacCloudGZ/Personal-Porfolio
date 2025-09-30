<?php
    function getFullName($conn, $user_id) {
        $sql_fullname = "SELECT CONCAT(
                            lastname,
                            IF(suffix IS NOT NULL AND LENGTH(TRIM(suffix)) > 0, CONCAT(' ', suffix), ''),
                            ', ',
                            firstname,
                            ' ',
                            IF(middlename IS NOT NULL AND LENGTH(TRIM(middlename)) > 0, CONCAT(LEFT(middlename, 1), '.'), '')
                        ) AS full_name
                        FROM personal_data
                        WHERE id = ?";
        $stmt_fullname = $conn->prepare($sql_fullname);
        if (!$stmt_fullname) {
            die('Prepare failed for fullname: ' . $conn->error);
        }
        $stmt_fullname->bind_param('i', $user_id);
        $stmt_fullname->execute();
        $result_fullname = $stmt_fullname->get_result();
        $row_fullname = $result_fullname->fetch_assoc();
        return $row_fullname ? $row_fullname['full_name'] : '';
    }
?>