<?php
    session_start();
    header('Content-Type: application/json');
    if (!isset($_SESSION['edit_permitted']) || $_SESSION['edit_permitted'] !== true) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Forbidden']);
        exit;
    }

    include_once '../database.php';
    include_once 'logger.php';

    // helper
    function json_fail($msg, $code = 400) {
        http_response_code($code);
        echo json_encode(['success' => false, 'message' => $msg]);
        exit;
    }

    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!is_array($data)) { $data = $_POST; }

    $entity = isset($data['entity']) ? $data['entity'] : '';
    $action = isset($data['action']) ? $data['action'] : '';
    $userId = isset($data['id']) ? (int)$data['id'] : 1; // default 1

    if ($entity === '' || $action === '') {
        json_fail('Missing entity or action');
    }

    // Route per entity
    switch ($entity) {
        case 'personal_data':
            // get or update
            if ($action === 'get') {
                $res = $conn->query('SELECT * FROM personal_data WHERE id='.(int)$userId.' LIMIT 1');
                $row = $res ? $res->fetch_assoc() : null;
                echo json_encode(['success' => true, 'data' => $row]);
                exit;
            }
            if ($action !== 'update') json_fail('Unsupported action', 405);
            $sql = 'UPDATE personal_data SET firstname=?, middlename=?, lastname=?, suffix=?, birthdate=?, status_id=?, sex=? WHERE id=?';
            $stmt = $conn->prepare($sql);
            if (!$stmt) json_fail('Prepare failed', 500);
            $firstname = $data['firstname'] ?? '';
            $middlename = $data['middlename'] ?? null;
            $lastname = $data['lastname'] ?? '';
            $suffix = $data['suffix'] ?? null;
            $birthdate = $data['birthdate'] ?? null;
            $status_id = (int)($data['status_id'] ?? 1);
            $sex = $data['sex'] ?? null;
            $stmt->bind_param('sssssiis', $firstname, $middlename, $lastname, $suffix, $birthdate, $status_id, $sex, $userId);
            $ok = $stmt->execute();
            if ($ok) log_event('personal_data_update', ['id' => $userId]);
            echo json_encode(['success' => $ok]);
            exit;

        case 'address':
            // upsert by id
            if (!in_array($action, ['upsert','get','list','update_show_status','delete'])) json_fail('Unsupported action', 405);
            if ($action === 'list') {
                $stmt = $conn->prepare('SELECT * FROM address WHERE id=? ORDER BY address_id DESC');
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $res = $stmt->get_result();
                $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
                echo json_encode(['success' => true, 'data' => $rows]);
                exit;
            }
            if ($action === 'get') {
                $res = $conn->query('SELECT * FROM address WHERE id='.(int)$userId.' LIMIT 1');
                $row = $res ? $res->fetch_assoc() : null;
                echo json_encode(['success' => true, 'data' => $row]);
                exit;
            }
            if ($action === 'update_show_status') {
                $addressId = (int)$data['address_id'];
                $showAddress = $data['show_Address'] ? 1 : 0;
                $stmt = $conn->prepare('UPDATE address SET show_Address = ? WHERE address_id = ? AND id = ?');
                $stmt->bind_param('iii', $showAddress, $addressId, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('address_update_show', ['id' => $userId, 'address_id' => $addressId, 'show' => (bool)$showAddress]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            if ($action === 'delete') {
                $addressId = (int)$data['address_id'];
                $stmt = $conn->prepare('DELETE FROM address WHERE address_id = ? AND id = ?');
                $stmt->bind_param('ii', $addressId, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('address_delete', ['id' => $userId, 'address_id' => $addressId]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            $sql = 'INSERT INTO address (id, address_line1, address_line2, city, state, zip_code, country)
                    VALUES (?,?,?,?,?,?,?)
                    ON DUPLICATE KEY UPDATE address_line1=VALUES(address_line1), address_line2=VALUES(address_line2), city=VALUES(city), state=VALUES(state), zip_code=VALUES(zip_code), country=VALUES(country)';
            $stmt = $conn->prepare($sql);
            if (!$stmt) json_fail('Prepare failed', 500);
            $stmt->bind_param(
                'issssss',
                $userId,
                $data['address_line1'],
                $data['address_line2'],
                $data['city'],
                $data['state'],
                $data['zip_code'],
                $data['country']
            );
            $ok = $stmt->execute();
            if ($ok) log_event('address_upsert', ['id' => $userId]);
            echo json_encode(['success' => $ok]);
            exit;

        case 'contact_info':
            if ($action === 'list') {
                $stmt = $conn->prepare('SELECT * FROM contact_info WHERE id=? ORDER BY contact_id DESC');
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $res = $stmt->get_result();
                $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
                echo json_encode(['success' => true, 'data' => $rows]);
                exit;
            }
            if ($action === 'create') {
                $stmt = $conn->prepare('INSERT INTO contact_info (id, contact_type, contact_value) VALUES (?, ?, ?)');
                $stmt->bind_param('iss', $userId, $data['contact_type'], $data['contact_value']);
                $ok = $stmt->execute();
                if ($ok) log_event('contact_create', ['id' => $userId, 'contact_id' => $conn->insert_id]);
                echo json_encode(['success' => $ok, 'insert_id' => $conn->insert_id]);
                exit;
            }
            if ($action === 'update') {
                $cid = (int)$data['contact_id'];
                $stmt = $conn->prepare('UPDATE contact_info SET contact_type=?, contact_value=? WHERE contact_id=? AND id=?');
                $stmt->bind_param('ssii', $data['contact_type'], $data['contact_value'], $cid, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('contact_update', ['id' => $userId, 'contact_id' => $cid]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            if ($action === 'delete') {
                $cid = (int)$data['contact_id'];
                $stmt = $conn->prepare('DELETE FROM contact_info WHERE contact_id=? AND id=?');
                $stmt->bind_param('ii', $cid, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('contact_delete', ['id' => $userId, 'contact_id' => $cid]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            json_fail('Unsupported action', 405);

        case 'educational_background':
            if ($action === 'list') {
                $stmt = $conn->prepare('SELECT * FROM educational_background WHERE id=? ORDER BY education_id DESC');
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $res = $stmt->get_result();
                echo json_encode(['success' => true, 'data' => ($res ? $res->fetch_all(MYSQLI_ASSOC) : [])]);
                exit;
            }
            if ($action === 'create') {
                $stmt = $conn->prepare('INSERT INTO educational_background (id, institution_name, degree, field_of_study, start_date, end_date) VALUES (?,?,?,?,?,?)');
                $stmt->bind_param('isssss', $userId, $data['institution_name'], $data['degree'], $data['field_of_study'], $data['start_date'], $data['end_date']);
                $ok = $stmt->execute();
                if ($ok) log_event('education_create', ['id' => $userId, 'education_id' => $conn->insert_id]);
                echo json_encode(['success' => $ok, 'insert_id' => $conn->insert_id]);
                exit;
            }
            if ($action === 'update') {
                $eid = (int)$data['education_id'];
                $stmt = $conn->prepare('UPDATE educational_background SET institution_name=?, degree=?, field_of_study=?, start_date=?, end_date=? WHERE education_id=? AND id=?');
                $stmt->bind_param('sssssis', $data['institution_name'], $data['degree'], $data['field_of_study'], $data['start_date'], $data['end_date'], $eid, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('education_update', ['id' => $userId, 'education_id' => $eid]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            if ($action === 'delete') {
                $eid = (int)$data['education_id'];
                $stmt = $conn->prepare('DELETE FROM educational_background WHERE education_id=? AND id=?');
                $stmt->bind_param('ii', $eid, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('education_delete', ['id' => $userId, 'education_id' => $eid]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            json_fail('Unsupported action', 405);

        case 'skills':
            if ($action === 'list') {
                $stmt = $conn->prepare('SELECT * FROM skills WHERE id=? ORDER BY skill_id DESC');
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $res = $stmt->get_result();
                echo json_encode(['success' => true, 'data' => ($res ? $res->fetch_all(MYSQLI_ASSOC) : [])]);
                exit;
            }
            if ($action === 'create') {
                $skillsShown = isset($data['skills_shown']) ? (int)(bool)$data['skills_shown'] : 0;
                $stmt = $conn->prepare('INSERT INTO skills (id, skill_name, proficiency_level, skills_shown) VALUES (?,?,?,?)');
                $stmt->bind_param('issi', $userId, $data['skill_name'], $data['proficiency_level'], $skillsShown);
                $ok = $stmt->execute();
                if ($ok) log_event('skills_create', ['id' => $userId, 'skill_id' => $conn->insert_id]);
                echo json_encode(['success' => $ok, 'insert_id' => $conn->insert_id]);
                exit;
            }
            if ($action === 'update') {
                $sid = (int)$data['skill_id'];
                $skillsShown = isset($data['skills_shown']) ? (int)(bool)$data['skills_shown'] : 0;
                $stmt = $conn->prepare('UPDATE skills SET skill_name=?, proficiency_level=?, skills_shown=? WHERE skill_id=? AND id=?');
                $stmt->bind_param('siiii', $data['skill_name'], $data['proficiency_level'], $skillsShown, $sid, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('skills_update', ['id' => $userId, 'skill_id' => $sid]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            if ($action === 'delete') {
                $sid = (int)$data['skill_id'];
                $stmt = $conn->prepare('DELETE FROM skills WHERE skill_id=? AND id=?');
                $stmt->bind_param('ii', $sid, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('skills_delete', ['id' => $userId, 'skill_id' => $sid]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            json_fail('Unsupported action', 405);

        case 'fun_personal_touch':
            if ($action === 'list') {
                $stmt = $conn->prepare('SELECT * FROM fun_personal_touch WHERE id=? ORDER BY touch_id DESC');
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $res = $stmt->get_result();
                echo json_encode(['success' => true, 'data' => ($res ? $res->fetch_all(MYSQLI_ASSOC) : [])]);
                exit;
            }
            if ($action === 'create') {
                $stmt = $conn->prepare('INSERT INTO fun_personal_touch (id, description) VALUES (?, ?)');
                $stmt->bind_param('is', $userId, $data['description']);
                $ok = $stmt->execute();
                if ($ok) log_event('fun_create', ['id' => $userId, 'touch_id' => $conn->insert_id]);
                echo json_encode(['success' => $ok, 'insert_id' => $conn->insert_id]);
                exit;
            }
            if ($action === 'update') {
                $tid = (int)$data['touch_id'];
                $stmt = $conn->prepare('UPDATE fun_personal_touch SET description=? WHERE touch_id=? AND id=?');
                $stmt->bind_param('sii', $data['description'], $tid, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('fun_update', ['id' => $userId, 'touch_id' => $tid]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            if ($action === 'delete') {
                $tid = (int)$data['touch_id'];
                $stmt = $conn->prepare('DELETE FROM fun_personal_touch WHERE touch_id=? AND id=?');
                $stmt->bind_param('ii', $tid, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('fun_delete', ['id' => $userId, 'touch_id' => $tid]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            json_fail('Unsupported action', 405);

        case 'message_data':
            if ($action === 'list') {
                $stmt = $conn->prepare('SELECT * FROM message_data WHERE id=? ORDER BY message_type, id');
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $res = $stmt->get_result();
                echo json_encode(['success' => true, 'data' => ($res ? $res->fetch_all(MYSQLI_ASSOC) : [])]);
                exit;
            }
            if ($action === 'create') {
                $stmt = $conn->prepare('INSERT INTO message_data (id, message_text, message_type) VALUES (?,?,?)');
                $stmt->bind_param('isi', $userId, $data['message_text'], $data['message_type']);
                $ok = $stmt->execute();
                if ($ok) log_event('message_create', ['id' => $userId, 'message_type' => $data['message_type']]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            if ($action === 'update') {
                // identify by id + message_type + (text replace)
                $stmt = $conn->prepare('UPDATE message_data SET message_text=? WHERE id=? AND message_type=?');
                $stmt->bind_param('sii', $data['message_text'], $userId, $data['message_type']);
                $ok = $stmt->execute();
                if ($ok) log_event('message_update', ['id' => $userId, 'message_type' => $data['message_type']]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            if ($action === 'delete') {
                $stmt = $conn->prepare('DELETE FROM message_data WHERE id=? AND message_type=?');
                $stmt->bind_param('ii', $userId, $data['message_type']);
                $ok = $stmt->execute();
                if ($ok) log_event('message_delete', ['id' => $userId, 'message_type' => $data['message_type']]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            json_fail('Unsupported action', 405);

        case 'profession':
            if ($action === 'list') {
                $stmt = $conn->prepare('SELECT * FROM profession WHERE id=? ORDER BY is_current DESC, start_date DESC, profession_id DESC');
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $res = $stmt->get_result();
                echo json_encode(['success' => true, 'data' => ($res ? $res->fetch_all(MYSQLI_ASSOC) : [])]);
                exit;
            }
            if ($action === 'create') {
                $isCurrent = isset($data['is_current']) ? (int)(bool)$data['is_current'] : 0;
                $stmt = $conn->prepare('INSERT INTO profession (id, job_title, company_name, start_date, end_date, is_current) VALUES (?,?,?,?,?,?)');
                $stmt->bind_param('issssi', $userId, $data['job_title'], $data['company_name'], $data['start_date'], $data['end_date'], $isCurrent);
                $ok = $stmt->execute();
                if ($ok) log_event('profession_create', ['id' => $userId, 'profession_id' => $conn->insert_id]);
                echo json_encode(['success' => $ok, 'insert_id' => $conn->insert_id]);
                exit;
            }
            if ($action === 'update') {
                $pid = (int)$data['profession_id'];
                $isCurrent = isset($data['is_current']) ? (int)(bool)$data['is_current'] : 0;
                $stmt = $conn->prepare('UPDATE profession SET job_title=?, company_name=?, start_date=?, end_date=?, is_current=? WHERE profession_id=? AND id=?');
                $stmt->bind_param('ssssiii', $data['job_title'], $data['company_name'], $data['start_date'], $data['end_date'], $isCurrent, $pid, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('profession_update', ['id' => $userId, 'profession_id' => $pid]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            if ($action === 'delete') {
                $pid = (int)$data['profession_id'];
                $stmt = $conn->prepare('DELETE FROM profession WHERE profession_id=? AND id=?');
                $stmt->bind_param('ii', $pid, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('profession_delete', ['id' => $userId, 'profession_id' => $pid]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            json_fail('Unsupported action', 405);

        case 'account':
            if ($action === 'get') {
                $res = $conn->query('SELECT username FROM account WHERE id='.(int)$userId.' LIMIT 1');
                $row = $res ? $res->fetch_assoc() : null;
                echo json_encode(['success' => true, 'data' => $row]);
                exit;
            }
            if ($action !== 'update') json_fail('Unsupported action', 405);
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';
            if ($username === '') json_fail('Username required');
            $sql = $password !== ''
                ? 'UPDATE account SET username=?, password_hash=? WHERE id=?'
                : 'UPDATE account SET username=? WHERE id=?';
            if ($password !== '') {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('ssi', $username, $password, $userId);
            } else {
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('si', $username, $userId);
            }
            if (!$stmt) json_fail('Prepare failed', 500);
            $ok = $stmt->execute();
            if ($ok) {
                if ($password !== '') log_event('account_password_change', ['id' => $userId, 'username' => $username]);
                else log_event('account_username_change', ['id' => $userId, 'username' => $username]);
                $_SESSION['edit_user'] = $username;
            }
            echo json_encode(['success' => $ok]);
            exit;

        case 'main_images':
            if ($action === 'list') {
                // List all images except image_id=2 (error handler)
                // Include image_id=1 as default, exclude image_id=2
                $stmt = $conn->prepare('SELECT * FROM main_images WHERE id=? AND image_id != 2 ORDER BY `current_user` DESC, image_id ASC');
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $res = $stmt->get_result();
                $rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
                // Ensure image_id=1 is always included if it exists
                $hasImage1 = false;
                foreach ($rows as $row) {
                    if ($row['image_id'] == 1) {
                        $hasImage1 = true;
                        break;
                    }
                }
                // If image_id=1 doesn't exist in results but exists in DB, fetch it separately
                if (!$hasImage1) {
                    $check1 = $conn->prepare('SELECT * FROM main_images WHERE id=? AND image_id=1 LIMIT 1');
                    $check1->bind_param('i', $userId);
                    $check1->execute();
                    $res1 = $check1->get_result();
                    if ($res1 && $res1->num_rows > 0) {
                        $row1 = $res1->fetch_assoc();
                        array_unshift($rows, $row1); // Add to beginning
                    }
                }
                echo json_encode(['success' => true, 'data' => $rows]);
                exit;
            }
            if ($action === 'set_current') {
                // Set one image as current (current_user=TRUE) and set all others to FALSE
                $imageId = (int)$data['image_id'];
                // First, set all images for this user to FALSE
                $stmt = $conn->prepare('UPDATE main_images SET `current_user` = FALSE WHERE id = ?');
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                // Then, set the selected image to TRUE
                $stmt = $conn->prepare('UPDATE main_images SET `current_user` = TRUE WHERE image_id = ? AND id = ?');
                $stmt->bind_param('ii', $imageId, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('main_image_set_current', ['id' => $userId, 'image_id' => $imageId]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            if ($action === 'delete') {
                $imageId = (int)$data['image_id'];
                // Don't allow deleting image_id=1 (default) or image_id=2 (error handler)
                if ($imageId == 1) json_fail('Cannot delete default image (image_id=1)', 403);
                if ($imageId == 2) json_fail('Cannot delete error handler image (image_id=2)', 403);
                $stmt = $conn->prepare('DELETE FROM main_images WHERE image_id = ? AND id = ?');
                $stmt->bind_param('ii', $imageId, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('main_image_delete', ['id' => $userId, 'image_id' => $imageId]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            json_fail('Unsupported action', 405);

        case 'file_manager':
            if ($action === 'set_current') {
                // Set one file as current (current_use=1) and set all others to 0
                $fileId = (int)$data['file_id'];
                // First, set all files for this user to 0
                $stmt = $conn->prepare('UPDATE file_manager SET current_use = 0 WHERE id = ?');
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                // Then, set the selected file to 1
                $stmt = $conn->prepare('UPDATE file_manager SET current_use = 1 WHERE file_id = ? AND id = ?');
                $stmt->bind_param('ii', $fileId, $userId);
                $ok = $stmt->execute();
                if ($ok) log_event('file_manager_set_current', ['id' => $userId, 'file_id' => $fileId]);
                echo json_encode(['success' => $ok]);
                exit;
            }
            json_fail('Unsupported action', 405);

        default:
            json_fail('Unknown entity', 404);
    }
?>


