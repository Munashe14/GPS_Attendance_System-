# QR Attendance System

A Dynamic QR Code and GPS-Based Attendance System for distance learning institutions. This system allows lecturers to create sessions with time-limited QR codes, and students to scan these codes with GPS location verification to mark attendance.

## Features

- **Role-based Authentication**: Student, Lecturer, Regional Admin, and System Admin roles
- **Dynamic QR Codes**: Time-limited QR codes (2-minute expiry) with refresh capability
- **GPS Location Validation**: Haversine formula to verify student location within regional centre radius
- **Attendance Tracking**: Real-time attendance records with distance and status tracking
- **Regional Centre Management**: CRUD operations for regional centres with GPS coordinates and radius settings
- **Anomaly Detection**: Flagged attendance records for students outside allowed GPS boundaries
- **User Management**: System admin can view all users and audit logs

## Requirements

- PHP 7.4 or higher
- Composer
- SQLite (default) or MySQL
- Web server (Apache/Nginx or PHP built-in server)

## Installation

1. **Clone or extract the project** to your desired directory.

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

4. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

5. **Seed the database** with initial data:
   ```bash
   php artisan db:seed
   ```

   This will create:
   - 3 Regional Centres with GPS coordinates
   - 5 Modules
   - 10 Students
   - 4 Users (1 for each role)

## Running the Application

Start the development server:
```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`

## Test Credentials

Use the seeded credentials below to test different roles, or create your own account from the Register page.

| Role | Username | Password |
|------|----------|----------|
| Student | student | password |
| Lecturer | lecturer | password |
| Regional Admin | regional_admin | password |
| System Admin | admin | password |

## Usage

### Lecturer Workflow
1. Login as a lecturer
2. Create a new session (select module, centre, date, and time)
3. Activate the session to generate a QR code
4. Display the QR code to students (valid for 2 minutes)
5. Refresh QR code if needed
6. Close the session when done
7. View attendance records with GPS validation status

### Student Workflow
1. Login as a student
2. Navigate to the scan page
3. Grant camera and GPS permissions
4. Scan the QR code displayed by the lecturer
5. System automatically captures GPS location and validates attendance
6. View attendance history

### Regional Admin Workflow
1. Login as a regional admin
2. View dashboard with centre statistics
3. Manage regional centres (CRUD operations)
4. View flagged attendance reports (students outside GPS boundaries)

### System Admin Workflow
1. Login as a system admin
2. View dashboard with user statistics
3. Manage all system users
4. View audit logs for system activity

## Technical Details

- **Framework**: Laravel 8 (compatible with PHP 7.4)
- **Frontend**: Bootstrap 5 (via CDN, no build process required)
- **Database**: SQLite (configurable to MySQL)
- **QR Code Generation**: endroid/qr-code package
- **QR Code Scanning**: html5-qrcode JavaScript library
- **GPS Validation**: Haversine formula for distance calculation

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── LecturerController.php
│   │   ├── StudentController.php
│   │   ├── RegionalAdminController.php
│   │   └── SysAdminController.php
│   └── Requests/
│       └── Auth/
│           └── LoginRequest.php
database/
├── migrations/
│   ├── create_users_table.php
│   ├── create_regional_centres_table.php
│   ├── create_modules_table.php
│   ├── create_students_table.php
│   ├── create_sessions_table.php
│   ├── create_attendance_records_table.php
│   └── create_audit_logs_table.php
└── seeders/
    ├── RegionalCentreSeeder.php
    ├── ModuleSeeder.php
    ├── StudentSeeder.php
    └── UserSeeder.php
resources/views/
├── layouts/
│   └── app.blade.php
├── auth/
│   └── login.blade.php
├── lecturer/
├── student/
├── regional-admin/
└── sys-admin/
```

## Troubleshooting

### Application Key Error
If you see "No application encryption key has been specified", run:
```bash
php artisan key:generate
```

### Database Issues
If you encounter database errors, ensure the SQLite file exists:
```bash
touch database/database.sqlite
```

### Permission Issues
Ensure the `storage` and `bootstrap/cache` directories are writable:
```bash
chmod -R 775 storage bootstrap/cache
```

## License

This project is open-sourced software licensed under the MIT license.
