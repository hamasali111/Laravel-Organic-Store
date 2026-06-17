
#  Organic Store

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=flat-square&logo=php&logoColor=white)
![Database](https://img.shields.io/badge/Database-MySQL%2FSQLite-003B57?style=flat-square&logo=mysql&logoColor=white)
![Frontend](https://img.shields.io/badge/UI-Tailwind%20CSS-38BDF8?style=flat-square&logo=tailwindcss&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-22c55e?style=flat-square)
![Status](https://img.shields.io/badge/Status-Production%20Ready-22c55e?style=flat-square)

A **full-featured Laravel 13 E-Commerce Platform** for organic products, featuring a modern storefront, secure checkout system, admin dashboard, order tracking, and email notifications.

---

## 🚀 Key Features

### 🛍️ Customer Side
- Product catalog with categories, search & filters
- Shopping cart (session-based)
- Coupon & discount system
- Secure checkout system
- Multiple payment methods:
  - Cash on Delivery (COD)
  - Bank Transfer
  - JazzCash
  - EasyPaisa
- Payment proof upload system
- Order tracking & history
- Email notifications (order confirmation & updates)
- Wishlist & product reviews
- Two-way messaging with admin per order
- PDF invoice download
- Return & refund requests

### 🧑‍💼 Admin Panel
- Dashboard with analytics
- Product & category management (CRUD)
- Order management & status updates
- Payment verification system
- Customer messaging system
- Coupon management
- Sales reports
- Return request handling

---

## 🖼️ Screenshots

> 📌 Add your actual images inside `/screenshots` folder in your project.

### 🏠 Home Page
![Home Page](screenshots/home.png)

### 🛒 Product Listing
![Products](screenshots/products.png)

### 📦 Cart Page
![Cart](screenshots/cart.png)

### 💳 Checkout Page
![Checkout](screenshots/checkout.png)

### 🧑‍💼 Admin Dashboard
![Admin Dashboard](screenshots/admin-dashboard.png)

### 📊 Order Management
![Orders](screenshots/orders.png)

---

## 🛠️ Tech Stack

| Layer        | Technology |
|-------------|-----------|
| Backend      | Laravel 13 |
| Language     | PHP 8.4+ |
| Database     | MySQL / SQLite |
| Frontend     | Blade + Tailwind CSS |
| Auth         | Laravel Breeze |
| Email        | SMTP (Mailtrap / Production SMTP) |
| Storage      | Laravel Storage |

---

## ⚙️ Installation Guide

### 1️⃣ Clone Repository
```bash
git clone https://github.com/your-username/organic-store.git
cd organic-store
````

### 2️⃣ Install Dependencies

```bash
composer install
npm install
npm run build
```

### 3️⃣ Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4️⃣ Configure Database

Update `.env`:

```env
DB_CONNECTION=mysql
DB_DATABASE=organic_store
DB_USERNAME=root
DB_PASSWORD=
```

### 5️⃣ Run Migrations

```bash
php artisan migrate --seed
```

### 6️⃣ Create Storage Link

```bash
php artisan storage:link
```

### 7️⃣ Start Server

```bash
php artisan serve
```

Visit:

```
http://localhost:8000
```

---

## 📂 Project Structure

```
app/
├── Http/Controllers
├── Models
├── Mail
resources/
├── views (frontend + admin)
routes/
storage/
public/
```

---

## 📧 Email System

* Order confirmation email
* Order status update email
* Admin notifications

Recommended:

* Mailtrap (development)
* SMTP (production)

---

## 👤 Default Admin

| Email                                                   | Password |
| ------------------------------------------------------- | -------- |
| [admin@organicstore.com](mailto:admin@organicstore.com) | password |

⚠️ Change credentials after setup.

---

## 🚀 Deployment

### Production Checklist

* Set `APP_ENV=production`
* Set `APP_DEBUG=false`
* Configure real SMTP
* Switch DB to MySQL
* Run:

```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
```

---

## 🔒 Security Notes

* Never upload `.env`
* Use HTTPS in production
* Secure admin routes
* Keep credentials private

---

## 📄 License

This project is licensed under the **MIT License*
