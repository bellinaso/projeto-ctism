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

CREATE TABLE categories(
    id INT auto_increment,
    name VARCHAR(100),
    PRIMARY KEY(id)
);

CREATE TABLE subcategories(
    id INT auto_increment,
    name VARCHAR(100),
    category_id INT,
    PRIMARY KEY(id),
    FOREIGN KEY(category_id) REFERENCES categories(id)
);

CREATE TABLE establishments(
	id INT auto_increment,
    cnpj VARCHAR(18) UNIQUE,
    user_id INT,
    name VARCHAR(200),
    email VARCHAR(100),
    phone VARCHAR(14),
    address VARCHAR(200),
    latitude DOUBLE,
    longitude DOUBLE,
    description VARCHAR(200),
    category_id INT,
    subcategory_id INT,
    creation_date DATE,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(category_id) REFERENCES categories(id),
    FOREIGN KEY(subcategory_id) REFERENCES subcategories(id)
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

CREATE TABLE availability(
    id INT auto_increment,
    service_id INT,
    week_days ENUM('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'),
    start_time TIME,
    PRIMARY KEY(id),
    FOREIGN KEY(service_id) REFERENCES services(id)
);

CREATE TABLE reserves(
    id INT auto_increment,
    user_id INT,
    establishments_id INT,
    service_id INT,
    availability_id INT,
    reserve_date DATE,
    service_date DATE,
    reserve_status ENUM('pending', 'user_cancellation', 'establishment_cancellation', 'completed'),
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(establishments_id) REFERENCES establishments(id),
    FOREIGN KEY(service_id) REFERENCES services(id),
    FOREIGN KEY(availability_id) REFERENCES availability(id)
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

CREATE TABLE states(
    id INT auto_increment,
    name VARCHAR(60),
    PRIMARY KEY(id)
);

CREATE TABLE cities(
    id INT auto_increment,
    name VARCHAR(60),
    state_id INT,
    PRIMARY KEY(id),
    FOREIGN KEY(state_id) REFERENCES states(id)
);

-- DEBUG SECTION

INSERT INTO users (cpf, name, email, phone, state, city, password, user_type, creation_date) VALUES ('12345678901', 'João Silva', 'joao.silva@email.com', '11987654321', 'São Paulo', 'São Paulo', 'senha123', 'user', '2024-10-01');

INSERT INTO users (cpf, name, email, phone, state, city, password, user_type, creation_date) VALUES ('23456789012', 'Maria Oliveira', 'maria.oliveira@email.com', '21987654321', 'Rio de Janeiro', 'Rio de Janeiro', 'senha456', 'manager', '2024-10-02');

INSERT INTO users (cpf, name, email, phone, state, city, password, user_type, creation_date) VALUES ('34567890123', 'Carlos Souza', 'carlos.souza@email.com', '31987654321', 'Minas Gerais', 'Belo Horizonte', 'senha789', 'admin', '2024-10-03');




INSERT INTO states (name) VALUES ('Rio Grande do Sul');

INSERT INTO cities (name, state_id) VALUES ('Santa Maria', (SELECT id FROM states WHERE name = 'Rio Grande do Sul'));




INSERT INTO categories (name) VALUES
('Estilo de Vida e Bem-Estar'),
('Serviços e Manutenção'),
('Educação e Aprendizado'),
('Alimentação e Gastronomia'),
('Lazer e Entretenimento');




INSERT INTO subcategories (name, category_id) VALUES
-- Estilo de Vida e Bem-Estar
('Saúde e Bem-Estar', (SELECT id FROM categories WHERE name = 'Estilo de Vida e Bem-Estar')),
('Beleza e Estética', (SELECT id FROM categories WHERE name = 'Estilo de Vida e Bem-Estar')),
('Esportes e Atividades Físicas', (SELECT id FROM categories WHERE name = 'Estilo de Vida e Bem-Estar')),
('Pets e Animais', (SELECT id FROM categories WHERE name = 'Estilo de Vida e Bem-Estar')),

-- Serviços e Manutenção
('Mecânica e Manutenção Automotiva', (SELECT id FROM categories WHERE name = 'Serviços e Manutenção')),
('Tecnologia e Informática', (SELECT id FROM categories WHERE name = 'Serviços e Manutenção')),

-- Educação e Aprendizado
('Educação e Aulas Particulares', (SELECT id FROM categories WHERE name = 'Educação e Aprendizado')),
('Turismo e Viagens', (SELECT id FROM categories WHERE name = 'Educação e Aprendizado')),

-- Alimentação e Gastronomia
('Gastronomia', (SELECT id FROM categories WHERE name = 'Alimentação e Gastronomia')),

-- Lazer e Entretenimento
('Eventos e Festas', (SELECT id FROM categories WHERE name = 'Lazer e Entretenimento'));




INSERT INTO establishments 
(cnpj, user_id, name, email, phone, address, latitude, longitude, description, category_id, subcategory_id, creation_date)
VALUES
('12345678000195', 1, 'Salão Bela Vida', 'contato@belavida.com', '55999999999', 'Rua das Flores, 123, Centro, Santa Maria, RS, Brasil', -29.6841, -53.8069, 'Salão de beleza especializado em cortes, manicure e pedicure.', 1, 1, '2024-11-18');




INSERT INTO services (establishments_id, name, description, creation_date)
VALUES
(1, 'Corte de Cabelo', 'Serviço de corte de cabelo masculino e feminino, com profissionais especializados.', '2024-11-18'),
(1, 'Manicure e Pedicure', 'Cuidado com unhas, com técnicas de embelezamento e saúde.', '2024-11-18'),
(1, 'Consulta Médica', 'Atendimento clínico com profissionais qualificados para diversas especialidades.', '2024-11-18'),
(1, 'Consulta Médica', 'Atendimento clínico com profissionais qualificados para diversas especialidades.', '2024-11-18');




INSERT INTO availability (service_id, week_days, start_time)
VALUES
-- Disponibilidade para 'Corte de Cabelo' (service_id 1)
(1, 'monday', '09:00:00'),
(1, 'monday', '14:00:00'),
(1, 'tuesday', '10:00:00'),
(1, 'tuesday', '15:00:00'),
(1, 'wednesday', '09:30:00'),
(1, 'wednesday', '16:00:00'),
(1, 'thursday', '11:00:00'),
(1, 'thursday', '17:00:00'),
(1, 'friday', '10:30:00'),
(1, 'saturday', '12:00:00'),

-- Disponibilidade para 'Manicure e Pedicure' (service_id 2)
(2, 'monday', '08:00:00'),
(2, 'monday', '13:30:00'),
(2, 'tuesday', '09:00:00'),
(2, 'wednesday', '14:00:00'),
(2, 'wednesday', '18:00:00'),
(2, 'thursday', '08:30:00'),
(2, 'thursday', '13:00:00'),
(2, 'friday', '10:00:00'),
(2, 'friday', '15:30:00'),
(2, 'saturday', '09:30:00'),

-- Disponibilidade para 'Consulta Médica' (service_id 3)
(3, 'monday', '07:00:00'),
(3, 'monday', '11:00:00'),
(3, 'tuesday', '08:00:00'),
(3, 'tuesday', '12:30:00'),
(3, 'wednesday', '09:00:00'),
(3, 'thursday', '10:30:00'),
(3, 'friday', '14:00:00'),
(3, 'friday', '17:00:00'),
(3, 'saturday', '08:30:00'),
(3, 'saturday', '13:00:00'),

-- Disponibilidade para 'Consulta Médica' (service_id 3)
(4, 'monday', '07:00:00'),
(4, 'monday', '11:00:00'),
(4, 'tuesday', '08:00:00'),
(4, 'tuesday', '12:30:00'),
(4, 'wednesday', '09:00:00'),
(4, 'thursday', '10:30:00'),
(4, 'friday', '14:00:00'),
(4, 'friday', '17:00:00'),
(4, 'saturday', '08:30:00'),
(4, 'saturday', '13:00:00');




INSERT INTO reserves (user_id, establishments_id, service_id, availability_id, reserve_date, service_date, reserve_status)
VALUES
(2, 1, 3, 35, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 2 DAY), 'pending'),
(2, 1, 3, 35, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 3 DAY), 'pending'),
(2, 1, 3, 35, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 4 DAY), 'completed'),
(2, 1, 3, 35, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 5 DAY), 'establishment_cancellation'),
(2, 1, 3, 35, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 6 DAY), 'establishment_cancellation'),
(2, 1, 3, 35, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'pending');