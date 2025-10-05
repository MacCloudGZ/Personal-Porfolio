<?php
session_start();
header('Content-Type: application/json');

// This endpoint is intended for the edit page; require edit permission
if (!isset($_SESSION['edit_permitted']) || $_SESSION['edit_permitted'] !== true) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

require_once '../database.php';

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) { $data = $_POST; }

$userId = isset($data['id']) ? (int)$data['id'] : 1;

$stmt = $conn->prepare('SELECT file_id, file_name, file_path FROM file_manager WHERE id=? ORDER BY file_id DESC');
$stmt->bind_param('i', $userId);
$stmt->execute();
$res = $stmt->get_result();
$rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];

echo json_encode(['success' => true, 'data' => $rows]);
