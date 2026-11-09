CREATE DATABASE IF NOT EXISTS ctf_db;
USE ctf_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(100)
);

CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL,
    uploaded_by VARCHAR(50),
    upload_date DATETIME
);

INSERT INTO users (username, password, email) VALUES 
('admin', 'zssoib{Th1s_1s_N0t_Th3_Fl4g}', 'admin@localhost.com'),
('user1', 'password123', 'user1@example.com');

CREATE TABLE flags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    flag_content VARCHAR(255)
);

INSERT INTO flags (flag_content) VALUES ('CTF{SQL_1nj3ct10n_And_SSRF_M4st3r}');
