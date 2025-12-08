
CREATE DATABASE MacCloud;
USE MacCloud;

CREATE TABLE job_status (
    status_id INT PRIMARY KEY,
    status_label VARCHAR(100)
);

INSERT INTO job_status (status_id, status_label) VALUES
(1, 'Employed'),
(2, 'Free-Lance'),
(3, 'Unemployed'),
(4, 'Retired');

CREATE TABLE personal_data (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    middlename VARCHAR(100),
    lastname VARCHAR(100) NOT NULL,
    suffix VARCHAR(10),
    birthdate DATE,
    status_id INT,
    sex enum('Male', 'Female', 'Other'),
    FOREIGN KEY (status_id) REFERENCES job_status(status_id)
);
INSERT INTO personal_data (id, firstname, middlename, lastname, suffix, birthdate, status_id, sex)
VALUES (1, 'Kurt Gabrielle', 'Bermejo', 'Zabala', NULL, '2005-05-09', 2, 'Male');

CREATE TABLE address (
    address_id INT PRIMARY KEY AUTO_INCREMENT,
    id INT,
    address_line1 VARCHAR(255) NOT NULL,
    address_line2 VARCHAR(255),
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    zip_code VARCHAR(10) NOT NULL,
    country VARCHAR(100) NOT NULL,
    show_Address BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (id) REFERENCES personal_data(id)
);
INSERT INTO address (id, address_line1, address_line2, city, state, zip_code, country)
VALUES (1, '123 Main St', 'Apt 4B', 'Anytown', 'CA', '12345', 'USA');  

CREATE TABLE account (
    id INT, 
    username VARCHAR(50) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    FOREIGN KEY (id) REFERENCES personal_data(id)
);

INSERT INTO account (id, username, password_hash)
VALUES (1, 'admin', 'admin');

CREATE TABLE table_arranger (
    table_id INT PRIMARY KEY,
    table_name VARCHAR(255),
    table_possition INT
);

INSERT INTO table_arranger (table_id, table_name, table_possition)
VALUES (1, 'PERSONAL INFORMATION', 1),
(2, 'CONTACT INFO', 2),
(3, 'EDUCATIONAL BACKGROUND', 3),
(4, 'SKILLS', 4),
(5, 'FUN / PERSONAL TOUCH', 5),
(6,'PROFESSION',6);

CREATE TABLE profession (
    profession_id INT PRIMARY KEY AUTO_INCREMENT,
    id INT,
    job_title VARCHAR(100) NOT NULL,
    company_name VARCHAR(100),
    start_date DATE,
    end_date DATE,
    is_current BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id) REFERENCES personal_data(id)
);

INSERT INTO profession (id, job_title, company_name, start_date, end_date, is_current)
VALUES (1, 'Web Developer', 'Tech Solutions', '2020-06-01', NULL, TRUE),
(1, 'Intern', 'Web Startups', '2019-06-01', '2019-08-31', FALSE);

CREATE TABLE skills (
    skill_id INT PRIMARY KEY AUTO_INCREMENT,
    id INT,
    skill_name VARCHAR(100) NOT NULL,
    proficiency_level INT,
    skills_shown BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id) REFERENCES personal_data(id),
    CHECK (proficiency_level BETWEEN 1 AND 10)
);

INSERT INTO skills (id, skill_name, proficiency_level)
VALUES (1, 'HTML', 8),
(1, 'CSS', 7),
(1, 'JavaScript', 6);

CREATE TABLE contact_info (
    contact_id INT PRIMARY KEY AUTO_INCREMENT,
    id INT,
    contact_type VARCHAR(50) NOT NULL,
    contact_value VARCHAR(255) NOT NULL,
    FOREIGN KEY (id) REFERENCES personal_data(id)
);
INSERT INTO contact_info (id, contact_type, contact_value)
VALUES (1, 'Email', 'abx@mmg.com'),
(1, 'Phone', '+1234567890');

CREATE TABLE educational_background (
    education_id INT PRIMARY KEY AUTO_INCREMENT,
    id INT,
    institution_name VARCHAR(255) NOT NULL,
    degree VARCHAR(100),
    field_of_study VARCHAR(100),
    start_date DATE,
    end_date DATE,
    FOREIGN KEY (id) REFERENCES personal_data(id)
);
INSERT INTO educational_background (id, institution_name, degree, field_of_study, start_date, end_date) 
VALUES (1, 'University of Example', 'Bachelor of Science', 'Computer Science', '2015-08-01', '2019-05-15'),
(1, 'Example High School', 'High School Diploma', NULL, '2011-09-01', '2015-06-15');

CREATE TABLE fun_personal_touch (
    touch_id INT PRIMARY KEY AUTO_INCREMENT,
    id INT,
    description TEXT NOT NULL,
    FOREIGN KEY (id) REFERENCES personal_data(id)
);
INSERT INTO fun_personal_touch (id, description)
VALUES (1, 'I love hiking and outdoor adventures.'),
(1, 'I play the guitar in my free time.');

-- for data of the site

CREATE TABLE message_data (
    id INT,
    message_text TEXT,
    message_type INT NOT NULL,
    FOREIGN KEY(id) REFERENCES personal_data(id)
);

INSERT INTO message_data (id, message_text, message_type)
VALUES (1, 'Hello, this is a test message.', 1),
(1, 'This is another message for testing.', 2);

CREATE TABLE main_images (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    id INT,
    image_path VARCHAR(255) NOT NULL,
    current_user BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id) REFERENCES personal_data(id)
);

INSERT INTO main_images (id, image_path, current_user)
VALUES (1, 'Properties/Images/Default_Profile.webp', TRUE),
(1, 'Properties/Images/image-error404.webp', FALSE);

CREATE TABLE file_manager (
    file_id INT PRIMARY KEY AUTO_INCREMENT,
    id INT,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    current_use BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id) REFERENCES personal_data(id)
);
-- Project manager tables

CREATE TABLE IF NOT EXISTS add_project_manual (
    project_id INT PRIMARY KEY AUTO_INCREMENT,
    project_name VARCHAR(255) NOT NULL,
    description TEXT,
    date_creation DATE NOT NULL,
    isvisible ENUM('public','private','partially') DEFAULT 'public'
);

CREATE TABLE IF NOT EXISTS config_update (
    update_time TIME NOT NULL,
    schedule ENUM('day','week','month') DEFAULT 'day'
);

-- Seed a default config if not exists
INSERT INTO config_update (update_time, schedule)
SELECT '03:00:00', 'day'
WHERE NOT EXISTS (SELECT 1 FROM config_update);

CREATE TABLE IF NOT EXISTS accounts_bind (
    account_bind_id INT PRIMARY KEY AUTO_INCREMENT,
    account_link VARCHAR(512) NOT NULL
);

CREATE TABLE IF NOT EXISTS temp_github_project (
    account_bind_id INT,
    gitproject_id INT PRIMARY KEY,
    gitproject_name VARCHAR(255) NOT NULL,
    gitdescription TEXT,
    gitdate_creation DATE NOT NULL,
    gitisvisible ENUM('public','private','partially') DEFAULT 'public'
);