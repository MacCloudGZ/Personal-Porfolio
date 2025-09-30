<?php 

    // Function to get table data by table_id (static)
    function getTableData($conn, $user_id, $table_id) {
        $table_data = [];
        
        switch($table_id) {
            case 1: // PERSONAL INFORMATION
                $sql_personal = "SELECT pd.birthdate, pd.sex,
                                        COALESCE(TRIM(BOTH ', ' FROM CONCAT_WS(', ', a.address_line1, NULLIF(TRIM(a.address_line2), ''), a.city, a.state, a.zip_code, a.country)), '') AS full_address
                                 FROM personal_data pd
                                 LEFT JOIN address a ON a.id = pd.id
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
                            'age' => $age,
                            'address' => $address_full
                        ];
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

?>