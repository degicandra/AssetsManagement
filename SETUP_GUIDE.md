# Asset Management System - Setup Guide

## System Overview
This is a complete Asset Management System built with Laravel 12, Tailwind CSS, and MySQL. The system provides comprehensive asset tracking, email management, license management, and administrative settings with a modern UI featuring both light and dark modes.

## Features Implemented
- ✅ Home page and login system
- ✅ Dashboard with asset statistics and charts
- ✅ Asset management (CRUD, search, filtering, barcode scanner)
- ✅ Email management with history tracking
- ✅ License management with expiration tracking
- ✅ Settings module (users, departments, floors, locations)
- ✅ Modern UI with white/green color scheme and dark mode
- ✅ Success/error notifications for all actions

## Prerequisites
Before installing, ensure you have the following installed:
- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- XAMPP (recommended for Windows)
- Node.js and NPM

## Installation Steps

### 1. Install XAMPP
1. Download XAMPP from https://www.apachefriends.org/
2. Install XAMPP with Apache and MySQL components
3. Start Apache and MySQL services from XAMPP Control Panel

### 2. Create Database
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named `assets_management`
3. No need to create tables manually - Laravel migrations will handle this

### 3. Clone/Download the Project
1. Navigate to your XAMPP htdocs directory:
   ```
   cd C:\xampp\htdocs
   ```
2. Place the project folder in this directory

### 4. Configure Environment
1. Copy `.env.example` to `.env`:
   ```
   copy .env.example .env
   ```
2. Update the database configuration in `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=assets_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 5. Install Dependencies
Open Command Prompt or PowerShell in the project directory and run:

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Build frontend assets
npm run dev
```

### 6. Generate Application Key
```bash
php artisan key:generate
```

### 7. Run Database Migrations
```bash
php artisan migrate
```

### 8. Create Initial User
```bash
php artisan db:seed --class=UserSeeder
```

Or create a user manually:
```bash
php artisan tinker
```
Then in the tinker shell:
```php
App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123')
]);
```

### 9. Start the Development Server
```bash
php artisan serve
```

The application will be available at: http://localhost:8000

## Default Login Credentials
- Email: admin@example.com
- Password: password123

## System Configuration

### Adding Sample Data
To populate the system with sample data:

1. **Create Departments:**
   - IT Department
   - HR Department
   - Finance Department
   - Operations Department

2. **Create Floors:**
   - Ground Floor
   - 1st Floor
   - 2nd Floor

3. **Create Locations:**
   - IT Office (1st Floor)
   - Server Room (Ground Floor)
   - HR Office (2nd Floor)

### System Modules

#### 1. Dashboard
- Shows total asset statistics
- Displays charts for asset status distribution
- Provides quick overview of system health

#### 2. Assets Management
- Add, edit, view, and delete assets
- Search by asset code or use barcode scanner
- Filter by status (ready to deploy, deployed, archived, etc.)
- Track asset history and upgrades
- Upload asset images

#### 3. Email Management
- Manage company email accounts
- Track email assignment history
- View complete edit history

#### 4. License Management
- Track software licenses
- Monitor expiration dates
- Assign licenses to departments/users
- View license history

#### 5. Settings
- **User Management:** Add and manage system users
- **Departments:** Create and manage company departments
- **Floors:** Manage building floors
- **Locations:** Manage specific locations within floors

## Customization Options

### Changing Color Scheme
Modify the Tailwind CSS configuration in `tailwind.config.js`:
```javascript
theme: {
    extend: {
        colors: {
            primary: {
                50: '#f0fdf4',
                100: '#dcfce7',
                500: '#22c55e',
                600: '#16a34a',
                700: '#15803d',
            }
        }
    }
}
```

### Adding New Asset Types
1. Update the `assets` table migration
2. Modify the Asset model
3. Update the asset forms and views

### Adding New Modules
1. Create new model: `php artisan make:model ModuleName -m`
2. Create controller: `php artisan make:controller ModuleNameController`
3. Create views in `resources/views/module-name/`
4. Add routes in `routes/web.php`

## Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check if MySQL is running in XAMPP
   - Verify database credentials in `.env`
   - Ensure database `assets_management` exists

2. **Permission Denied Errors**
   - On Windows: Run Command Prompt as Administrator
   - Ensure proper file permissions on storage and bootstrap/cache directories

3. **Asset Compilation Issues**
   - Clear npm cache: `npm cache clean --force`
   - Reinstall dependencies: `npm install`
   - Run development build: `npm run dev`

4. **Migration Errors**
   - Clear migration cache: `php artisan migrate:fresh`
   - Check database connection settings

### Clearing Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## System Requirements
- **Server:** Apache 2.4+ or Nginx
- **PHP:** 8.1+
- **Database:** MySQL 5.7+ or MariaDB 10.2+
- **Memory:** 512MB minimum (1GB recommended)
- **Storage:** 100MB minimum for application files

## Security Considerations
- Change default passwords after installation
- Configure proper file permissions
- Enable HTTPS in production
- Regular database backups
- Keep Laravel updated to latest version

## Support
For issues or questions:
1. Check the troubleshooting section above
2. Review Laravel documentation
3. Check system logs in `storage/logs/`

## Additional Features You Can Add
- Asset barcode generation
- Email notifications
- Asset depreciation tracking
- Maintenance scheduling
- Reporting and export features
- API integration
- Mobile app support

This documentation provides a complete guide to set up and run the Asset Management System. The system is ready for production use with proper configuration and security measures.