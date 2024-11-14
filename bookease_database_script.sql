DROP DATABASE IF EXISTS bookease;

CREATE DATABASE bookease;

USE bookease;

CREATE TABLE users(
	id int auto_increment,
    cpf VARCHAR(11) UNIQUE,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(11) UNIQUE,
    state VARCHAR(80),
    city VARCHAR(80),
    password VARCHAR(100),
    user_type enum('user','admin','manager'),
    creation_date DATE,
    PRIMARY KEY(id)
);

CREATE TABLE establishments(
	id INT auto_increment,
    cnpj VARCHAR(18) UNIQUE,
    user_id INT,
    name VARCHAR(200),
    email VARCHAR(100),
    phone VARCHAR(14),
    adress VARCHAR(200),
    latitude DOUBLE,
    longitude DOUBLE,
    description VARCHAR(200),
    creation_date DATE,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE reserves(
    id INT auto_increment,
    user_id INT,
    establishments_id INT,
    reserve_date DATE,
    service_date DATE,
    reserve_status ENUM('pending', 'cancelled', 'completed'),
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(establishments_id) REFERENCES establishments(id)
);

CREATE TABLE services(
    id INT auto_increment,
    establishments_id INT,
    name VARCHAR(100),
    description TEXT,
    creation_date DATE,
    PRIMARY KEY(id),
    FOREIGN KEY(establishments_id) REFERENCES establishments(id)
);

CREATE TABLE reviews(
    id INT auto_increment,
    reserve_id INT,
    review_note INT,
    commentary TEXT,
    review_date DATE,
    PRIMARY KEY(id),
    FOREIGN KEY(reserve_id) REFERENCES reserves(id)
);

CREATE TABLE availability(
    id INT auto_increment,
    service_id INT,
    week_days ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'),
    start_time TIME,
    finish_time TIME,
    PRIMARY KEY(id),
    FOREIGN KEY(service_id) REFERENCES services(id)
);

CREATE TABLE categories(
    id INT auto_increment,
    name VARCHAR(100),
    description VARCHAR(100),
    PRIMARY KEY(id)
);

CREATE TABLE services_categories(
    service_id INT,
    category_id INT,
    FOREIGN KEY(service_id) REFERENCES services(id),
    FOREIGN KEY(category_id) REFERENCES categories(id)
);

CREATE TABLE states(
    id INT auto_increment,
    state VARCHAR(60),
    PRIMARY KEY(id)
);

CREATE TABLE cities(
    id INT auto_increment,
    city VARCHAR(60),
    state_id INT,
    PRIMARY KEY(id),
    FOREIGN KEY(state_id) REFERENCES states(id)
);

-- DEBUG SECTION

INSERT INTO users (cpf, name, email, phone, state, city, password, user_type, creation_date) VALUES ('12345678901', 'João Silva', 'joao.silva@email.com', '11987654321', 'São Paulo', 'São Paulo', 'senha123', 'user', '2024-10-01');

INSERT INTO users (cpf, name, email, phone, state, city, password, user_type, creation_date) VALUES ('23456789012', 'Maria Oliveira', 'maria.oliveira@email.com', '21987654321', 'Rio de Janeiro', 'Rio de Janeiro', 'senha456', 'manager', '2024-10-02');

INSERT INTO users (cpf, name, email, phone, state, city, password, user_type, creation_date) VALUES ('34567890123', 'Carlos Souza', 'carlos.souza@email.com', '31987654321', 'Minas Gerais', 'Belo Horizonte', 'senha789', 'admin', '2024-10-03');


INSERT INTO states (state) VALUES ('Rio Grande do Sul');

INSERT INTO cities (city, state_id) VALUES ('Santa Maria', (SELECT id FROM states WHERE state = 'Rio Grande do Sul'));
