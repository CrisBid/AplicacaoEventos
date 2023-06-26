CREATE DATABASE db_rio_eventos;

USE db_rio_eventos;

CREATE TABLE IF NOT EXISTS tb_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(50) NOT NULL
);

INSERT INTO tb_users (name, email, password, role) VALUES
    ('Thalisson', 'thalisson@example.com', '0884ndlau72r4', 'admin'),
    ('Leandro', 'leandro@example.com', '014452lau24ty4', 'admin'),
    ('Ricardo', 'ricardo2@example.com', '1932524ih32luy5', 'part'),
    ('João silveira', 'joao4@example.com', '357452jfu2dfy2', 'org'),
    ('Carmem', 'carmemlps5@example.com', '2157423gfhj9dfy6', 'part');
