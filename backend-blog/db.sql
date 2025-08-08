DROP DATABASE IF EXISTS blog_db;
CREATE DATABASE blog_db;
USE blog_db;

-- Users table
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100)
);

-- Posts table
CREATE TABLE posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  content TEXT,
  user_id INT,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Comments table

ALTER TABLE posts ENGINE=InnoDB;


CREATE TABLE comments (

  id INT AUTO_INCREMENT PRIMARY KEY,
  content TEXT,
  post_id INT,
  user_id INT,
  FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;
ALTER TABLE comments ENGINE=InnoDB;

-- Dummy data
INSERT INTO users (name, email) VALUES
('Alice', 'alice@example.com'),
('Bob', 'bob@example.com');

INSERT INTO posts (title, content, user_id) VALUES
('First Post', 'This is the first post.', 1),
('Second Post', 'This is another post.', 2);

INSERT INTO comments (content, post_id, user_id) VALUES
('Great post!', 1, 2),
('Thanks for sharing.', 1, 1),
('Interesting read.', 2, 1);

USE blog_db;
DELETE FROM comments WHERE post_id = 2;