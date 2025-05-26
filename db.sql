CREATE DATABASE IF NOT EXISTS scoreapp;
USE scoreapp;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL
);
CREATE TABLE judges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL
);
CREATE TABLE scores (
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
VALUES ('user1', 'Daniel Moss'),
    ('user2', 'Rachel Green'),
    ('user3', 'Ross Geller');
('user4', 'Regina phalange');
('user5', 'sheldon cooper');