# Upsilon Ecommerce

A modern, full-featured e-commerce platform built with Laravel 11. Designed for fashion/retail businesses with comprehensive admin management, multiple payment options, and modern frontend stack.

## Features

### Customer-Facing
- **Homepage** – Hero slider, flash sales, new arrivals, bundles, discover style section, Instagram feed
- **Shop** – Category filtering, search suggestions, product listing with pagination
- **Product Details** – Images, variants (size/color), reviews, related products, share functionality
- **Shopping Cart** – Add/update/remove items, quantity management, guest cart merge on login
- **Wishlist** – Save favorites, move to cart, authenticated persistence
- **Checkout** – Multi-step flow, address management, voucher support, multiple payment methods
- **Payments** – Midtrans (Indonesian payment gateway), WhatsApp direct order
- **User Account** – Profile, order history, address book, password management, order tracking
- **Authentication** – Email/password, Google OAuth, password reset, email verification
- **Contact & Newsletter** – Contact form, newsletter subscription
- **Store Locator** – Physical store locations
- **Static Pages** – About, How to Order, Download App

### Admin Panel
- **Dashboard** – Sales overview, recent orders, statistics
- **Product Management** – CRUD, images (drag-drop, primary), variants (size/color), bulk actions
- **Category Management** – Hierarchical categories, slugs, SEO fields
- **Order Management** – View, status updates, tracking numbers, payment status
- **Customer Management** – View, edit customer details
- **Voucher System** – Create/edit coupons, usage limits, date ranges
- **Reviews** – Moderate, reply, delete
- **Bundles** – Product bundles with discount pricing
- **Announcements** – Site-wide banners with scheduling
- **Sliders** – Homepage carousel management
- **Labels** – Product badges (New, Sale, Bestseller, etc.)
- **Promo Banners** – Marketing banners with positioning
- **Flash Sales** – Time-limited promotions with countdown
- **Size Guides** – Category-specific sizing charts
- **Settings** – Site configuration (WhatsApp, Instagram, SEO, etc.)

## Tech Stack

| Layer | Technology |
|-------|------------|
| **Backend** | Laravel 11, PHP 8.3+ |
| **Database** | SQLite (default), MySQL/PostgreSQL supported |
| **Frontend** | Blade templates, Tailwind CSS 4, Alpine.js, Vite |
| **Images** | Intervention Image, WebP conversion (buglinjo/laravel-webp) |
| **Payments** | Midtrans PHP SDK |
| **Auth** | Laravel Socialite (Google OAuth) |
| **Testing** | PHPUnit, Laravel Boost (AI-assisted development) |
| **Code Style** | Laravel Pint |

## Requirements

- PHP 8.3+
- Composer 2+
- Node.js 18+ & npm
- SQLite (default) or MySQL/PostgreSQL

## Installation

### 1. Clone & Install Dependencies

```bash
git clone <repository-url>
cd upsilon-ecommerce

# Install PHP dependencies
composer install

# Install JS dependencies
npm install
```

### 2. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Configure `.env`

Edit `.env` with your settings:

```env
# App
APP_NAME="Upsilon Ecommerce"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (SQLite default - no config needed)
# For MySQL/PostgreSQL:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=upsilon_ecommerce
DB_USERNAME=your_user
DB_PASSWORD=your_password

# Session & Cache (database by default)
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail (log driver for local dev)
MAIL_MAILER=log

# WhatsApp Integration
WHATSAPP_NUMBER=6281234567890
WHATSAPP_DEFAULT_MESSAGE="Halo, saya tertarik dengan produk Anda."

# Instagram Feed (optional)
INSTAGRAM_ACCESS_TOKEN=
INSTAGRAM_ACCOUNT_ID=
INSTAGRAM_USERNAME=

# Google OAuth (optional)
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

# Midtrans Payment (optional - for production)
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### 4. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed database (categories, products, settings, etc.)
php artisan db:seed
```

### 5. Build Assets

```bash
# Development (with hot reload)
npm run dev

# Production build
npm run build
```

### 6. Start Development Server

```bash
# Option 1: All-in-one (Laravel + Vite)
composer run dev

# Option 2: Separate terminals
# Terminal 1:
php artisan serve
# Terminal 2:
npm run dev
```

Visit `http://localhost:8000`

## Quick Setup (One Command)

```bash
composer run setup
```

This runs: `composer install` → `.env` copy → `key:generate` → `migrate` → `npm install` → `npm run build`

## Admin Access

After seeding, login at `/login` with:
- **Email:** `admin@upsilon.com`
- **Password:** `password`

Or create a user and assign admin role in database:
```sql
UPDATE users SET is_admin = 1 WHERE email = 'your@email.com';
```

## Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # Admin panel controllers
│   ├── Auth/           # Authentication controllers
│   ├── AccountController.php
│   ├── CartController.php
│   ├── CheckoutController.php
│   ├── HomepageController.php
│   ├── ProductController.php
│   └── ShopController.php
├── Models/             # Eloquent models
├── Policies/           # Authorization policies
└── Providers/          # Service providers

database/
├── migrations/         # Schema migrations
├── seeders/            # Data seeders
└── factories/          # Model factories

resources/views/
├── admin/              # Admin panel views
├── components/         # Reusable Blade components
├── home/               # Homepage sections
├── shop/               # Shop/category pages
├── product/            # Product detail
├── cart/               # Shopping cart
├── checkout/           # Checkout flow
├── account/            # User dashboard
└── layouts/            # Base layouts

routes/
├── web.php             # Web routes
├── api.php             # API routes
└── console.php         # Artisan commands
```

## Key Commands

```bash
# Testing
php artisan test                    # Run all tests
php artisan test --filter=ProductTest

# Code Style
vendor/bin/pint                     # Fix code style
vendor/bin/pint --test              # Check only

# Database
php artisan migrate:fresh --seed    # Reset & reseed
php artisan make:migration name     # New migration
php artisan make:seeder name        # New seeder

# Cache
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# Storage Link (for product images)
php artisan storage:link
```

## Deployment

### Laravel Cloud (Recommended)
```bash
# Install Laravel Cloud CLI
composer global require laravel/cloud-cli

# Deploy
cloud deploy
```

### Traditional VPS
1. Set `APP_ENV=production`, `APP_DEBUG=false`
2. Configure production database
3. Set secure `APP_KEY`
4. Configure mail driver (SMTP)
5. Set up SSL/HTTPS
6. Run: `php artisan config:cache && php artisan route:cache && php artisan view:cache`
7. Set up queue worker: `php artisan queue:work --daemon`
8. Set up scheduler: `* * * * * php /path/to/artisan schedule:run`

## Environment Variables Reference

| Variable | Required | Description |
|----------|----------|-------------|
| `APP_KEY` | Yes | Application encryption key |
| `DB_*` | Yes* | Database connection (*SQLite needs only DB_CONNECTION) |
| `WHATSAPP_NUMBER` | Yes | WhatsApp business number for orders |
| `MIDTRANS_*` | No | Payment gateway credentials |
| `GOOGLE_*` | No | OAuth credentials |
| `INSTAGRAM_*` | No | Instagram Graph API for feed |
| `MAIL_*` | Yes* | Email delivery (*required for password reset) |

## License

MIT License - see LICENSE file for details.

---

**Upsilon Ecommerce** - Built with Laravel 11 & ❤️