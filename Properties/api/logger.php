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
        $line = json_encode($payload, JSON_UNESCAPED_SLASHES) . PHP_EOL;

        // Explicit file handling using fopen/fwrite/fclose with lock
        $fh = @fopen($logFile, 'ab');
        if ($fh === false) { return; }
        if (@flock($fh, LOCK_EX)) {
            @fwrite($fh, $line);
            @flock($fh, LOCK_UN);
        } else {
            @fwrite($fh, $line);
        }
        @fclose($fh);
    }
?>


