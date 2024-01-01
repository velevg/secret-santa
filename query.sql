CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL,
    group_ids VARCHAR(255),
    -- group_ids is a comma-separated list of group IDs
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    user_agent VARCHAR(255),
    ip VARCHAR(45)
);
CREATE TABLE groups (
    id INT PRIMARY KEY AUTO_INCREMENT,
    group_name VARCHAR(50) NOT NULL,
    owner INT NOT NULL,
    FOREIGN KEY (owner) REFERENCES users(id),
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
CREATE TABLE user_groups (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    group_id INT,
    user_id INT,
    selected tinyint(1) DEFAULT 0,
    selected_user INT,
    last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (group_id) REFERENCES groups(id),
    FOREIGN KEY (selected_user) REFERENCES users(id)
);
-- CREATE TABLE groups (
--     id INT PRIMARY KEY AUTO_INCREMENT,
--     group_name VARCHAR(50) NOT NULL,
--     owner INT NOT NULL,
--     user_id INT,
--     selected tinyint(1) DEFAULT 0,
--     selected_user INT,
--     last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--     FOREIGN KEY (owner) REFERENCES users(id),
--     FOREIGN KEY (user_id) REFERENCES users(id),
--     FOREIGN KEY (selected_user) REFERENCES users(id)
-- );
-- Truncate the tables
-- Disable foreign key checks
SET foreign_key_checks = 0;
-- Truncate tables
TRUNCATE TABLE groups;
TRUNCATE TABLE users;
-- Enable foreign key checks
SET foreign_key_checks = 1;
-- Get all foreign keys
SELECT CONSTRAINT_NAME,
    TABLE_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE
WHERE REFERENCED_TABLE_SCHEMA = 'secret_santa'
    AND REFERENCED_TABLE_NAME = 'users';
-- Drop foreign keys
ALTER TABLE user_groups DROP FOREIGN KEY user_groups_ibfk_2;
ALTER TABLE user_groups DROP FOREIGN KEY user_groups_ibfk_1;