<?php
    session_start();
    header('Content-Type: application/json');

    include_once '../database.php';
    include_once 'logger.php';

    // Basic rate limiting (session-based) to mitigate DoS/brute force
    $now = time();
    $windowSeconds = 60;       // rolling window
    $maxAttempts   = 5;        // max attempts per window

    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }

    // Keep attempts within window
    $_SESSION['login_attempts'] = array_values(array_filter(
        $_SESSION['login_attempts'],
        function($ts) use ($now, $windowSeconds) { return ($now - $ts) <= $windowSeconds; }
    ));

    if (count($_SESSION['login_attempts']) >= $maxAttempts) {
        http_response_code(429);
        echo json_encode([
            'success' => false,
            'message' => 'Too many attempts. Please wait a minute and try again.'
        ]);
        exit;
    }

    // Add small jitter and incremental backoff
    $backoffMs = min(1000, count($_SESSION['login_attempts']) * 150);
    usleep((random_int(50, 150) + $backoffMs) * 1000);

    // Read JSON body or fallback to form-data
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        $data = $_POST;
    }

    $username = isset($data['username']) ? trim($data['username']) : '';
    $password = isset($data['password']) ? trim($data['password']) : '';
    $origin = isset($data['origin']) ? trim($data['origin']) : 'Home';

    if ($username === '' || $password === '') {
        $_SESSION['login_attempts'][] = $now;
        echo json_encode([
            'success' => false,
            'message' => 'Username and password are required.'
        ]);
        exit;
    }

    // Validate credentials against database (plaintext per current seed data)
    $sql = 'SELECT id FROM account WHERE username = ? AND password_hash = ? LIMIT 1';
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Server error. Please try again later.'
        ]);
        exit;
    }
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result ? $result->fetch_assoc() : null;

    if ($row) {
        // Success: mark session and clear attempts
        $_SESSION['edit_permitted'] = true;
        $_SESSION['edit_origin'] = in_array($origin, ['Home','Projects','Contacts'], true) ? $origin : 'Home';
        $_SESSION['edit_user'] = $username;
        $_SESSION['login_attempts'] = [];
        log_event('login_success', ['username' => $username, 'origin' => $_SESSION['edit_origin']]);
        echo json_encode([
            'success' => true,
            'message' => 'Access granted.'
        ]);
        exit;
    }

    // Failure path
    $_SESSION['edit_permitted'] = false;
    $_SESSION['login_attempts'][] = $now;
    log_event('login_failed', ['username' => $username]);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid credentials.'
    ]);
    exit;
?>


