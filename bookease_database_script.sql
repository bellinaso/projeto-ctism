CREATE DATABASE bookease;

USE bookease;

CREATE TABLE users(
	id int auto_increment,
    cpf VARCHAR(14) UNIQUE,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(14) UNIQUE,
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
    email varchar(100) UNIQUE,
    name VARCHAR(200),
    adress VARCHAR(200),
    latitude DOUBLE,
    longitude DOUBLE,
    phone VARCHAR(14) UNIQUE,
    description TEXT,
    creation_date DATE,
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES user(id)
);

CREATE TABLE reserves(
    id INT auto_increment,
    user_id INT,
    establishments_id INT,
    reserve_date DATE,
    service_date DATE,
    reserve_status ENUM('pending', 'confirmed', 'cancelled', 'completed'),
    PRIMARY KEY(id),
    FOREIGN KEY(user_id) REFERENCES user(id),
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
    FOREIGN KEY(reserve_id) REFERENCES reserve(id)
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
    FOREIGN KEY(category_id) REFERENCES category(id)
);