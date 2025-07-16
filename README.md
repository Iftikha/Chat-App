# 💬 PHP Chat App

A simple real-time-like chat application built with **PHP, MySQL, HTML, CSS, and AJAX** (no frameworks).

---

## ✅ Requirements

- [XAMPP](https://www.apachefriends.org/index.html) (Recommended)
- Make sure **Apache (PHP)** and **MySQL** are installed and **running**
- Basic knowledge of how to use **phpMyAdmin**

---

## 📦 Installation Guide

### 1. Setup the App Directory

- Download or clone this repository.
- Move the entire project folder to:

```plaintext
C:/xampp/htdocs/
```
### 2. Create config Folder
Inside the main project directory, create a new folder named:

```plaintext
config
```
Now inside the config folder:

``📁 connectDB.php``
Create a function named connectDB()

This function should return a MySQLi connection object
``📁 checkpass.php``
Create a function named checkpass($password)

This function should return password strength (like true/false or 1/0)

### 3. Create MySQL Database
Open phpMyAdmin:

Create a new database:

```sql
Database Name: chat-app
```
Now create the following tables:

### 🧑 users Table
```sql
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(255) NOT NULL
);
```
### 💬 messages Table
```sql
CREATE TABLE `messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `sender` VARCHAR(100) NOT NULL,
  `reciever` VARCHAR(100) NOT NULL,
  `msg` TEXT NOT NULL
);
```
### 🚀 Running the App
Start Apache and MySQL from XAMPP Control Panel

Go to your browser and open:

```bash
http://localhost/Chat-App/
```
Sign up, log in, and start chatting!

### ⚠️ Notes
Passwords should ideally be hashed using password_hash()

connectDB.php and checkpass.php are essential for secure connection and password checking

Use sessions or cookies to manage user state

Chat data is stored in MySQL, fetched via PHP + AJAX

📁 File Structure Overview (Partial)
```plaintext
/Chat-App
│
├── config/
│   ├── connectDB.php
│   └── checkpass.php
│
├── assets/
│   ├── css/
│   └── js/
│
├── signup.php
├── login.php
├── index.php
├── chat.php
└── README.md
```
# 🛡️ License
MIT / GNU General Public License v3 (as per your choice)