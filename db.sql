--CREATE DATABASE IF NOT EXISTS scoreapp;
--USE scoreapp;
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL
);
CREATE TABLE IF NOT EXISTS judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL
);
CREATE TABLE IF NOT EXISTS scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judge_id INT NOT NULL,
    score INT NOT NULL CHECK (
        score BETWEEN 1 AND 100
    ),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (judge_id) REFERENCES judges(id)
);
INSERT INTO users (username, display_name)
VALUES ('user5', 'Daniel Moss'),
    ('user6', 'Rachel Green'),
    ('user7', 'Ross Geller'),
    ('user8', 'Regina Phalange'),
    ('user9', 'Sheldon Cooper');