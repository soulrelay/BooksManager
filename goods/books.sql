DROP TABLE IF EXISTS books;
CREATE TABLE books (
	id INT NOT NULL AUTO_INCREMENT,
	bookname VARCHAR(80) NOT NULL DEFAULT '', 
	publisher VARCHAR(60) NOT NULL DEFAULT '',
	author VARCHAR(20) NOT NULL DEFAULT '',
	price DOUBLE(5,2) NOT NULL DEFAULT 0.00,
	ptime INT NOT NULL DEFAULT 0,
	pic CHAR(24) NOT NULL DEFAULT '',
	detail TEXT,
	PRIMARY KEY(id),
	INDEX books_bookname(bookname),
	INDEX books_publisher(publisher),
	INDEX books_price(price)
);