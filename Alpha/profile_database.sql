-- "This database setup is for open-source purposes
-- no other data will but a default for this system
-- user can do whatever they if they downloaded this
-- project in their local device, or their site
-- noted that user(you) must give credits its owner"
--          -MacCloudKGZ

create database profile_database;

use profile_database;

create TABLE personal_data (
	id INT primary key NOT NULL,
  	firstname varchar(20) NOT NULL,
  	lastname varchar(10),
  	middlename varchar(5),
  	suffix varchar(5),
  	birthdate DATE NOT NULL,
  	status ENUM('Employed','free-lancer','unmployed','retired')
);

create table contacts (
	id int,
	contact_location varchar(4) NOT NULL,
	phone_number int NOT NULL,
	FOREIGN KEY (id) REFERENCES personal_data(id)
);

create table login (
	id int,
	username varchar(20) NOT NULL,
	password varchar(50) NOT NULL,
	FOREIGN KEY (id) REFERENCES personal_data(id)
);

create table profile_image (
	profile_image_locale varchar(99),
	profile_id INT,
	image_part INT NOT NULL,
	FOREIGN KEY (profile_id) REFERENCES personal_data(id)
);


