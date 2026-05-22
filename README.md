<div align="center">

# 🛍️ Nexus Shop
### Full-Stack E-Commerce Platform

*Built with Laravel 13 · PHP 8.5 · MySQL · Tailwind CSS*

---

![Laravel](https://img.shields.io/badge/Laravel-13-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

</div>

---

## 📌 About

**Nexus Shop** is a fully functional e-commerce web application developed as an end-of-semester project for the Advanced Web Programming course. It features a modern storefront for customers and a dedicated admin panel for store management — all built from scratch using the Laravel framework.

---

## ✨ Features

### 🛒 Storefront
- Modern homepage with hero section, featured products, and category grid
- Product catalog with category filter, price range filter, and search
- Product detail page with image gallery, quantity selector, and related products
- Shopping cart (supports both guest and authenticated users)
- Full checkout flow with shipping form and simulated payment
- Order confirmation page

### 🔧 Admin Panel
- Dashboard with revenue chart (last 7 days), order statistics, and low stock alerts
- Full CRUD for products — with image upload, featured toggle, and active/inactive status
- Category management with parent/child support
- Order management with status updates (Pending → Processing → Shipped → Delivered)
- Role-based access control — admin routes are protected by `AdminMiddleware`

### 🔐 Authentication
- Customer registration and login
- Customers can register freely with their own email at `/auth/register`
- Role-based redirection on login (admin → panel, customer → shop)

---

## 🗄️ Database Structure

| Table | Purpose |
|-------|---------|
| `users` | All accounts with `role` column (admin / customer) |
| `categories` | Product categories with self-referential parent support |
| `products` | Full product catalog with pricing, stock, and metadata |
| `carts` | Guest (session-based) and authenticated user carts |
| `cart_items` | Individual items inside each cart |
| `orders` | Customer orders with full shipping address snapshot |
| `order_items` | Permanent product snapshot per order line |

---

## 🚀 Installation

### Requirements
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js (optional, for compiling assets)

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/ravzacitil/LaravelProject.git
cd LaravelProject

# 2. Install PHP dependencies
composer install

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_DATABASE=nexus_shop
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations and seed demo data
php artisan migrate --seed

# 6. Create storage symlink
php artisan storage:link

# 7. Start development server
php artisan serve
```

Visit **http://localhost:8000**

---

## 🔑 Demo Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@nexusshop.com | password |
| Customer | customer@nexusshop.com | password |

> Alternatively, register a new customer account at `/auth/register` — no approval required.

---

## 🗂️ Key URLs

| URL | Description | Access |
|-----|-------------|--------|
| `/` | Shop homepage | Public |
| `/shop/catalog` | Product catalog with filters | Public |
| `/shop/product/{slug}` | Product detail page | Public |
| `/cart` | Shopping cart | Public |
| `/checkout` | Checkout form | Authenticated |
| `/auth/login` | Login page | Guests only |
| `/auth/register` | Registration page | Guests only |
| `/admin/dashboard` | Admin dashboard | Admin only |
| `/admin/products` | Product management | Admin only |
| `/admin/categories` | Category management | Admin only |
| `/admin/orders` | Order management | Admin only |

---

## 🛠️ Tech Stack

| Technology | Purpose |
|------------|---------|
| Laravel 13 | Backend framework — routing, controllers, models, middleware |
| PHP 8.5 | Server-side language |
| MySQL 8 | Relational database |
| Eloquent ORM | Database queries and relationships |
| Blade Templates | Server-side HTML rendering |
| Tailwind CSS | Utility-first responsive styling |
| Alpine.js | Lightweight frontend interactions |
| Google Fonts | Fraunces (display) + DM Sans (body) |

---

## 📁 Project Structure

```
nexus-shop/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Dashboard, Products, Categories, Orders
│   │   │   ├── Auth/           # Login, Register, Logout
│   │   │   └── Shop/           # Home, Products, Cart, Checkout
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/                 # User, Product, Category, Cart, Order...
├── database/
│   ├── migrations/             # 7 migration files
│   └── seeders/                # Users, Categories, Products
├── resources/views/
│   ├── layouts/                # app.blade.php, admin.blade.php
│   ├── admin/                  # Dashboard, products, categories, orders
│   ├── shop/                   # Home, catalog, product, cart, checkout
│   ├── auth/                   # Login, register
│   └── components/             # product-card.blade.php
└── routes/
    └── web.php
```

---

Submission Details

**Ravza Çitil** — Student ID: 20222022441  
Advanced Web Programming — End of Semester Project  
Submitted to: **Dr. Yüksel Çelik**

---

<div align="center">
  <sub>© 2026 Nexus Shop · Built with Laravel 13</sub>
</div>
