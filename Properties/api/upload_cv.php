<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['edit_permitted']) || $_SESSION['edit_permitted'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

require_once '../database.php';

function fail_cv($msg, $code = 400) {
    http_response_code($code);
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}

$userId = isset($_POST['id']) ? (int)$_POST['id'] : 1;

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    fail_cv('No file uploaded or upload error');
}

$file = $_FILES['file'];
$maxSize = 10 * 1024 * 1024; // 10MB
if ($file['size'] > $maxSize) {
    fail_cv('File too large (max 10MB)');
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);
$allowed = [
    'application/pdf' => 'pdf',
];
if (!isset($allowed[$mime])) {
    fail_cv('Unsupported file type (only PDF files are allowed)');
}

// Additional check: verify file extension is .pdf
$original = basename($file['name']);
$fileExtension = strtolower(pathinfo($original, PATHINFO_EXTENSION));
if ($fileExtension !== 'pdf') {
    fail_cv('Only PDF files are allowed');
}

// Sanitize filename
$original = preg_replace('/[^A-Za-z0-9._-]/', '_', $original);

// Enforce no duplicate filename for this user
$dup = $conn->prepare('SELECT 1 FROM file_manager WHERE id=? AND file_name=? LIMIT 1');
$dup->bind_param('is', $userId, $original);
$dup->execute();
$dupRes = $dup->get_result();
if ($dupRes && $dupRes->num_rows > 0) {
    fail_cv('A file with the same name already exists', 409);
}

$targetDir = dirname(__DIR__) . '/files'; // Properties/files
if (!is_dir($targetDir)) {
    if (!mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
        fail_cv('Failed to create target directory', 500);
    }
}

$destPath = $targetDir . '/' . $original;
if (file_exists($destPath)) {
    // Also guard at filesystem level
    fail_cv('A file with the same name already exists on disk', 409);
}

if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    fail_cv('Failed to save uploaded file', 500);
}

$relativePath = 'Properties/files/' . $original;

$stmt = $conn->prepare('INSERT INTO file_manager (id, file_name, file_path) VALUES (?,?,?)');
if (!$stmt) fail_cv('DB prepare failed', 500);
$stmt->bind_param('iss', $userId, $original, $relativePath);
$ok = $stmt->execute();
if (!$ok) fail_cv('DB insert failed', 500);

echo json_encode(['success' => true, 'file_id' => $conn->insert_id, 'file_name' => $original, 'file_path' => $relativePath]);
