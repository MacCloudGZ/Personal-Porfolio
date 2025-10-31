<?php
    function log_event($action, $details = []) {
        $logFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'log.txt';
        $timestamp = date('Y-m-d H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $user = isset($_SESSION['edit_user']) ? $_SESSION['edit_user'] : 'guest';
        $origin = isset($_SESSION['edit_origin']) ? $_SESSION['edit_origin'] : '';
        $payload = [
            'time' => $timestamp,
            'ip' => $ip,
            'user' => $user,
            'origin' => $origin,
            'action' => $action,
            'details' => $details
        ];
        $line = json_encode($payload, JSON_UNESCAPED_SLASHES);
        // best-effort append
        @file_put_contents($logFile, $line . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
?>


