<?php 

    // Function to get table data by table_id (static)
    function getTableData($conn, $user_id, $table_id) {
        $table_data = [];
        
        switch($table_id) {
            case 1: // PERSONAL INFORMATION
                $sql_personal = "SELECT pd.birthdate, pd.sex,
                                        COALESCE(TRIM(BOTH ', ' FROM CONCAT_WS(', ', a.address_line1, NULLIF(TRIM(a.address_line2), ''), a.city, a.state, a.zip_code, a.country)), '') AS full_address
                                 FROM personal_data pd
                                 LEFT JOIN address a ON a.id = pd.id AND a.show_Address = TRUE
                                 WHERE pd.id = ?";
                $stmt_personal = $conn->prepare($sql_personal);
                if ($stmt_personal) {
                    $stmt_personal->bind_param('i', $user_id);
                    $stmt_personal->execute();
                    $result_personal = $stmt_personal->get_result();
                    $row_personal = $result_personal->fetch_assoc();
                    
                    if ($row_personal) {
                        $birthdate = $row_personal['birthdate'];
                        $age = $birthdate ? date('Y') - date('Y', strtotime($birthdate)) : '';
                        $address_full = $row_personal['full_address'] ?? '';

                        $table_data = [
                            'birthdate' => $birthdate,
                            'sex' => $row_personal['sex'] ?? '',
                            'age' => $age
                        ];                    
                        if (!empty($address_full)) {
                            $table_data['address'] = $address_full;
                        }
                    }
                }
                break;
                
            case 2: // CONTACT INFO
                $sql_contact = "SELECT contact_type, contact_value FROM contact_info WHERE id = ?";
                $stmt_contact = $conn->prepare($sql_contact);
                if ($stmt_contact) {
                    $stmt_contact->bind_param('i', $user_id);
                    $stmt_contact->execute();
                    $result_contact = $stmt_contact->get_result();
                    $contacts = [];
                    while ($row_contact = $result_contact->fetch_assoc()) {
                        $contacts[] = [
                            'contact_type' => $row_contact['contact_type'],
                            'contact_value' => $row_contact['contact_value']
                        ];
                    }
                    $table_data = [
                        'contacts' => $contacts
                    ];
                }
                break;
                
            case 3: // EDUCATIONAL BACKGROUND
                $sql_education = "SELECT CONCAT(institution_name, IF(field_of_study IS NOT NULL, CONCAT(' - ', field_of_study), '')) AS institution_info, 
                                 degree, start_date, end_date FROM educational_background WHERE id = ?";
                $stmt_education = $conn->prepare($sql_education);
                if ($stmt_education) {
                    $stmt_education->bind_param('i', $user_id);
                    $stmt_education->execute();
                    $result_education = $stmt_education->get_result();
                    $education = [];
                    while ($row_education = $result_education->fetch_assoc()) {
                        $education[] = [
                            'institution_info' => $row_education['institution_info'],
                            'degree' => $row_education['degree'],
                            'start_date' => $row_education['start_date'],
                            'end_date' => $row_education['end_date']
                        ];
                    }
                    $table_data = [
                        'education' => $education
                    ];
                }
                break;
                
            case 4: // SKILLS
                $sql_skills = "SELECT skill_name, proficiency_level FROM skills WHERE id = ? AND skills_shown = TRUE";
                $stmt_skills = $conn->prepare($sql_skills);
                if ($stmt_skills) {
                    $stmt_skills->bind_param('i', $user_id);
                    $stmt_skills->execute();
                    $result_skills = $stmt_skills->get_result();
                    $skills = [];
                    while ($row_skill = $result_skills->fetch_assoc()) {
                        $skills[] = [
                            'skill_name' => $row_skill['skill_name'],
                            'proficiency_level' => $row_skill['proficiency_level']
                        ];
                    }
                    $table_data = [
                        'skills' => $skills
                    ];
                }
                break;
                
            case 5: // FUN / PERSONAL TOUCH
                $sql_fun = "SELECT description FROM fun_personal_touch WHERE id = ?";
                $stmt_fun = $conn->prepare($sql_fun);
                if ($stmt_fun) {
                    $stmt_fun->bind_param('i', $user_id);
                    $stmt_fun->execute();
                    $result_fun = $stmt_fun->get_result();
                    $fun_descriptions = [];
                    while ($row_fun = $result_fun->fetch_assoc()) {
                        $fun_descriptions[] = $row_fun['description'];
                    }
                    $table_data = [
                        'descriptions' => $fun_descriptions
                    ];
                }
                break;
                
            case 6: // PROFESSION
                $sql_profession = "SELECT job_title, company_name, start_date, end_date, is_current FROM profession WHERE id = ?";
                $stmt_profession = $conn->prepare($sql_profession);
                if ($stmt_profession) {
                    $stmt_profession->bind_param('i', $user_id);
                    $stmt_profession->execute();
                    $result_profession = $stmt_profession->get_result();
                    $professions = [];
                    while ($row_profession = $result_profession->fetch_assoc()) {
                        $professions[] = [
                            'job_title' => $row_profession['job_title'],
                            'company_name' => $row_profession['company_name'],
                            'start_date' => $row_profession['start_date'],
                            'end_date' => $row_profession['end_date'],
                            'is_current' => $row_profession['is_current']
                        ];
                    }
                    $table_data = [
                        'professions' => $professions
                    ];
                }
                break;
        }
        
        return $table_data;
    }

    // Function to map a table_possition to its table_id and return data
    function getTargetTable($table_position) {
        global $conn, $user_id;
        $sql = "SELECT table_id FROM table_arranger WHERE table_possition = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            return [];
        }
        $stmt->bind_param('i', $table_position);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (!$row) {
            return [];
        }
        $table_id = (int)$row['table_id'];
        return getTableData($conn, $user_id, $table_id);
    }

    // Determine a display title for a box based on known keys
    function getBoxTitle($box_info) {
        if (!is_array($box_info) || empty($box_info)) {
            return 'INFO';
        }
        $hasContacts = isset($box_info['contacts']) && is_array($box_info['contacts']);
        $hasSkills = isset($box_info['skills']) && is_array($box_info['skills']);
        $hasEducation = isset($box_info['education']) && is_array($box_info['education']);
        $hasDescriptions = isset($box_info['descriptions']) && is_array($box_info['descriptions']);
        $hasProfessions = isset($box_info['professions']) && is_array($box_info['professions']);

        if ($hasContacts) return 'CONTACT INFO';
        if ($hasSkills) return 'SKILLS';
        if ($hasEducation) return 'EDUCATIONAL BACKGROUND';
        if ($hasDescriptions) return 'FUN / PERSONAL TOUCH';
        if ($hasProfessions) return 'PROFESSION';
        return 'INFO';
    }

    // Render table rows for any box structure; echoes HTML <tr> rows
    function renderBoxRows($box_info) {
        if (!is_array($box_info) || empty($box_info)) {
            return;
        }

        $recognizedKeys = ['contacts','skills','education','descriptions','professions'];

        // contacts
        if (isset($box_info['contacts']) && is_array($box_info['contacts'])) {
            foreach ($box_info['contacts'] as $contact) {
                $type = isset($contact['contact_type']) ? htmlspecialchars($contact['contact_type']) : '';
                $value = isset($contact['contact_value']) ? htmlspecialchars($contact['contact_value']) : '';
                echo "<tr><td>{$type}</td><th>-</th><td>{$value}</td></tr>";
            }
        }

        // skills
        if (isset($box_info['skills']) && is_array($box_info['skills'])) {
            foreach ($box_info['skills'] as $skill) {
                $name = isset($skill['skill_name']) ? htmlspecialchars($skill['skill_name']) : '';
                $levelRaw = isset($skill['proficiency_level']) ? $skill['proficiency_level'] : 0;
                $levelInt = is_numeric($levelRaw) ? (int)$levelRaw : 0;

                if ($levelInt <= 0) {
                    $iconHtml = '<svg role="img" aria-label="No skill" viewBox="0 0 24 24" width="32" height="32" xmlns="http://www.w3.org/2000/svg"><title>No skill</title><rect x="4" y="4" width="16" height="16" rx="3" fill="#ff4d4f"/></svg>';
                } elseif ($levelInt <= 5) {
                    $iconHtml = '<svg role="img" aria-label="Bronze crown" viewBox="0 0 24 24" width="32" height="32" xmlns="http://www.w3.org/2000/svg"><title>Bronze crown</title><path d="M12 2l2.9 6.3L22 9l-4.5 3.9L19 20 12 16.8 5 20l1.5-7.1L2 9l7.1-.7L12 2z" fill="#cd7f32"/></svg>';
                } elseif ($levelInt <= 9) {
                    $iconHtml = '<svg role="img" aria-label="Silver crown" viewBox="0 0 24 24" width="32" height="32" xmlns="http://www.w3.org/2000/svg"><title>Silver crown</title><path d="M12 2l2.9 6.3L22 9l-4.5 3.9L19 20 12 16.8 5 20l1.5-7.1L2 9l7.1-.7L12 2z" fill="#c0c0c0"/></svg>';
                } else { // 10 or above
                    $iconHtml = '<svg role="img" aria-label="Gold crown" viewBox="0 0 24 24" width="32" height="32" xmlns="http://www.w3.org/2000/svg"><title>Gold crown</title><path d="M12 2l2.9 6.3L22 9l-4.5 3.9L19 20 12 16.8 5 20l1.5-7.1L2 9l7.1-.7L12 2z" fill="#ffd700"/></svg>';
                }

                echo "<tr><td>{$name}</td><th>-</th><td>{$iconHtml}</td></tr>";
            }
        }

        // education
        if (isset($box_info['education']) && is_array($box_info['education'])) {
            foreach ($box_info['education'] as $edu) {
                $institution = isset($edu['institution_info']) ? htmlspecialchars($edu['institution_info']) : '';
                $degree = isset($edu['degree']) ? htmlspecialchars($edu['degree']) : '';
                $start = isset($edu['start_date']) ? htmlspecialchars($edu['start_date']) : '';
                $end = isset($edu['end_date']) ? htmlspecialchars($edu['end_date']) : '';
                echo "<tr><td>{$institution}</td></tr>";
                echo "<tr><th>-</th><td>{$degree}</td></tr>";
                $range = $start . ($end ? ' to ' . $end : '');
                echo "<tr><th>-</th><td>{$range}</td></tr>";
            }
        }

        // descriptions
        if (isset($box_info['descriptions']) && is_array($box_info['descriptions'])) {
            foreach ($box_info['descriptions'] as $desc) {
                $text = htmlspecialchars($desc);
                echo "<tr><td> - {$text}</td></tr>";
            }
        }

        // professions
        if (isset($box_info['professions']) && is_array($box_info['professions'])) {
            foreach ($box_info['professions'] as $prof) {
                $job = isset($prof['job_title']) ? htmlspecialchars($prof['job_title']) : '';
                $company = isset($prof['company_name']) ? htmlspecialchars($prof['company_name']) : '';
                $start = isset($prof['start_date']) ? htmlspecialchars($prof['start_date']) : '';
                $end = isset($prof['end_date']) ? htmlspecialchars($prof['end_date']) : '';
                $isCurrent = !empty($prof['is_current']);
                echo "<tr><td>{$job}</td></tr>";
                echo "<tr><th>-</th><td>{$company}</td></tr>";
                $range = $start . ($end ? ' to ' . $end : ($isCurrent ? ' (Current)' : ''));
                echo "<tr><th>-</th><td>{$range}</td></tr>";
            }
        }

        // Generic fallback rows for any other keys
        foreach ($box_info as $key => $value) {
            if (in_array($key, $recognizedKeys, true)) {
                continue;
            }
            $label = htmlspecialchars(ucwords(str_replace('_', ' ', (string)$key)));
            if (is_array($value)) {
                $encoded = htmlspecialchars(json_encode($value));
                echo "<tr><td>{$label}</td><th>-</th><td>{$encoded}</td></tr>";
            } else {
                $text = htmlspecialchars((string)$value);
                echo "<tr><td>{$label}</td><th>-</th><td>{$text}</td></tr>";
            }
        }
    }

?>