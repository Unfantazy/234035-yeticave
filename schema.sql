CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reg_date DATETIME,
  email CHAR(128),
  name CHAR(64),
  password CHAR(64),
  avatar TEXT,
  contact CHAR(128),
  lot_id INT,
  bet_id INT
);

CREATE TABLE category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(64)
);

CREATE TABLE bet (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date DATETIME,
  amount INT,
  user_id INT,
  lot_id INT
);

CREATE TABLE lot (
  id INT AUTO_INCREMENT PRIMARY KEY,
  creation_date DATETIME,
  name CHAR,
  description CHAR,
  image TEXT,
  initial_price INT,
  completion_date DATETIME,
  step_lot INT,
  category_id INT,
  author_id INT,
  winner_id INT
);

CREATE INDEX lot ON lot(category_id);

CREATE UNIQUE INDEX name ON lot(name);
CREATE UNIQUE INDEX email ON user(email);
