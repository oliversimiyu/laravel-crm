# Laravel CRM

A modern Customer Relationship Management system built with Laravel, featuring a clean and responsive interface with dark mode support.

## Features

- 🔐 Authentication & Authorization with role-based access control
- 🏢 Company Management
- 👥 Customer Management
- 🎯 Lead Management
- 📞 Communication Tracking
- ✅ Task Management
- 💰 Sales Management
- 📊 Dashboard with key metrics
- 🌓 Dark Mode Support
- 📱 Responsive Design

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
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_crm
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations
```bash
php artisan migrate
```

7. Start the development server
```bash
php artisan serve
```

## Modules

### Companies
- Create and manage companies
- Track company details and contacts
- View associated customers and activities

### Customers
- Comprehensive customer profiles
- Contact information management
- Activity history tracking
- Associated tasks and communications

### Leads
- Lead capture and tracking
- Lead status management
- Convert leads to customers
- Track lead sources and values

### Communications
- Log various types of communications (email, call, meeting, note)
- Schedule future communications
- Track communication history with customers and leads
- Status tracking for planned communications

### Tasks
- Create and assign tasks
- Set priorities and due dates
- Track task status
- Associate tasks with customers or leads

### Sales
- Record and track sales
- Generate invoices
- Track payment status
- Sales reporting

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## Security

If you discover any security-related issues, please email security@example.com instead of using the issue tracker.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
