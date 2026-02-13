<p align="center">
<strong>Noxia – Laravel E-Commerce Management System</strong>
</p>

---

# 🛒 About Noxia

Noxia is a web-based e-commerce management platform built with **Laravel 11** and **PHP 8.2**.

The system provides a complete structure for managing:

- 🛍️ Products & Categories  
- 🛒 Shopping Cart & Checkout  
- 📦 Orders  
- 👥 Users & Roles  
- 🧑‍💼 Admin Dashboard  
- 🔐 Authentication & Authorization  

Noxia is designed with clean architecture principles and scalable structure, making it suitable for academic, portfolio, or production-level development.

---

# ⚙️ Installation Guide

## 📌 Prerequisites

Make sure you have:

- PHP 8.2+
- Composer
- MySQL
- Node.js & NPM
- Git
- XAMPP / Local server

---

## ⚙️ Installation

1. **👤 User Configuration (for new developers)**
Before making commits, set your Git username and email so commits are correctly attributed:
```bash
git config --global user.name "Your Name"
git config --global user.email "youremail@example.com"
```

2. Clone the repository  
```bash
git clone https://github.com/your-username/ghorfa.git
```

3. Change directory to access the root folder of the project:
```bash
cd Ghorfa-Project
```

4. copy .env.example to .env and update mysql details
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Ghorfa-Project-DB
DB_USERNAME=root
DB_PASSWORD=
```

5. Run composer install:
```bash
composer install
```

6. Generate application key:
```bash
php artisan key:generate
```

7. Run the migrations inside the container, and then clear the cache:
```bash
php artisan migrate
php artisan cache:clear
```

8. Run seeders in this order:
```bash
php artisan db:seed
```

