CREATE TABLE user_acc (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    password VARCHAR(255) NOT NULL, 
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE teacher_records (
    teacher_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    age INT,
    gender VARCHAR(50),
    email VARCHAR(50),
    yrs_of_experience VARCHAR(50),
    position VARCHAR(50), -- Teacher / Head Teacher / Principal
    subject_specialization VARCHAR(50),
    created_by VARCHAR(50),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user_acc(user_id) ON DELETE CASCADE,
    updated_by VARCHAR(50),
    date_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE audit_log (
    audit_id INT AUTO_INCREMENT PRIMARY KEY, 
    username VARCHAR(50), -- admin
    action_made VARCHAR(50), -- edit/delete
    attribute_id INT, -- which table
    details VARCHAR(50), -- "Updated in tutor records"
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);