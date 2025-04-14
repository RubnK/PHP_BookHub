-- Créer une base de données nomée "bookhub"

-- Table des utilisateurs
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Table des auteurs
CREATE TABLE authors (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    bio TEXT,
    birth_date DATE,
    death_date DATE
);

-- Table des genres
CREATE TABLE genres (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Table des livres
CREATE TABLE books (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    publication_date DATE,
    author_id INT REFERENCES authors(id),
    genre_id INT REFERENCES genres(id),
    cover_image VARCHAR(255)
);

-- Table des critiques
CREATE TABLE reviews (
    id SERIAL PRIMARY KEY,
    book_id INT REFERENCES books(id),
    user_id INT REFERENCES users(id),
    rating INT CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des livres possédés
CREATE TABLE user_books (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id),
    book_id INT REFERENCES books(id),
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);