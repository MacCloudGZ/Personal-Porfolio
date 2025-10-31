<?php
    session_start();
    header('Content-Type: application/json');
    include_once 'logger.php';
    if (isset($_SESSION['edit_permitted']) && $_SESSION['edit_permitted'] === true) {
        log_event('logout');
    }
    // Clear session keys used by editor
    unset($_SESSION['edit_permitted'], $_SESSION['edit_origin'], $_SESSION['edit_user']);
    echo json_encode(['success' => true]);
?>


