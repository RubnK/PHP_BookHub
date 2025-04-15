# BookHub - A Collaborative Book Library

**Authors :** [@RubnK](https://github.com/RubnK), [@yayou05](https://github.com/yayou05) & [@len233](https://github.com/len233)

**BookHub** is a collaborative book tracking web application built with **PHP**, **PostgreSQL**, and **Vanilla JS**. It allows users to manage their personal library, post reviews, search for books, and explore the most loved titles in the community.

## Table of Contents
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Project Structure](#project-structure)
- [Functional Overview](#functional-overview)
- [PostgreSQL Setup](#postgresql-setup)
- [Installation & Execution](#installation--execution)
- [License](#license)

---

## Features

- 📚 **Book Management**: Add, edit, delete books with cover images and metadata.
- 🔍 **Search System**: Search by title, author, or genre.
- ⭐ **Reviews**: Leave a rating and a comment on any book.
- ✅ **Authentication**: Register, login, logout and manage your profile.
- 🎒 **User Library**: Add or remove books from your personal collection.
- 🎲 **Random Book Feature**: Homepage showcases a random featured book.
- 🔝 **Top Rated Books**: Homepage highlights the best rated books in the community.
- 🔐 **Route Protection**: Restricted pages for authenticated users only.
- 🎨 **Custom Styles**: Clean and responsive UI.

---

## Technologies Used

- **PHP 8+**
- **PostgreSQL**
- **Vanilla JavaScript**
- **Composer**
- **HTML5 & CSS3**
- **Dotenv** (env management)

---

## Project Structure
```
/app
│── Controllers/                 # MVC Controllers
│── Models/                     # Database access logic
│── Views/                      # All HTML views (organized by page)
│── Core/                       # Custom router & database connection

/public
│── uploads/                    # Uploaded book cover images
│── assets/                     # CSS and JS files
│── index.php                   # Main entry point

/.env                            # Environment variables (DB credentials)
/composer.json                   # PHP dependencies
```

---

## Functional Overview

| Method       | Route                        | Description                            |
|--------------|------------------------------|----------------------------------------|
| **GET**      | `/`                          | Homepage with featured + top books     |
| **GET**      | `/books`                     | List all books                         |
| **GET**      | `/books/add`                 | Add a new book (form)                  |
| **POST**     | `/books/add`                 | Submit a new book                      |
| **GET**      | `/books/:id`                 | Show a specific book                   |
| **POST**     | `/books/:id`                 | Post a review                          |
| **POST**     | `/books/:id/add`             | Add book to user’s collection          |
| **POST**     | `/books/:id/remove`          | Remove book from user’s collection     |
| **GET**      | `/mes-livres`                | Show user's owned books                |
| **POST**     | `/reviews/delete/:id`        | Delete one of your reviews             |
| **GET**      | `/login`, `/register`        | Auth routes                            |
| **POST**     | `/login`, `/register`        | Auth submissions                       |
| **GET**      | `/profil`                    | Show and update profile                |
| **POST**     | `/profil`                    | Update profile info                    |
| **POST**     | `/password`                  | Update password                        |

---

## PostgreSQL Setup

1. **Create the bookhub database:**

```sql
CREATE DATABASE bookhub;
```

2. **Execute the schema:**

```sql
-- Table creation
-- Users, Authors, Genres, Books, Reviews, User_Books
```

You’ll find the full schema in the `database.sql` file.

---

## Installation & Execution

### 1. Clone the repository

```bash
git clone https://github.com/RubnK/PHP_BookHub.git
cd BookHub
```

### 2. Install PHP dependencies via Composer

```bash
composer install
```

### 3. Configure environment variables

Create a `.env` file at the root and set:

```
DB_HOST=localhost
DB_PORT=5432
DB_NAME=bookhub
DB_USER=your_user
DB_PASSWORD=your_password
```

### 4. Start the PHP server

Since it's a pure PHP project:

```bash
php -S localhost:8000 -t public
```

Open [http://localhost:8000](http://localhost:8000) in your browser.

---

## License

This project is licensed under the [MIT License](LICENSE)
