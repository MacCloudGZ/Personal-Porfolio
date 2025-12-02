<?php
// Suppress any output that might break JSON
error_reporting(E_ALL);
ini_set('display_errors', 0);

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

// Insert new image to main_images (no changes to existing images)
// New images are inserted with current_user=FALSE by default
try {
    $stmt = $conn->prepare('INSERT INTO main_images (id, image_path, `current_user`) VALUES (?, ?, FALSE)');
    if (!$stmt) {
        // Clean up uploaded file if DB prepare fails
        @unlink($destPath);
        $errorMsg = $conn->error ?: 'Unknown database error';
        fail('DB prepare failed: ' . $errorMsg, 500);
    }
    
    $stmt->bind_param('is', $userId, $relativePath);
    $ok = $stmt->execute();
    
    if (!$ok) {
        // Clean up uploaded file if DB insert fails
        @unlink($destPath);
        $stmtError = $stmt->error ?: '';
        $connError = $conn->error ?: '';
        $errorMsg = 'DB insert failed';
        if ($stmtError) $errorMsg .= ': ' . $stmtError;
        if ($connError && $stmtError !== $connError) $errorMsg .= ' (DB: ' . $connError . ')';
        fail($errorMsg, 500);
    }

    $imageId = $conn->insert_id;
    
    if (!$imageId) {
        // Clean up uploaded file if no insert_id
        @unlink($destPath);
        fail('Failed to get insert ID', 500);
    }

    echo json_encode(['success' => true, 'image_path' => $relativePath, 'image_id' => $imageId]);
} catch (Exception $e) {
    // Clean up uploaded file on exception
    @unlink($destPath);
    fail('Exception: ' . $e->getMessage(), 500);
}
