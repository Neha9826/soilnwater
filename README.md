# SoilnWater

A Laravel-based multi-purpose marketplace and local business platform that brings products, services, properties, projects, offers, classifieds, and customer/vendor workflows into one application.

## What it does

SoilnWater is structured as a marketplace platform with separate public, customer, vendor, and administrative workflows.

### Public marketplace

- Homepage and service directory
- Hotel and project listings
- Offers and classified listings
- Marketplace product browsing and product details
- Real-estate and property listings
- Public business/store profiles
- Promotions and advertisement listings
- Public media/image delivery through a storage proxy

### Customer workflows

- Account registration and login
- Google authentication
- Profile and onboarding
- Create and manage property, project, and advertisement listings
- Shopping cart and checkout
- Order history and order details
- Order-success flow

### Vendor workflows

- Manage a public business page
- Manage products and product details
- Manage properties
- Manage business branches
- Create and manage offers
- Vendor dashboard and profile management

### Administration

The application includes approval-oriented workflows for marketplace content, including product approval screens and authenticated administrative routes.

## Tech Stack

**Backend**
- PHP 8.2+
- Laravel 12
- Livewire
- Eloquent ORM

**Admin & UI**
- Filament 3
- Blade / Livewire components

**Integrations & utilities**
- Laravel Socialite
- Simple Qrcode
- Spatie Browsershot
- Vite / npm
- PHPUnit

## Architecture

The application uses Laravel as the core web platform with Livewire components for interactive pages and domain-specific workflows. Routes are organized around public discovery, authenticated customer/vendor operations, marketplace transactions, and administrative actions.

A notable implementation detail is the media proxy route, which serves stored images directly when normal public-storage symlinks are not reliable in the deployment environment.

## Repository Structure

```text
app/
  Livewire/       # Interactive public, customer, vendor and admin features
  Models/         # Domain models
  Http/           # Controllers and HTTP concerns

database/         # Migrations, factories and seeders
resources/        # Blade views and frontend assets
routes/           # Web and authentication routes
storage/          # Application storage
tests/            # Automated tests
```

## Getting Started

### Requirements

- PHP 8.2+
- Composer
- Node.js and npm
- A database supported by Laravel

### Installation

```bash
git clone https://github.com/Neha9826/soilnwater.git
cd soilnwater

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate

npm install
npm run build
```

Configure database and application values in `.env` before running migrations.

### Development

The repository includes a Composer development script that starts the Laravel server, queue listener, application logs, and Vite together:

```bash
composer run dev
```

### Tests

```bash
composer test
```

## Engineering Highlights

- Multi-role marketplace workflows in a single Laravel application
- Livewire-driven interactive CRUD and management screens
- Authenticated customer and vendor areas
- Public marketplace discovery alongside transactional flows
- Google authentication through Laravel Socialite
- Filament-powered administration
- Media handling designed for shared-hosting deployment constraints
- QR-code and browser-rendering utilities integrated into the application

## Project Status

Active application project with a broad marketplace feature set and ongoing development.

## Author

**Neha Pattnayak**  
Full Stack Engineer

## License

This project is proprietary unless otherwise specified by the repository owner.
