<?php
    session_start();
    header('Content-Type: application/json');

    $action = $_GET['action'] ?? ($_POST['action'] ?? 'list');
    $logFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'log.txt';

    function json_fail($msg, $code = 400){ http_response_code($code); echo json_encode(['success'=>false,'message'=>$msg]); exit; }

    if ($action === 'list') {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 200;
        if (!file_exists($logFile)) { echo json_encode(['success'=>true,'data'=>[]]); exit; }
        $lines = @file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
        $slice = array_slice($lines, -$limit);
        $parsed = [];
        foreach ($slice as $line) {
            $obj = json_decode($line, true);
            if (is_array($obj)) $parsed[] = $obj; else $parsed[] = ['raw' => $line];
        }
        echo json_encode(['success'=>true,'data'=>$parsed]);
        exit;
    }

    // Only allow clearing when edit session is active
    if (!isset($_SESSION['edit_permitted']) || $_SESSION['edit_permitted'] !== true) {
        json_fail('Forbidden', 403);
    }

    if ($action === 'clear') {
        @file_put_contents($logFile, '');
        echo json_encode(['success'=>true]);
        exit;
    }

    json_fail('Unknown action', 404);
?>


