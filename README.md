# Oliver's Laravel CRM

A modern Customer Relationship Management system built with Laravel, featuring a custom dark-themed interface with real-time updates and comprehensive business management tools.

## Current Features

- 🏢 **Company Management** - Track and manage business clients with detailed company profiles
- 👥 **Customer Management** - Maintain comprehensive customer records with contact information
- 🎯 **Lead Management** - Track potential customers with status tracking and conversion tools
- 📧 **Email Communications** - Send and track emails to customers directly from the CRM
- 📞 **Communication Tracking** - Log all customer interactions in a centralized system
- 💰 **Sales Management** - Track sales opportunities and manage the sales pipeline
- 📊 **Real-time Dashboard** - View key metrics and recent activities with automatic updates
- 📄 **Quotes & Invoices** - Create, manage, and send professional quotes and invoices as PDFs
- 📝 **Activity Logging** - Automatic tracking of all user actions with detailed history
- 👤 **Profile Management** - User profile customization with secure password management
- ⚡ **Real-time Updates** - Live revenue tracking and activity feed with automatic refreshing
- 📱 **Responsive Design** - Fully responsive layout that works on all device sizes

## Advanced Features

- 🔄 **Real-time Revenue Tracking** - Live revenue counter that updates automatically every 10 seconds
- 📋 **Activity Feed** - Real-time activity tracking showing the latest system events
- 📊 **Paginated Activity History** - View complete activity history with 10 items per page
- 📑 **PDF Generation** - Create professional single-page PDF invoices and quotes
- 📧 **Email Templates** - Customizable email templates for quotes and invoices
- 🔔 **Automatic Activity Logging** - System automatically logs all invoice and quote activities
- 🔄 **Lead Conversion** - Convert leads to customers with a single click
- 💼 **Task Management** - Assign and track tasks with polymorphic relationships
- 🔍 **Advanced Filtering** - Filter activities, customers, and sales by various criteria

## Design Features

- 🌑 **Custom Dark Theme** - Modern dark-themed interface throughout the application
- 🔤 **Text-Based Icons** - Simple text characters instead of external icon libraries
- 🎨 **Color-Coded Interface** - Intuitive color system for different sections and actions
- 📱 **Responsive Design** - Fully responsive layout that works on all device sizes
- 🧩 **Modular Components** - Consistent card-based design system across all views
- 🔍 **Activity Tracking** - Real-time activity logging with color-coded visual indicators
- 🦾 **Livewire Components** - Interactive UI components with real-time updates

## Technical Implementation

- Built with Laravel 10.x and PHP 8.x
- Livewire for real-time components without writing JavaScript
- Custom PDF generation using DomPDF
- No external CSS frameworks or icon libraries
- Custom CSS with global styling through dedicated stylesheet
- Blade template inheritance for consistent layouts
- Database-driven activity logging with polymorphic relationships
- Service-based architecture for business logic separation
- Event-driven activity logging for invoices and quotes

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

7. Seed the activity data (optional)
```bash
php artisan db:seed --class=ActivitySeeder
```

8. Start the development server
```bash
php artisan serve
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
