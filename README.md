🗂 Folder Structure

Here’s the recommended structure of your Laravel project:

attendance-management-laravel/
│
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AttendanceController.php
│   │   │   ├── EmployeeController.php
│   │   │   └── AuthController.php
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   │   ├── Attendance.php
│   │   └── Employee.php
│   └── Providers/
│
├── bootstrap/
│   └── cache/
│
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── css/
│   ├── js/
│   └── images/
├── resources/
│   ├── views/
│   │   ├── attendance/
│   │   │   ├── index.blade.php
│   │   │   └── report.blade.php
│   │   ├── employee/
│   │   └── layouts/
│   └── css/
│
├── routes/
│   ├── web.php
│   └── api.php
├── storage/
│   └── app/
├── tests/
├── .env.example
├── composer.json
└── README.md
⚡ Steps to Run Locally

Anyone who wants to run your Laravel project can follow these steps:

1. Clone Repository
git clone https://github.com/Rana-Meet/attendance-management-laravel.git
cd attendance-management-laravel
2. Install Dependencies

Make sure PHP and Composer are installed:

composer install
npm install
npm run dev
3. Configure Environment

Copy .env.example to .env and set up your database:

cp .env.example .env
php artisan key:generate

Edit .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=attendance_db
DB_USERNAME=root
DB_PASSWORD=
4. Migrate Database
php artisan migrate
php artisan db:seed  # if you have seeders
5. Serve the Application
php artisan serve
