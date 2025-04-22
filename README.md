# Laravel CRM

A modern Customer Relationship Management system built with Laravel, featuring a custom dark-themed interface with no external dependencies.

## Current Features

- 🏢 **Company Management** - Track and manage business clients with detailed company profiles
- 👥 **Customer Management** - Maintain comprehensive customer records with contact information
- 🎯 **Lead Management** - Track potential customers with status tracking and conversion tools
- 📧 **Email Communications** - Send and track emails to customers directly from the CRM
- 📞 **Communication Tracking** - Log all customer interactions in a centralized system
- 💰 **Sales Management** - Track sales opportunities and manage the sales pipeline
- 📊 **Dashboard** - View key metrics and recent activities at a glance
- 📄 **Quotes & Invoices** - Create, manage, and send professional quotes and invoices
- 📝 **Activity Logging** - Automatic tracking of all user actions with detailed history
- 👤 **Profile Management** - User profile customization with secure password management

## Design Features

- 🌑 **Custom Dark Theme** - Modern dark-themed interface throughout the application
- 🔤 **Text-Based Icons** - Simple text characters instead of external icon libraries
- 🎨 **Color-Coded Interface** - Intuitive color system for different sections and actions
- 📱 **Responsive Design** - Fully responsive layout that works on all device sizes
- 🧩 **Modular Components** - Consistent card-based design system across all views
- 🔍 **Activity Tracking** - Real-time activity logging with color-coded visual indicators

## Technical Implementation

- Built with Laravel 10.x and PHP 8.x
- No external CSS frameworks or icon libraries
- Custom CSS with global styling through dedicated stylesheet
- Blade template inheritance for consistent layouts
- Database-driven activity logging with polymorphic relationships
- Service-based architecture for business logic separation

## Requirements

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Node.js & NPM

## Installation

1. Clone the repository
```bash
git clone https://github.com/oliversimiyu/laravel-crm.git
cd laravel-crm
```

2. Install PHP dependencies
```bash
composer install
```

3. Install and compile frontend dependencies
```bash
npm install
npm run dev
```

4. Configure environment variables
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env` file

6. Run database migrations and seeders
```bash
php artisan migrate --seed
```

7. Start the development server
```bash
php artisan serve
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
