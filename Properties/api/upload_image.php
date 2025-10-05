<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['edit_permitted']) || $_SESSION['edit_permitted'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

require_once '../database.php';

function fail($msg, $code = 400) {
    http_response_code($code);
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}

$userId = isset($_POST['id']) ? (int)$_POST['id'] : 1;

// Validate upload
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    fail('No file uploaded or upload error');
}

$file = $_FILES['file'];
$maxSize = 5 * 1024 * 1024; // 5MB
if ($file['size'] > $maxSize) {
    fail('File too large (max 5MB)');
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);
$allowed = [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp'
];
if (!isset($allowed[$mime])) {
    fail('Unsupported image type');
}

$ext = $allowed[$mime];
$targetDir = dirname(__DIR__) . '/Images'; // Properties/Images
if (!is_dir($targetDir)) {
    fail('Target directory does not exist');
}

// Create unique name
$base = 'profile_' . $userId . '_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4));
$filename = $base . '.' . $ext;
$destPath = $targetDir . '/' . $filename;

if (!move_uploaded_file($file['tmp_name'], $destPath)) {
    fail('Failed to save uploaded file', 500);
}

// Build relative path stored in DB
$relativePath = 'Properties/Images/' . $filename;

// Insert or update main_images for this user: we will set image_id=1 row to new path if exists
// Note: per database.sql main_images has image_id AUTO_INCREMENT; existing code reads WHERE image_id=1.
// We'll update image_id=1 if present; otherwise insert a new row and return its path.

// Try to update image_id = 1
$updated = false;
$check = $conn->query('SELECT image_id FROM main_images WHERE image_id = 1 LIMIT 1');
if ($check && $check->num_rows > 0) {
    $stmt = $conn->prepare('UPDATE main_images SET id = ?, image_path = ? WHERE image_id = 1');
    if ($stmt) {
        $stmt->bind_param('is', $userId, $relativePath);
        $updated = $stmt->execute();
    }
}

if (!$updated) {
$stmt = $conn->prepare('INSERT INTO main_images (id, image_path) VALUES (?, ?)');
    if (!$stmt) fail('DB prepare failed', 500);
    $stmt->bind_param('is', $userId, $relativePath);
    $ok = $stmt->execute();
    if (!$ok) fail('DB insert failed', 500);
}

echo json_encode(['success' => true, 'image_path' => $relativePath]);
