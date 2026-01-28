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
    image VARCHAR(100),
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
    description VARCHAR(200),
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

CREATE TABLE csrf_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(191) NOT NULL UNIQUE,
    expiration_date DATETIME NOT NULL,
    FOREIGN KEY(user_id) REFERENCES user(id)
);

-- DEBUG: TEST INSERTS

INSERT INTO users (cpf, name, email, phone, state, city, password, user_type, creation_date) VALUES
('12345678901', 'Maria Silva', 'maria.silva@gmail.com', '11987654321', 'São Paulo', 'São Paulo', 'senha123', 'user', '2024-11-21'),
('98765432100', 'João Oliveira', 'joao.oliveira@yahoo.com', '21987654321', 'Rio de Janeiro', 'Rio de Janeiro', 'senha123', 'user', '2024-11-20'),
('45678912309', 'Ana Costa', 'ana.costa@hotmail.com', '31987654321', 'Minas Gerais', 'Belo Horizonte', 'senha123', 'manager', '2024-11-19'),
('65432198708', 'Carlos Pereira', 'carlos.pereira@outlook.com', '41987654321', 'Paraná', 'Curitiba', 'senha123', 'admin', '2024-11-18'),
('78912345607', 'Fernanda Lima', 'fernanda.lima@gmail.com', '51987654321', 'Rio Grande do Sul', 'Porto Alegre', 'senha123', 'user', '2024-11-17'),
('32165498706', 'Lucas Santos', 'lucas.santos@gmail.com', '61987654321', 'Distrito Federal', 'Brasília', 'senha123', 'user', '2024-11-16'),
('98712365405', 'Juliana Mendes', 'juliana.mendes@gmail.com', '71987654321', 'Bahia', 'Salvador', 'senha123', 'manager', '2024-11-15'),
('12398745604', 'Roberto Almeida', 'roberto.almeida@gmail.com', '81987654321', 'Pernambuco', 'Recife', 'senha123', 'user', '2024-11-14'),
('45632178903', 'Carolina Souza', 'carolina.souza@gmail.com', '91987654321', 'Ceará', 'Fortaleza', 'senha123', 'admin', '2024-11-13'),
('65498732102', 'Pedro Gonçalves', 'pedro.goncalves@gmail.com', '21912345678', 'Espírito Santo', 'Vitória', 'senha123', 'user', '2024-11-12');




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




INSERT INTO establishments (cnpj, user_id, name, email, phone, image, address, latitude, longitude, description, category_id, subcategory_id, creation_date) VALUES
('12345678000190', 3, 'Academia Bem-Estar', 'contato@academiabemestar.com', '5532245678', '12345678000190', 'Av. Presidente Vargas, 1200', -29.68922, -53.80694, 'Academia com foco em saúde e bem-estar', 1, 3, '2024-11-21'),
('98765432000180', 7, 'Pet Center Santa Maria', 'contato@petcentersm.com', '5532249876', '98765432000180', 'Rua Venâncio Aires, 345', -29.68344, -53.80601, 'Serviços completos para pets e animais', 1, 4, '2024-11-20');

INSERT INTO establishments (cnpj, user_id, name, email, phone, image, address, latitude, longitude, description, category_id, subcategory_id, creation_date) VALUES
('11223344000155', 3, 'Restaurante Sabor Gaúcho', 'contato@saborgaucho.com', '5532233344', '11223344000155', 'Rua do Acampamento, 789', -29.68772, -53.81200, 'Especialidades da culinária gaúcha', 4, 9, '2024-11-19'),
('44556778000111', 7, 'TechFix Informática', 'contato@techfixsm.com', '5532211234', '44556778000111', 'Av. Rio Branco, 567', -29.68845, -53.81032, 'Manutenção e suporte de tecnologia', 2, 6, '2024-11-18');





-- Serviços para "Academia Bem-Estar" (establishment id: 1)
INSERT INTO services (establishments_id, name, description, creation_date) VALUES
(1, 'Treinamento Funcional', 'Aprimore seu condicionamento físico com nossos treinos personalizados.', '2024-11-21'),
(1, 'Aulas de Yoga', 'Relaxe e fortaleça o corpo com práticas de yoga.', '2024-11-21'),
(1, 'Musculação', 'Espaço completo com equipamentos modernos.', '2024-11-21'),
(1, 'Personal Trainer', 'Treinamento individual com profissionais especializados.', '2024-11-21'),
(1, 'Avaliação Física', 'Acompanhe seu progresso com avaliações periódicas.', '2024-11-21');

-- Serviços para "Pet Center Santa Maria" (establishment id: 2)
INSERT INTO services (establishments_id, name, description, creation_date) VALUES
(2, 'Banho e Tosa', 'Cuidados completos para higiene e estética do seu pet.', '2024-11-20'),
(2, 'Consulta Veterinária', 'Atendimento médico especializado para seu animal.', '2024-11-20'),
(2, 'Creche para Pets', 'Espaço seguro e divertido para o dia a dia do seu pet.', '2024-11-20'),
(2, 'Venda de Rações', 'Rações e suplementos das melhores marcas.', '2024-11-20'),
(2, 'Adestramento', 'Cursos de adestramento para cães de todas as raças.', '2024-11-20');

-- Serviços para "Restaurante Sabor Gaúcho" (establishment id: 3)
INSERT INTO services (establishments_id, name, description, creation_date) VALUES
(3, 'Buffet Livre', 'Grande variedade de pratos típicos da culinária gaúcha.', '2024-11-19'),
(3, 'Rodízio de Carnes', 'Carnes nobres servidas à vontade.', '2024-11-19'),
(3, 'Delivery', 'Entregamos pratos deliciosos na sua casa.', '2024-11-19'),
(3, 'Sobremesas Artesanais', 'Sobremesas caseiras e tradicionais.', '2024-11-19'),
(3, 'Almoços Executivos', 'Opções rápidas e saborosas para o dia a dia.', '2024-11-19');

-- Serviços para "TechFix Informática" (establishment id: 4)
INSERT INTO services (establishments_id, name, description, creation_date) VALUES
(4, 'Reparo de Computadores', 'Conserto de desktops e notebooks.', '2024-11-18'),
(4, 'Instalação de Softwares', 'Instalação e configuração de programas.', '2024-11-18'),
(4, 'Manutenção Preventiva', 'Evite problemas futuros com nosso serviço de manutenção.', '2024-11-18'),
(4, 'Suporte Técnico', 'Atendimento remoto e presencial para empresas e residências.', '2024-11-18'),
(4, 'Venda de Peças', 'Componentes de hardware para upgrade e reparos.', '2024-11-18');





INSERT INTO availability (service_id, week_days, start_time) VALUES
(1, 'monday', '08:00:00'),
(1, 'monday', '09:00:00'),
(1, 'monday', '10:00:00'),
(1, 'monday', '11:00:00'),
(1, 'monday', '14:00:00'),
(1, 'monday', '15:00:00'),
(1, 'monday', '16:00:00'),
(1, 'tuesday', '08:00:00'),
(1, 'tuesday', '09:00:00'),
(1, 'tuesday', '10:00:00'),
(1, 'tuesday', '14:00:00'),
(1, 'tuesday', '15:00:00'),
(1, 'wednesday', '08:00:00'),
(1, 'wednesday', '09:00:00'),
(1, 'wednesday', '10:00:00'),
(1, 'wednesday', '14:00:00'),
(1, 'wednesday', '15:00:00'),
(1, 'thursday', '08:00:00'),
(1, 'thursday', '09:00:00'),
(1, 'thursday', '10:00:00'),
(1, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(2, 'monday', '08:00:00'),
(2, 'monday', '09:00:00'),
(2, 'monday', '10:00:00'),
(2, 'monday', '11:00:00'),
(2, 'monday', '14:00:00'),
(2, 'monday', '15:00:00'),
(2, 'monday', '16:00:00'),
(2, 'tuesday', '08:00:00'),
(2, 'tuesday', '09:00:00'),
(2, 'tuesday', '10:00:00'),
(2, 'tuesday', '14:00:00'),
(2, 'tuesday', '15:00:00'),
(2, 'wednesday', '08:00:00'),
(2, 'wednesday', '09:00:00'),
(2, 'wednesday', '10:00:00'),
(2, 'wednesday', '14:00:00'),
(2, 'wednesday', '15:00:00'),
(2, 'thursday', '08:00:00'),
(2, 'thursday', '09:00:00'),
(2, 'thursday', '10:00:00'),
(2, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(3, 'monday', '08:00:00'),
(3, 'monday', '09:00:00'),
(3, 'monday', '10:00:00'),
(3, 'monday', '11:00:00'),
(3, 'monday', '14:00:00'),
(3, 'monday', '15:00:00'),
(3, 'monday', '16:00:00'),
(3, 'tuesday', '08:00:00'),
(3, 'tuesday', '09:00:00'),
(3, 'tuesday', '10:00:00'),
(3, 'tuesday', '14:00:00'),
(3, 'tuesday', '15:00:00'),
(3, 'wednesday', '08:00:00'),
(3, 'wednesday', '09:00:00'),
(3, 'wednesday', '10:00:00'),
(3, 'wednesday', '14:00:00'),
(3, 'wednesday', '15:00:00'),
(3, 'thursday', '08:00:00'),
(3, 'thursday', '09:00:00'),
(3, 'thursday', '10:00:00'),
(3, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(4, 'monday', '08:00:00'),
(4, 'monday', '09:00:00'),
(4, 'monday', '10:00:00'),
(4, 'monday', '11:00:00'),
(4, 'monday', '14:00:00'),
(4, 'monday', '15:00:00'),
(4, 'monday', '16:00:00'),
(4, 'tuesday', '08:00:00'),
(4, 'tuesday', '09:00:00'),
(4, 'tuesday', '10:00:00'),
(4, 'tuesday', '14:00:00'),
(4, 'tuesday', '15:00:00'),
(4, 'wednesday', '08:00:00'),
(4, 'wednesday', '09:00:00'),
(4, 'wednesday', '10:00:00'),
(4, 'wednesday', '14:00:00'),
(4, 'wednesday', '15:00:00'),
(4, 'thursday', '08:00:00'),
(4, 'thursday', '09:00:00'),
(4, 'thursday', '10:00:00'),
(4, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(5, 'monday', '08:00:00'),
(5, 'monday', '09:00:00'),
(5, 'monday', '10:00:00'),
(5, 'monday', '11:00:00'),
(5, 'monday', '14:00:00'),
(5, 'monday', '15:00:00'),
(5, 'monday', '16:00:00'),
(5, 'tuesday', '08:00:00'),
(5, 'tuesday', '09:00:00'),
(5, 'tuesday', '10:00:00'),
(5, 'tuesday', '14:00:00'),
(5, 'tuesday', '15:00:00'),
(5, 'wednesday', '08:00:00'),
(5, 'wednesday', '09:00:00'),
(5, 'wednesday', '10:00:00'),
(5, 'wednesday', '14:00:00'),
(5, 'wednesday', '15:00:00'),
(5, 'thursday', '08:00:00'),
(5, 'thursday', '09:00:00'),
(5, 'thursday', '10:00:00'),
(5, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(6, 'monday', '08:00:00'),
(6, 'monday', '09:00:00'),
(6, 'monday', '10:00:00'),
(6, 'monday', '11:00:00'),
(6, 'monday', '14:00:00'),
(6, 'monday', '15:00:00'),
(6, 'monday', '16:00:00'),
(6, 'tuesday', '08:00:00'),
(6, 'tuesday', '09:00:00'),
(6, 'tuesday', '10:00:00'),
(6, 'tuesday', '14:00:00'),
(6, 'tuesday', '15:00:00'),
(6, 'wednesday', '08:00:00'),
(6, 'wednesday', '09:00:00'),
(6, 'wednesday', '10:00:00'),
(6, 'wednesday', '14:00:00'),
(6, 'wednesday', '15:00:00'),
(6, 'thursday', '08:00:00'),
(6, 'thursday', '09:00:00'),
(6, 'thursday', '10:00:00'),
(6, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(7, 'monday', '08:00:00'),
(7, 'monday', '09:00:00'),
(7, 'monday', '10:00:00'),
(7, 'monday', '11:00:00'),
(7, 'monday', '14:00:00'),
(7, 'monday', '15:00:00'),
(7, 'monday', '16:00:00'),
(7, 'tuesday', '08:00:00'),
(7, 'tuesday', '09:00:00'),
(7, 'tuesday', '10:00:00'),
(7, 'tuesday', '14:00:00'),
(7, 'tuesday', '15:00:00'),
(7, 'wednesday', '08:00:00'),
(7, 'wednesday', '09:00:00'),
(7, 'wednesday', '10:00:00'),
(7, 'wednesday', '14:00:00'),
(7, 'wednesday', '15:00:00'),
(7, 'thursday', '08:00:00'),
(7, 'thursday', '09:00:00'),
(7, 'thursday', '10:00:00'),
(7, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(8, 'monday', '08:00:00'),
(8, 'monday', '09:00:00'),
(8, 'monday', '10:00:00'),
(8, 'monday', '11:00:00'),
(8, 'monday', '14:00:00'),
(8, 'monday', '15:00:00'),
(8, 'monday', '16:00:00'),
(8, 'tuesday', '08:00:00'),
(8, 'tuesday', '09:00:00'),
(8, 'tuesday', '10:00:00'),
(8, 'tuesday', '14:00:00'),
(8, 'tuesday', '15:00:00'),
(8, 'wednesday', '08:00:00'),
(8, 'wednesday', '09:00:00'),
(8, 'wednesday', '10:00:00'),
(8, 'wednesday', '14:00:00'),
(8, 'wednesday', '15:00:00'),
(8, 'thursday', '08:00:00'),
(8, 'thursday', '09:00:00'),
(8, 'thursday', '10:00:00'),
(8, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(9, 'monday', '08:00:00'),
(9, 'monday', '09:00:00'),
(9, 'monday', '10:00:00'),
(9, 'monday', '11:00:00'),
(9, 'monday', '14:00:00'),
(9, 'monday', '15:00:00'),
(9, 'monday', '16:00:00'),
(9, 'tuesday', '08:00:00'),
(9, 'tuesday', '09:00:00'),
(9, 'tuesday', '10:00:00'),
(9, 'tuesday', '14:00:00'),
(9, 'tuesday', '15:00:00'),
(9, 'wednesday', '08:00:00'),
(9, 'wednesday', '09:00:00'),
(9, 'wednesday', '10:00:00'),
(9, 'wednesday', '14:00:00'),
(9, 'wednesday', '15:00:00'),
(9, 'thursday', '08:00:00'),
(9, 'thursday', '09:00:00'),
(9, 'thursday', '10:00:00'),
(9, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(10, 'monday', '08:00:00'),
(10, 'monday', '09:00:00'),
(10, 'monday', '10:00:00'),
(10, 'monday', '11:00:00'),
(10, 'monday', '14:00:00'),
(10, 'monday', '15:00:00'),
(10, 'monday', '16:00:00'),
(10, 'tuesday', '08:00:00'),
(10, 'tuesday', '09:00:00'),
(10, 'tuesday', '10:00:00'),
(10, 'tuesday', '14:00:00'),
(10, 'tuesday', '15:00:00'),
(10, 'wednesday', '08:00:00'),
(10, 'wednesday', '09:00:00'),
(10, 'wednesday', '10:00:00'),
(10, 'wednesday', '14:00:00'),
(10, 'wednesday', '15:00:00'),
(10, 'thursday', '08:00:00'),
(10, 'thursday', '09:00:00'),
(10, 'thursday', '10:00:00'),
(10, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(11, 'monday', '08:00:00'),
(11, 'monday', '09:00:00'),
(11, 'monday', '10:00:00'),
(11, 'monday', '11:00:00'),
(11, 'monday', '14:00:00'),
(11, 'monday', '15:00:00'),
(11, 'monday', '16:00:00'),
(11, 'tuesday', '08:00:00'),
(11, 'tuesday', '09:00:00'),
(11, 'tuesday', '10:00:00'),
(11, 'tuesday', '14:00:00'),
(11, 'tuesday', '15:00:00'),
(11, 'wednesday', '08:00:00'),
(11, 'wednesday', '09:00:00'),
(11, 'wednesday', '10:00:00'),
(11, 'wednesday', '14:00:00'),
(11, 'wednesday', '15:00:00'),
(11, 'thursday', '08:00:00'),
(11, 'thursday', '09:00:00'),
(11, 'thursday', '10:00:00'),
(11, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(12, 'monday', '08:00:00'),
(12, 'monday', '09:00:00'),
(12, 'monday', '10:00:00'),
(12, 'monday', '11:00:00'),
(12, 'monday', '14:00:00'),
(12, 'monday', '15:00:00'),
(12, 'monday', '16:00:00'),
(12, 'tuesday', '08:00:00'),
(12, 'tuesday', '09:00:00'),
(12, 'tuesday', '10:00:00'),
(12, 'tuesday', '14:00:00'),
(12, 'tuesday', '15:00:00'),
(12, 'wednesday', '08:00:00'),
(12, 'wednesday', '09:00:00'),
(12, 'wednesday', '10:00:00'),
(12, 'wednesday', '14:00:00'),
(12, 'wednesday', '15:00:00'),
(12, 'thursday', '08:00:00'),
(12, 'thursday', '09:00:00'),
(12, 'thursday', '10:00:00'),
(12, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(13, 'monday', '08:00:00'),
(13, 'monday', '09:00:00'),
(13, 'monday', '10:00:00'),
(13, 'monday', '11:00:00'),
(13, 'monday', '14:00:00'),
(13, 'monday', '15:00:00'),
(13, 'monday', '16:00:00'),
(13, 'tuesday', '08:00:00'),
(13, 'tuesday', '09:00:00'),
(13, 'tuesday', '10:00:00'),
(13, 'tuesday', '14:00:00'),
(13, 'tuesday', '15:00:00'),
(13, 'wednesday', '08:00:00'),
(13, 'wednesday', '09:00:00'),
(13, 'wednesday', '10:00:00'),
(13, 'wednesday', '14:00:00'),
(13, 'wednesday', '15:00:00'),
(13, 'thursday', '08:00:00'),
(13, 'thursday', '09:00:00'),
(13, 'thursday', '10:00:00'),
(13, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(14, 'monday', '08:00:00'),
(14, 'monday', '09:00:00'),
(14, 'monday', '10:00:00'),
(14, 'monday', '11:00:00'),
(14, 'monday', '14:00:00'),
(14, 'monday', '15:00:00'),
(14, 'monday', '16:00:00'),
(14, 'tuesday', '08:00:00'),
(14, 'tuesday', '09:00:00'),
(14, 'tuesday', '10:00:00'),
(14, 'tuesday', '14:00:00'),
(14, 'tuesday', '15:00:00'),
(14, 'wednesday', '08:00:00'),
(14, 'wednesday', '09:00:00'),
(14, 'wednesday', '10:00:00'),
(14, 'wednesday', '14:00:00'),
(14, 'wednesday', '15:00:00'),
(14, 'thursday', '08:00:00'),
(14, 'thursday', '09:00:00'),
(14, 'thursday', '10:00:00'),
(14, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(15, 'monday', '08:00:00'),
(15, 'monday', '09:00:00'),
(15, 'monday', '10:00:00'),
(15, 'monday', '11:00:00'),
(15, 'monday', '14:00:00'),
(15, 'monday', '15:00:00'),
(15, 'monday', '16:00:00'),
(15, 'tuesday', '08:00:00'),
(15, 'tuesday', '09:00:00'),
(15, 'tuesday', '10:00:00'),
(15, 'tuesday', '14:00:00'),
(15, 'tuesday', '15:00:00'),
(15, 'wednesday', '08:00:00'),
(15, 'wednesday', '09:00:00'),
(15, 'wednesday', '10:00:00'),
(15, 'wednesday', '14:00:00'),
(15, 'wednesday', '15:00:00'),
(15, 'thursday', '08:00:00'),
(15, 'thursday', '09:00:00'),
(15, 'thursday', '10:00:00'),
(15, 'thursday', '14:00:00');

INSERT INTO availability (service_id, week_days, start_time) VALUES
(16, 'monday', '08:00:00'),
(16, 'monday', '09:00:00'),
(16, 'monday', '10:00:00'),
(16, 'monday', '11:00:00'),
(16, 'monday', '14:00:00'),
(16, 'monday', '15:00:00'),
(16, 'monday', '16:00:00'),
(16, 'tuesday', '08:00:00'),
(16, 'tuesday', '09:00:00'),
(16, 'tuesday', '10:00:00'),
(16, 'tuesday', '14:00:00'),
(16, 'tuesday', '15:00:00'),
(16, 'wednesday', '08:00:00'),
(16, 'wednesday', '09:00:00'),
(16, 'wednesday', '10:00:00'),
(16, 'wednesday', '14:00:00'),
(16, 'wednesday', '15:00:00'),
(16, 'thursday', '08:00:00'),
(16, 'thursday', '09:00:00'),
(16, 'thursday', '10:00:00'),
(16, 'thursday', '14:00:00');

