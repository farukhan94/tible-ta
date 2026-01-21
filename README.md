# Tible T&A - Time & Attendance Tracker 🕐

A **session-only Laravel application** for time tracking and attendance management, inspired by AllHours. Built with Laravel, Tailwind CSS, and Alpine.js - requiring **no database setup**. Perfect for portfolio demonstration.

![Laravel](https://img.shields.io/badge/Laravel-8.x-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-7.4+-blue?style=flat-square&logo=php)
![Tailwind](https://img.shields.io/badge/Tailwind-3.x-38BDF8?style=flat-square&logo=tailwindcss)
![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat-square&logo=alpine.js)

## ✨ Features

- **Session-Based Authentication** - No database required
- **Employee Dashboard** - Clock in/out, view hours, weekly summary
- **Manager Dashboard** - Team oversight, attendance tracking, statistics
- **Real-Time Updates** - AJAX clock toggle without page refresh
- **Responsive Design** - Mobile-friendly interface
- **Docker Support** - Easy local development
- **Vercel Ready** - One-click deployment

## 🎭 Demo Credentials

### Employee Account
- **Email:** `employee@test.com`
- **Password:** `pass`
- **Role:** Employee with clock in/out access

### Manager Account  
- **Email:** `manager@test.com`
- **Password:** `pass`
- **Role:** Manager with team overview

### Admin Account
- **Email:** `admin@test.com`  
- **Password:** `pass`
- **Role:** Admin with full access

## 🚀 Quick Start

### Using Docker (Recommended)

```bash
# Clone the repository
git clone <your-repo-url>
cd allhours

# Start the application
docker-compose up

# Access the app at http://localhost:8000
```

### Manual Setup

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Start local server
php artisan serve

# Access the app at http://localhost:8000
```

## 📦 Technology Stack

- **Backend:** Laravel 8.x (session-only, no database)
- **Frontend:** Blade Templates + Tailwind CSS (CDN)
- **JavaScript:** Alpine.js (CDN)
- **Session Driver:** Cookie-based (client-side persistence)
- **Cache Driver:** Array (in-memory)
- **Containerization:** Docker & Docker Compose
- **Deployment:** Vercel-ready with serverless PHP

## 🎯 Key Highlights

### Employee Features
- ⏱️ One-click clock in/out
- 📊 Real-time hours tracking
- 📅 Weekly hours breakdown
- 📈 Personal statistics dashboard
- 🕐 Today's timeline view

### Manager Features
- 👥 Team member overview table
- ⚠️ Late arrival alerts
- 📊 Team hours visualization
- 📈 Statistical summaries
- 👁️ Real-time status monitoring

## 🏗️ Architecture

This application uses **session-only storage** - all data is stored in browser cookies:

- No database configuration needed
- No migrations to run
- Data persists across page refreshes
- Session expires after 120 minutes
- Perfect for portfolio demos

### Session Structure
```php
session('user') => [
    'id' => 1,
    'name' => 'Mohammad Farhan Khan',
    'role' => 'employee',
    'clocked_in' => true,
    'clock_in_time' => '2026-01-21 09:15:00',
    'today_hours' => 4.5,
    'weekly_hours' => ['Mon' => 8, 'Tue' => 7.5, ...]
]
```

## 📱 Screenshots

### Employee Dashboard
- Clean interface for time tracking
- Visual weekly hours chart
- Status indicators

### Manager Dashboard
- Team overview table
- Performance metrics
- Late arrival tracking

## 🌐 Deployment

### Vercel Deployment

```bash
# Install Vercel CLI
npm i -g vercel

# Deploy to Vercel
vercel --prod
```

The application includes `vercel.json` configuration for serverless PHP deployment.

### Docker Production

```bash
# Build production image
docker build -t tible-app .

# Run production container
docker run -p 8000:80 tible-app
```

## 📁 Project Structure

```
allhours/
├── app/
│   └── Http/
│       ├── Controllers/
│       │   ├── AuthController.php       # Fake authentication
│       │   └── DashboardController.php  # Dashboard routing
│       └── Middleware/
│           └── EnsureLoggedIn.php       # Session auth middleware
├── resources/views/
│   ├── layouts/app.blade.php            # Base layout
│   ├── auth/login.blade.php             # Login page
│   └── dashboard/
│       ├── employee.blade.php           # Employee dashboard
│       └── manager.blade.php            # Manager dashboard
├── routes/web.php                       # Application routes
├── docker-compose.yml                   # Local development
├── Dockerfile                           # Production container
├── vercel.json                          # Vercel deployment
└── api/index.php                        # Vercel entry point
```

## 🔧 Configuration

### Environment Variables

Key settings in `.env`:

```env
APP_NAME="Tible T&A - Time Tracker"
SESSION_DRIVER=cookie
CACHE_DRIVER=array
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_COOKIE=tible_session
```

## 🧪 Testing

### Manual Testing

1. **Login Flow**
   - Test all three demo accounts
   - Verify role-based routing

2. **Employee Features**
   - Clock in/out functionality
   - Hours calculation
   - Weekly summary display

3. **Manager Features**
   - Team data display
   - Statistics accuracy
   - Alert functionality

4. **Session Persistence**
   - Refresh browser
   - Open new tabs
   - Verify data persists

## 📝 Development Notes

- **No Database:** All data stored in sessions
- **Fake Authentication:** Hardcoded demo users
- **Client-Side Storage:** Cookie-based sessions
- **CDN Assets:** Tailwind CSS and Alpine.js via CDN
- **Portfolio Ready:** Clean code, professional UI

## 🤝 Contributing

This is a portfolio demonstration project. Feel free to fork and customize for your own needs!

## 📄 License

Open source - MIT License

## 👨‍💻 Author

**Mohammad Farhan Khan**

Built as a portfolio demonstration of Laravel skills with modern web development practices.

---

**Note:** This is a demonstration application using session-only storage. For production use with persistent data, integrate a database backend.
