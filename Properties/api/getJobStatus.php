<?php
    // job_status -> status_label based on personal_data status_id
    function getJobStatusLabel($conn, $user_id) {
        $sql_status = "SELECT js.status_label FROM job_status js 
                   INNER JOIN personal_data pd ON js.status_id = pd.status_id 
                   WHERE pd.id = ?";
        $stmt_status = $conn->prepare($sql_status);
        if (!$stmt_status) {
            die('Prepare failed for job_status: ' . $conn->error);
        }
    }
?>