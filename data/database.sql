-- Create database
DROP DATABASE IF EXISTS book_store;
CREATE DATABASE book_store 
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

-- Create user
GRANT ALL PRIVILEGES on book_store.* TO bstore_user@localhost IDENTIFIED BY 'book_store_us3r';

-- Create tables
USE book_store;

CREATE TABLE IF NOT EXISTS `author` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `book` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `author_id` int(11) NOT NULL,
  PRIMARY KEY (`book_id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- Perform inserts
INSERT INTO `author` (`author_id`, `name`) VALUES
(1, 'W. Jason Gilmore'),
(2, 'Luke Welling'),
(3, 'Rasmus Lerdorf'),
(4, 'Dagfinn Reiersol'),
(5, 'George Schlossnagle');

INSERT INTO `book` (`book_id`, `title`, `author_id`) VALUES
(1, 'Beginning PHP and MySQL: From Novice to Professional', 1),
(2, 'PHP and MySQL Web Development (4th Edition)', 2),
(3, 'Programming PHP', 3),
(4, 'PHP in Action: Objects, Design, Agility', 4),
(5, 'Advanced PHP Programming', 5);