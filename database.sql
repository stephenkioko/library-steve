users Table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100),
    email VARCHAR(255),
    password_hash TEXT
);


books Table

CREATE TABLE books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    author VARCHAR(255),
    genre VARCHAR(100),
    image TEXT,
    book_status VARCHAR(50), -- e.g., 'available', 'unavailable'
    borrowed_status BOOLEAN -- 0 = not borrowed, 1 = borrowed
);

borrowed_books Table

CREATE TABLE borrowed_books (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255),
    author VARCHAR(255),
    borrowed_date DATE,
    return_date DATE,
    status VARCHAR(50), -- e.g., 'returned', 'borrowed'
    user_id INT,
    book_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

browsing_history Table

CREATE TABLE borrowing_history (
    history_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    book_id INT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    action_type VARCHAR(50), -- e.g., 'borrowed', 'returned', 'reserved'
    borrowed_date DATE,
    return_date DATE,
    borrowed_status BOOLEAN,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);
 
 reservations Table

 CREATE TABLE reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    book_id INT,
    reserved_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50), -- e.g., 'active', 'cancelled', 'fulfilled'
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);
