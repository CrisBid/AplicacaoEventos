--Dropa todo o banco e cria denovo, pq pode dar BO nos relacionamento
-- add usuarios pelo POST na rota users/register e depois testa o login

CREATE DATABASE IF NOT EXISTS db_rio_eventos;

USE db_rio_eventos;

CREATE TABLE IF NOT EXISTS tb_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS events (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    e_name VARCHAR(45) NOT NULL,
    e_description VARCHAR(200) NOT NULL,
    e_date DATE NOT NULL,
    e_time TIME NOT NULL,
    e_local VARCHAR(45),
    category VARCHAR(45),
    price DECIMAL(10, 2),
    img VARCHAR(45)
);

CREATE TABLE IF NOT EXISTS user_event (
    user_id INT,
    event_id INT(6) UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES tb_users(id),
    FOREIGN KEY (event_id) REFERENCES events(id),
    PRIMARY KEY (user_id, event_id)
);
