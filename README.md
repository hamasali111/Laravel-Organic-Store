# 🌿 Organic Store

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=flat-square&logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/Database-SQLite%2FMySQL-003B57?style=flat-square&logo=sqlite&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/CSS-Tailwind-38BDF8?style=flat-square&logo=tailwindcss&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-22c55e?style=flat-square)
![Status](https://img.shields.io/badge/Status-Active-22c55e?style=flat-square)

A full-featured e-commerce web application built with **Laravel 11**, designed for selling organic products online. It includes a customer-facing storefront, a complete admin panel, order management with real-time status tracking, payment proof uploads, and email notifications.

---

## ✨ Features

### Customer Facing
- Product catalog with categories, search, and filters
- Shopping cart (session-based, no login required to browse)
- Coupon / discount code system
- Checkout with multiple payment options:
  - **Cash on Delivery (COD)**
  - **Bank Transfer**
  - **JazzCash**
  - **EasyPaisa**
- Payment proof image upload for online transfers
- Order confirmation email on placement
- Order status update emails (confirmed → processing → shipped → delivered)
- Order history and detailed order tracking page
- Two-way messaging between customer and admin per order
- Return / refund request system
- Downloadable PDF invoice per order
- Product reviews and ratings
- Wishlist

### Admin Panel (`/admin`)
- Dashboard with sales overview and key metrics
- Order management: view, update status, add tracking number
- Payment proof review and verification per order
- Two-way customer messaging per order
- Product and category management (CRUD)
- Coupon management
- Return request management
- Sales reports

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 11 |
| Language | PHP 8.2+ |
| Database | SQLite (dev) / MySQL (production) |
| Frontend | Blade templates, vanilla CSS/JS |
| File Storage | Laravel Storage (public disk) |
| Email | Laravel Mail (SMTP / Mailtrap) |
| Auth | Laravel Breeze |

---

## 🚀 Installation & Setup

### Requirements
- PHP 8.2+
- Composer
- Node.js 18+ & npm
- Git

### 1. Clone the repository

```bash
git clone https://github.com/your-username/organic-store.git
cd organic-store
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies and build assets

```bash
npm install
npm run build
```

### 4. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and configure:

```env
APP_URL=http://localhost

# Database (SQLite for local; mysql for production)
DB_CONNECTION=sqlite

# Mail — see Mail Configuration section below
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS="noreply@organicstore.com"
MAIL_FROM_NAME="Organic Store"
```

### 5. Run database migrations

```bash
php artisan migrate --seed
```

### 6. Create the public storage symlink

> **Required** for payment proof images and product images to be publicly accessible.

```bash
php artisan storage:link
```

### 7. Start the development server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 📧 Mail Configuration

Emails are sent for:
- **Order confirmation** — immediately after a customer places an order
- **Order status updates** — each time the admin changes the order status

| Environment | Recommended Setup |
|---|---|
| Local / Dev | [Mailtrap.io](https://mailtrap.io) — free sandbox that catches all emails |
| Production | SendGrid, Mailgun, AWS SES, or your host's SMTP |

**Setting up Mailtrap (local testing):**
1. Sign up at [mailtrap.io](https://mailtrap.io) (free)
2. Go to **Email Testing → Inboxes → SMTP Settings**
3. Copy the credentials into your `.env` file

---

## 👤 Default Admin Account

After running `php artisan migrate --seed`, an admin account is created:

| Field | Value |
|---|---|
| Email | `admin@organicstore.com` |
| Password | `password` |

> ⚠️ **Change this password immediately** before deploying to production.

The admin panel is accessible at `/admin`.

---

## 💳 Payment Methods

| Method | Proof Required | Customer Status Label |
|---|---|---|
| Cash on Delivery | No | Pay on Delivery |
| Bank Transfer | Yes | Awaiting Verification |
| JazzCash | Yes | Awaiting Verification |
| EasyPaisa | Yes | Awaiting Verification |

Admins can update payment status to **Verified** or **Rejected** from the order detail page once proof is reviewed.

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                    # Admin panel controllers
│   │   ├── Auth/                     # Authentication (Breeze)
│   │   ├── CheckoutController.php    # Order placement & payment proof upload
│   │   ├── OrderHistoryController.php
│   │   ├── OrderNoteController.php   # Customer ↔ Admin messaging
│   │   └── ...
├── Mail/
│   ├── OrderConfirmationMail.php     # Sent on order placement
│   └── OrderStatusMail.php           # Sent on status change
├── Models/
│   ├── Order.php                     # Order model with status/payment label helpers
│   ├── OrderNote.php                 # Per-order messages
│   ├── OrderItem.php
│   └── ...
resources/
├── views/
│   ├── admin/orders/                 # Admin order detail & listing
│   ├── emails/                       # HTML email templates
│   ├── orders/                       # Customer order history & detail
│   └── checkout/                     # Checkout flow & success page
routes/
└── web.php                           # All application routes
storage/
└── app/public/payment_proofs/        # Uploaded payment screenshots
```

---

## 🐛 Bugs Fixed (v1.1.0)

| # | Bug | Fix Applied |
|---|---|---|
| 1 | Order confirmation & status emails not delivered | Removed duplicate `to:` from `Envelope` in both Mailable classes; errors now logged instead of silently discarded |
| 2 | COD orders showed "Awaiting Verification" status | `paymentStatusLabel()` in `Order` model now returns "Pay on Delivery" for Cash on Delivery orders |
| 3 | Messages invisible on both admin and customer side | Renamed the `notes()` Eloquent relationship to `orderNotes()` to match the variable names used in both views |
| 4 | Payment proof image not visible in admin panel | Switched to `asset()` helper for consistent URL resolution |
| 5 | Email driver set to `log` (emails never actually sent) | Updated `.env` with correct SMTP settings; documented Mailtrap for local testing |

---

## 🚢 Deployment Guide

### Deploy to Shared Hosting (cPanel / Hostinger)

1. Upload all project files to your server (skip `/vendor` and `/node_modules`)
2. SSH into your server and run:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
3. Update your `.env` with production values (see below)
4. Run:
   ```bash
   php artisan migrate --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
5. Point your domain's document root to the `/public` folder

### Deploy to VPS (Ubuntu + Nginx)

```bash
# Clone on server
git clone https://github.com/your-username/organic-store.git /var/www/organic-store
cd /var/www/organic-store

# Install dependencies
composer install --no-dev --optimize-autoloader

# Configure environment
cp .env.example .env
# Edit .env with your production values
php artisan key:generate

# Run setup
php artisan migrate --force
php artisan storage:link
php artisan optimize

# Set permissions
chown -R www-data:www-data storage bootstrap/cache
```

Point Nginx document root to `/var/www/organic-store/public`.

### Production `.env` values

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
```

---

## ✅ Production Deployment Checklist

- [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
- [ ] Configure real SMTP credentials in `.env`
- [ ] Switch `DB_CONNECTION` to `mysql` and set credentials
- [ ] Run `php artisan migrate --force`
- [ ] Run `php artisan storage:link`
- [ ] Run `php artisan optimize`
- [ ] Change the default admin password
- [ ] Enable HTTPS on your domain

---

## 🔒 Security Notes

- **Never commit your `.env` file** — it is listed in `.gitignore` by default
- Set `APP_DEBUG=false` in production to hide error details
- Always use HTTPS in production
- Change default admin credentials before going live

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
