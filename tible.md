# Laravel Time & Attendance Demo App (Tible T&A[Time & Attendance]) - Portfolio Project

## Project Overview

Build a **fully functional, session-only Laravel application** mimicking AllHours time tracking, deployable to **Vercel** with **Docker** support for local development. Use **SESSION_DRIVER=cookie** so data persists across browser tabs/sessions but requires no database. Focus on **clean code, professional UI**, and **demo-ready experience** to showcase Laravel skills.

**Target**: A working demo where visitors can "clock in/out", see their "attendance history", and view fake team dashboards. Perfect for portfolio with instant Vercel deployment.

## Tech Stack & Constraints

- **Laravel 12.x** (latest stable)
- **PHP 8.3+**
- **No database** (session-only storage)
- **Session driver**: `cookie` (persists client-side)
- **Cache**: `array`
- **UI**: Blade + Tailwind CSS + Alpine.js (no JS framework)
- **Docker** for local dev
- **Vercel-ready** deployment config

## Core Features (Minimal but Impressive)

### 1. Authentication (Fake, Session-Based)
- Simple login form (email/password).
- Sessions store `user_id`, `name`, `role` (employee/manager).
- Logout clears session.
- 3 fake users:
  - `employee@test.com` / `pass` → "Mohammad Farhan Khan" (Employee)
  - `manager@test.com` / `pass` → "IT Manager" (Manager)
  - `admin@test.com` / `pass` → "Admin" (Admin)

### 2. Employee Dashboard
- **Clock In/Out button** (toggle state stored in session).
- **Today's timeline**: Shows clock-in/out times (e.g., "Clocked in: 9:15 AM").
- **Weekly summary**: Fake data showing Mon-Sun hours (stored in session).
- **Personal stats**: Total hours this week/month (calculated from session).

### 3. Manager Dashboard
- **Team overview table**: 5 fake employees with today's status (In/Out), total hours.
- **Late arrivals** alert (fake data).
- **Weekly team hours** chart (static data, CSS-styled bars).

### 4. Shared Features
- **Navigation**: Dashboard link, logout.
- **Responsive design** (mobile-friendly).

## Data Storage (All in Session)

**Session structure**:
user: {
id: 1,
name: "Mohammad Farhan Khan",
role: "employee",
clocked_in: true,
clock_in_time: "2026-01-21 09:15:00",
today_hours: 4.5,
weekly_hours: {mon: 8, tue: 7.5, ...}
}
team_data: { // For managers only
employees: [{name: "John", status: "In", hours: 6.2}, ...]
}


**No migrations, no DB config needed**.

## File Structure

laravel-time-tracker/
├── app/
│ ├── Http/Controllers/AuthController.php
│ ├── Http/Controllers/DashboardController.php
│ └── Http/Middleware/EnsureLoggedIn.php
├── resources/
│ ├── views/layouts/app.blade.php
│ ├── views/auth/login.blade.php
│ ├── views/dashboard/employee.blade.php
│ └── views/dashboard/manager.blade.php
├── database/ (empty, no migrations)
├── docker-compose.yml
├── Dockerfile
├── vercel.json
├── .env.example
└── README.md


## Controllers & Routes

### AuthController
- `GET /login` → login form
- `POST /login` → fake auth, set session, redirect to dashboard
- `POST /logout` → clear session, redirect to login

### DashboardController
- `GET /dashboard` → detect role from session, show appropriate dashboard
  - Employee: `employee.blade.php`
  - Manager: `manager.blade.php`

### Routes (web.php)
Route::get('/', fn() => redirect('/login'));
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index']);
Route::post('/clock', [DashboardController::class, 'clock']); // AJAX for clock in/out


## Environment Config (.env)

APP_NAME="Mini AllHours - Time Tracker"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

SESSION_DRIVER=cookie
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_COOKIE=mini_allhours_session

CACHE_DRIVER=array
QUEUE_CONNECTION=sync


**For Vercel production**:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.vercel.app


## Docker Setup

**Dockerfile** (production-ready):
```dockerfile
FROM php:8.3-apache
COPY . /var/www/html
RUN composer install --no-dev --optimize-autoloader
RUN a2enmod rewrite
EXPOSE 80

docker-compose.yml (local dev):

version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:80"
    volumes:
      - .:/var/www/html
    environment:
      - SESSION_DRIVER=cookie


Vercel Deployment
vercel.json:

{
  "version": 2,
  "builds": [
    {"src": "api/index.php", "use": "@vercel/php@1.0.0"}
  ],
  "routes": [
    {"src": "/(.*)", "dest": "api/index.php"}
  ],
  "env": {
    "SESSION_DRIVER": "cookie",
    "CACHE_DRIVER": "array",
    "APP_ENV": "production"
  }
}


api/index.php:

<?php
require __DIR__.'/../public/index.php';

UI Requirements
Tailwind CSS via CDN.

Clean, professional design (blues/greys like AllHours).

Mobile-responsive tables and buttons.

Alpine.js for clock toggle (no page reload).

Fake charts: CSS grid bars for hours.

Loading states and smooth transitions.

README.md Content

# Mini AllHours - Laravel Time Tracker Demo

Session-only Laravel app deployed to Vercel. No database needed.

## Demo Users
- employee@test.com / pass
- manager@test.com / pass
- admin@test.com / pass

## Local Setup
docker-compose up

## Vercel Deploy
vercel --prod

Tech: Laravel 12, Tailwind, Alpine.js, Session-only storage

Success Criteria
✅ Instant Vercel deploy (works out of box)
✅ No DB setup (session-only)
✅ 3 roles with different dashboards
✅ Realistic clock in/out flow
✅ Professional UI (Tailwind)
✅ Docker local dev
✅ Mobile responsive
✅ Portfolio-ready README

Next Steps for AI Agent
Create fresh Laravel 12 project: composer create-project laravel/laravel .

Remove all DB/migrations, configure session=cookie

Build controllers, routes, views as specified

Add Tailwind via CDN to layout

Create Docker files

Test locally: docker-compose up

Deploy to Vercel and verify all features work

Build this exactly as described - no additions, no database, focus on clean demo experience.

Use the images below as design references for the dashboard and employee details page 
![alt text](image.png)
![alt text](image-1.png)

make sure to add testing data in so the dashboard and details page has visible data 