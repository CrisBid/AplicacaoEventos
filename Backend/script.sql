 
CREATE DATABASE IF NOT EXISTS db_rio_eventos;

USE db_rio_eventos;

CREATE TABLE IF NOT EXISTS tb_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    role VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS tb_events (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(45) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    local VARCHAR(45),
    category VARCHAR(45),
    price DECIMAL(10, 2),
    img VARCHAR(45)
);


CREATE TABLE IF NOT EXISTS user_event (
    user_id INT,
    event_id INT(6) UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES tb_users(id),
    FOREIGN KEY (event_id) REFERENCES tb_events(id),
    PRIMARY KEY (user_id, event_id)
);
