CREATE DATABASE product_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE product (
 id INT NOT NULL AUTO_INCREMENT,
 name VARCHAR(128) NOT NULL,
 description TEXT,
 PRIMARY KEY (id)
); 

CREATE USER 'product_db_user'@'%' IDENTIFIED BY 'secret';

GRANT ALL PRIVILEGES ON product_db.* TO 'product_db_user'@'%';

INSERT INTO product (name, description)
VALUES ('Product 1 name', 'Product 1 description'),
       ('Product 2 name', 'Product 2 description'),
       ('Product 3 name', ''),
       ('Product 4 name', 'Product 4 <b>description</b>');