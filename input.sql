drop database if exists book;
create database book;
use book;

-- --------------------------------------------------------
-- --------- this is a book_room database------------------
-- --------------------------------------------------------

-- ---------------------------------------------------------
-- --------- Book table ------------------------------------
-- ---------------------------------------------------------

CREATE TABLE IF NOT EXISTS t_book (
	id int(64) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	category VARCHAR(128) NOT NULL,
	page int(64) NOT NULL,
	content VARCHAR(64) NOT NULL
)default charset=utf8mb4;

CREATE TABLE IF NOT EXISTS t_user(
	id int(64) PRIMARY KEY NOT NULL AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	pwd VARCHAR(128) NOT NULL,
	tel VARCHAR(128) NOT NULL,
	addr VARCHAR(128) NOT NULL,
	cert VARCHAR(128) NOT NULL
)default charset=utf8mb4;

insert into t_user(name,pwd,tel,addr,cert)values
('jd',sha1(123),'tel','addr','cert')
