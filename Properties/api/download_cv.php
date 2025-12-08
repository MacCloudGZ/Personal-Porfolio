<?php
// Public endpoint to download the CV for a user, prioritizing current_use=1, or a specific file_id

require_once '../database.php';

$userId = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$fileId = isset($_GET['file_id']) ? (int)$_GET['file_id'] : 0;

if ($fileId > 0) {
    // Specific file_id requested
    $stmt = $conn->prepare('SELECT file_name, file_path FROM file_manager WHERE id=? AND file_id=? LIMIT 1');
    $stmt->bind_param('ii', $userId, $fileId);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res ? $res->fetch_assoc() : null;
} else {
    // First try to find file with current_use = 1
    $stmt = $conn->prepare('SELECT file_name, file_path FROM file_manager WHERE id=? AND current_use=1 LIMIT 1');
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res ? $res->fetch_assoc() : null;
    
    if (!$row) {
        // Fallback to latest file if no current_use=1 found
        $stmt = $conn->prepare('SELECT file_name, file_path FROM file_manager WHERE id=? ORDER BY file_id DESC LIMIT 1');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;
    }
}
if (!$row) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No CV found']);
    exit;
}

$relativePath = $row['file_path'];
$absPath = dirname(__DIR__, 1) . '/' . basename(dirname(__DIR__)) . '/' . $relativePath; // This is risky; compute relative to project root

// Better: resolve relative to Properties directory root
$absPath = dirname(__DIR__) . '/../' . $relativePath; // Properties/../Properties/files/...
$absPath = realpath($absPath);
if ($absPath === false || !is_file($absPath)) {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'CV file not found on disk']);
    exit;
}

$filename = $row['file_name'];
$mime = function_exists('mime_content_type') ? mime_content_type($absPath) : 'application/octet-stream';

header('Content-Description: File Transfer');
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . rawurlencode($filename) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($absPath));

readfile($absPath);
exit;
