<h1 align="center">📰 News Project — City News (Laravel 12)</h1>

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <b>City News — A Laravel 12-powered dynamic news CMS with admin panel, user roles, and full CRUD for articles.</b>
</p>

---

## 🧾 Project Overview

This is a modern news platform called **City News**, built using **Laravel 12**. It includes a fully functional admin panel where users can:

- Manage news posts
- Categorize articles
- Handle user roles and permissions
- View, search, and filter dynamic news on the frontend

---

## 🧠 Tech Stack

- 🧰 **Laravel 12**
- 🐘 **PHP 8.x**
- 🎨 **HTML5**, **CSS3**, **Bootstrap**
- 💡 **JavaScript**, **jQuery**, **AJAX**
- 🗃️ **MySQL**

---

## ✨ Key Features

- 🔒 **User Authentication & Role Management**
- 📝 **News Post CRUD** (Create, Edit, Delete)
- 🗂️ **Category Management**
- 🔍 **News Search & Filter**
- 🧑‍💼 **Admin & Author Roles**
- ⚡ **AJAX-based Interactions**
- 📱 **Responsive UI with Bootstrap**

---

## 📸 Screenshot

> Actual interface from City News homepage:

<p align="center">
  <img src="/public/image/Screenshot.png" width="600" alt="City News Screenshot">
</p>

---

## 📁 Project Structure

```bash
├── app/
│   ├── Http/Controllers/         # News, Category, User controllers
│   ├── Models/                   # News, Category, User models
│   ├── Observers/                # Laravel Observers (optional)
├── resources/views/              # Blade templates (admin + public)
├── public/                       # Public assets and images
├── routes/web.php                # Web routes
├── database/migrations/          # Schema setup
└── .env                          # Environment variables
