<?php
    session_start();
    header('Content-Type: application/json');
    @ini_set('display_errors', '0');
    @ini_set('html_errors', '0');

    // Only allow if edit is permitted for mutating actions; allow public list_all for frontend projects page
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!is_array($data)) { $data = $_POST; }

    include_once '../database.php';
    include_once 'logger.php';

    function json_fail($msg, $code = 400) {
        http_response_code($code);
        echo json_encode(['success' => false, 'message' => $msg]);
        exit;
    }

    function require_edit_access() {
        if (!isset($_SESSION['edit_permitted']) || $_SESSION['edit_permitted'] !== true) {
            json_fail('Forbidden', 403);
        }
    }

    // Helpers
    function parseGithubUsername($url) {
        // Accept forms like https://github.com/{username} or http://github.com/{username}/
        $parts = parse_url($url);
        if (!$parts || (strpos($parts['host'] ?? '', 'github.com') === false)) return '';
        $path = trim($parts['path'] ?? '', '/');
        if ($path === '') return '';
        $segments = explode('/', $path);
        return $segments[0] ?? '';
    }

    function githubFetchUserRepos($username) {
        if ($username === '') return [];
        $endpoint = "https://api.github.com/users/" . rawurlencode($username) . "/repos?per_page=100&sort=created";
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: Personal-Portfolio-App\r\nAccept: application/vnd.github+json\r\n",
                'timeout' => 10
            ]
        ]);
        $resp = @file_get_contents($endpoint, false, $context);
        if ($resp === false) return [];
        $json = json_decode($resp, true);
        if (!is_array($json)) return [];
        return $json;
    }

    // OTP helpers
    function set_sync_challenge() {
        $_SESSION['sync_challenge'] = [
            'code' => bin2hex(random_bytes(3)),
            'ts' => time()
        ];
        return $_SESSION['sync_challenge'];
    }
    function check_sync_challenge($code) {
        if (!isset($_SESSION['sync_challenge']['code'], $_SESSION['sync_challenge']['ts'])) return false;
        if (time() - $_SESSION['sync_challenge']['ts'] > 300) return false;
        return hash_equals($_SESSION['sync_challenge']['code'], (string)$code);
    }
    function clear_sync_challenge() {
        unset($_SESSION['sync_challenge']);
    }

    $action = isset($data['action']) ? $data['action'] : ($_GET['action'] ?? '');
    if ($action === '') json_fail('Missing action');

    // Ensure schema for bind verification
    @$conn->query("ALTER TABLE accounts_bind ADD COLUMN IF NOT EXISTS verify_code VARCHAR(32)");
    @$conn->query("ALTER TABLE accounts_bind ADD COLUMN IF NOT EXISTS is_verified TINYINT(1) DEFAULT 0");

    switch ($action) {
        // Manual projects CRUD
        case 'manual_list':
            $res = $conn->query('SELECT * FROM add_project_manual ORDER BY date_creation DESC, project_id DESC');
            $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
            echo json_encode(['success' => true, 'data' => $rows]);
            exit;

        case 'manual_create':
            require_edit_access();
            $sql = 'INSERT INTO add_project_manual (project_name, description, date_creation, isvisible) VALUES (?,?,?,?)';
            $stmt = $conn->prepare($sql);
            if (!$stmt) json_fail('Prepare failed', 500);
            $projectName = $data['project_name'] ?? '';
            $description = $data['description'] ?? null;
            $dateCreation = $data['date_creation'] ?? date('Y-m-d');
            $isvisible = $data['isvisible'] ?? 'public';
            $stmt->bind_param('ssss', $projectName, $description, $dateCreation, $isvisible);
            $ok = $stmt->execute();
            $insertId = $conn->insert_id;
            if ($ok) log_event('manual_project_create', ['project_id' => $insertId, 'project_name' => $projectName]);
            echo json_encode(['success' => $ok, 'insert_id' => $insertId]);
            exit;

        case 'manual_update':
            require_edit_access();
            $sql = 'UPDATE add_project_manual SET project_name=?, description=?, date_creation=?, isvisible=? WHERE project_id=?';
            $stmt = $conn->prepare($sql);
            if (!$stmt) json_fail('Prepare failed', 500);
            $pid = (int)($data['project_id'] ?? 0);
            $projectName = $data['project_name'] ?? '';
            $description = $data['description'] ?? null;
            $dateCreation = $data['date_creation'] ?? date('Y-m-d');
            $isvisible = $data['isvisible'] ?? 'public';
            $stmt->bind_param('ssssi', $projectName, $description, $dateCreation, $isvisible, $pid);
            $ok = $stmt->execute();
            if ($ok) log_event('manual_project_update', ['project_id' => $pid]);
            echo json_encode(['success' => $ok]);
            exit;

        case 'manual_delete':
            require_edit_access();
            $pid = (int)($data['project_id'] ?? 0);
            $stmt = $conn->prepare('DELETE FROM add_project_manual WHERE project_id=?');
            $stmt->bind_param('i', $pid);
            $ok = $stmt->execute();
            if ($ok) log_event('manual_project_delete', ['project_id' => $pid]);
            echo json_encode(['success' => $ok]);
            exit;

        // Accounts bind CRUD
        case 'bind_list':
            $res = $conn->query('SELECT account_bind_id, account_link, IFNULL(is_verified,0) AS is_verified FROM accounts_bind ORDER BY account_bind_id DESC');
            $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
            echo json_encode(['success' => true, 'data' => $rows]);
            exit;

        case 'bind_create':
            require_edit_access();
            $stmt = $conn->prepare('INSERT INTO accounts_bind (account_link, is_verified) VALUES (?, 0)');
            $stmt->bind_param('s', $data['account_link']);
            $ok = $stmt->execute();
            $insertId = $conn->insert_id;
            if ($ok) log_event('bind_create', ['account_bind_id' => $insertId, 'account_link' => $data['account_link']]);
            echo json_encode(['success' => $ok, 'insert_id' => $insertId]);
            exit;

        case 'bind_delete':
            require_edit_access();
            $bid = (int)($data['account_bind_id'] ?? 0);
            $stmt = $conn->prepare('DELETE FROM accounts_bind WHERE account_bind_id=?');
            $stmt->bind_param('i', $bid);
            $ok = $stmt->execute();
            if ($ok) log_event('bind_delete', ['account_bind_id' => $bid]);
            echo json_encode(['success' => $ok]);
            exit;

        case 'bind_request_verify':
            require_edit_access();
            $bid = (int)($data['account_bind_id'] ?? 0);
            if ($bid <= 0) json_fail('Invalid bind id');
            $code = bin2hex(random_bytes(3)); // 6 hex chars
            $stmt = $conn->prepare('UPDATE accounts_bind SET verify_code=?, is_verified=0 WHERE account_bind_id=?');
            $stmt->bind_param('si', $code, $bid);
            $ok = $stmt->execute();
            if (!$ok) json_fail('Failed to set verify code', 500);
            // return human-readable challenge string
            log_event('bind_request_verify', ['account_bind_id' => $bid]);
            echo json_encode(['success' => true, 'challenge' => 'VERIFY-' . strtoupper($code)]);
            exit;

        case 'bind_check_verify':
            require_edit_access();
            $bid = (int)($data['account_bind_id'] ?? 0);
            if ($bid <= 0) json_fail('Invalid bind id');
            $res = $conn->prepare('SELECT account_link, verify_code FROM accounts_bind WHERE account_bind_id=? LIMIT 1');
            $res->bind_param('i', $bid);
            $res->execute();
            $row = $res->get_result()->fetch_assoc();
            if (!$row) json_fail('Bind not found', 404);
            $username = parseGithubUsername($row['account_link'] ?? '');
            $code = strtolower($row['verify_code'] ?? '');
            if ($username === '' || $code === '') json_fail('Missing data for verification', 400);
            // Check GitHub bio for the code
            $endpoint = "https://api.github.com/users/" . rawurlencode($username);
            $context = stream_context_create(['http' => ['method'=>'GET','header'=>"User-Agent: Personal-Portfolio-App\r\nAccept: application/vnd.github+json\r\n",'timeout'=>10]]);
            $resp = @file_get_contents($endpoint, false, $context);
            if ($resp === false) json_fail('GitHub unreachable', 502);
            $json = json_decode($resp, true);
            $bio = strtolower((string)($json['bio'] ?? ''));
            $ok = (strpos($bio, $code) !== false) || (strpos($bio, 'verify-'. $code) !== false);
            if (!$ok) json_fail('Verification code not found in GitHub bio', 409);
            $upd = $conn->prepare('UPDATE accounts_bind SET is_verified=1 WHERE account_bind_id=?');
            $upd->bind_param('i', $bid);
            $upd->execute();
            log_event('bind_verified', ['account_bind_id' => $bid, 'username' => $username]);
            echo json_encode(['success' => true]);
            exit;

        // Config update get / set
        case 'config_get':
            $res = $conn->query('SELECT update_time, schedule FROM config_update LIMIT 1');
            $row = $res ? $res->fetch_assoc() : null;
            echo json_encode(['success' => true, 'data' => $row]);
            exit;

        case 'config_update':
            require_edit_access();
            // UPSERT single-row config
            $time = $data['update_time'] ?? '03:00:00';
            $schedule = $data['schedule'] ?? 'day';
            $res = $conn->query('SELECT COUNT(*) AS c FROM config_update');
            $has = ($res && ($r = $res->fetch_assoc()) && (int)$r['c'] > 0);
            if ($has) {
                $stmt = $conn->prepare('UPDATE config_update SET update_time=?, schedule=?');
                $stmt->bind_param('ss', $time, $schedule);
                $ok = $stmt->execute();
                echo json_encode(['success' => $ok]);
            } else {
                $stmt = $conn->prepare('INSERT INTO config_update (update_time, schedule) VALUES (?,?)');
                $stmt->bind_param('ss', $time, $schedule);
                $ok = $stmt->execute();
                echo json_encode(['success' => $ok]);
            }
            exit;

        case 'sync_challenge':
            require_edit_access();
            $c = set_sync_challenge();
            echo json_encode([
                'success' => true,
                'challenge' => 'SYNC-' . strtoupper($c['code']),
                'expires_in' => 300
            ]);
            exit;

        // Run GitHub sync: clear and insert
        case 'sync_now':
            require_edit_access();

            // Clear temp
            $conn->query('DELETE FROM temp_github_project');
            // Load binds
            $res = $conn->query('SELECT account_bind_id, account_link FROM accounts_bind WHERE IFNULL(is_verified,0)=1');
            if ($res) {
                while ($row = $res->fetch_assoc()) {
                    $bindId = (int)$row['account_bind_id'];
                    $username = parseGithubUsername($row['account_link']);
                    if ($username === '') continue;
                    $repos = githubFetchUserRepos($username);
                    if (!is_array($repos)) continue;
                    foreach ($repos as $repo) {
                        $rid = isset($repo['id']) ? (int)$repo['id'] : null;
                        $name = isset($repo['name']) ? (string)$repo['name'] : '';
                        $desc = isset($repo['description']) ? (string)$repo['description'] : null;
                        $createdAt = isset($repo['created_at']) ? substr((string)$repo['created_at'], 0, 10) : date('Y-m-d');
                        if ($rid === null || $name === '') continue;
                        $stmt = $conn->prepare('INSERT INTO temp_github_project (account_bind_id, gitproject_id, gitproject_name, gitdescription, gitdate_creation, gitisvisible) VALUES (?,?,?,?,?,\'public\')');
                        if ($stmt) {
                            $stmt->bind_param('iisss', $bindId, $rid, $name, $desc, $createdAt);
                            $stmt->execute();
                        }
                    }
                }
            }
            log_event('github_sync');
            echo json_encode(['success' => true]);
            exit;

        // Combined list for frontend view
        case 'list_all':
            $manual = [];
            $github = [];
            if ($r1 = $conn->query("SELECT project_id AS id, project_name AS name, description, date_creation AS created, isvisible, 'manual' AS source FROM add_project_manual")) {
                $manual = $r1->fetch_all(MYSQLI_ASSOC);
            }
            if ($r2 = $conn->query("SELECT gitproject_id AS id, gitproject_name AS name, gitdescription AS description, gitdate_creation AS created, gitisvisible AS isvisible, 'github' AS source FROM temp_github_project")) {
                $github = $r2->fetch_all(MYSQLI_ASSOC);
            }
            $all = array_merge($manual, $github);
            // sort by created desc, then name
            usort($all, function($a, $b){
                $ad = $a['created'] ?? '';
                $bd = $b['created'] ?? '';
                if ($ad === $bd) return strcmp($a['name'] ?? '', $b['name'] ?? '');
                return strcmp($bd, $ad);
            });
            echo json_encode(['success' => true, 'data' => $all]);
            exit;

        case 'manual_import_from_temp':
            require_edit_access();
            $gid = (int)($data['gitproject_id'] ?? 0);
            if ($gid <= 0) json_fail('Invalid gitproject_id');
            $stmt = $conn->prepare('SELECT gitproject_name, gitdescription, gitdate_creation FROM temp_github_project WHERE gitproject_id=? LIMIT 1');
            $stmt->bind_param('i', $gid);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            if (!$row) json_fail('Temp project not found', 404);
            $name = $row['gitproject_name'] ?? '';
            $desc = $row['gitdescription'] ?? null;
            $date = substr((string)($row['gitdate_creation'] ?? date('Y-m-d')),0,10);
            if ($name === '') json_fail('Invalid project name in temp');
            $ins = $conn->prepare('INSERT INTO add_project_manual (project_name, description, date_creation, isvisible) VALUES (?,?,?,\'public\')');
            $ins->bind_param('sss', $name, $desc, $date);
            $ok = $ins->execute();
            $newId = $conn->insert_id;
            if ($ok) log_event('manual_import_from_temp', ['gitproject_id' => $gid, 'project_id' => $newId]);
            echo json_encode(['success' => $ok, 'insert_id' => $newId]);
            exit;

        default:
            json_fail('Unknown action', 404);
    }
?>


