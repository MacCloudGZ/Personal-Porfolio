create database MacCloud;

use MacCloud;

create table job_status (
    status_id INT PRIMARY KEY,
    status_label VARCHAR(100)
);

INSERT INTO job_status (status_id, status_label) VALUES
(1, 'Employed'),
(2, 'Free-Lance'),
(3, 'Unemployed'),
(4, 'Retired');

create table personal_data (
    id INT PRIMARY KEY AUTO_INCREAMENT NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    middlename VARCHAR(100),
    lastname VARCHAR(100) NOT NULL,
    suffix VARCHAR(10),
    birthdate DATE,
    status_id INT,
    FOREIGN KEY (status_id) REFERENCES job_status(status_id)
);

INSERT INTO personal_data (id, firstname, middlename, lastname, suffix,birthdate, status_id)
VALUES (1,'Anon','Anon','anon',NULL,'01-01-2001',2);

create table message_data (
    id INT,
    message_text VARCHAR(MAX),
    message_type INT PRIMARY KEY,
    FOREIGN KEY(id) REFERENCES personal_data(id);
)

INSERT INTO

