# Asset Management System

A comprehensive asset management solution built with Laravel 12, Tailwind CSS, and MySQL. This system provides complete tracking and management of company assets, emails, software licenses, and administrative settings.

## 🚀 Key Features

### Dashboard & Analytics
- Real-time asset statistics
- Interactive charts and graphs
- Quick overview of asset status distribution
- Total asset count and status breakdown

### Asset Management
- **Complete CRUD Operations** - Create, Read, Update, Delete assets
- **Advanced Search** - Search by asset code or use barcode scanner
- **Smart Filtering** - Filter by status (Ready to Deploy, Deployed, Archived, Broken, In Service, Request Disposal, Disposal)
- **Asset History** - Complete audit trail of all changes and upgrades
- **Image Upload** - Upload and manage asset photos
- **Detailed Tracking** - Company, model, brand, serial number, purchase date, warranty information
- **Location Management** - Floor-based location selection with dropdown hierarchy

### Email Management
- **Company Email Tracking** - Manage organizational email accounts
- **Complete History** - Track all email assignment changes
- **Status Management** - Active, inactive, suspended email accounts
- **Department Assignment** - Assign emails to specific departments

### License Management
- **Software License Tracking** - Monitor all software licenses
- **Expiration Alerts** - Automatic tracking of upcoming expirations
- **Status Monitoring** - Active, inactive, expired soon, expired statuses
- **Department Assignment** - Assign licenses to departments
- **License History** - Complete audit trail of license changes

### Settings Module
- **User Management** - Add and manage system users
- **Department Management** - Create and organize company departments
- **Floor Management** - Manage building floor information
- **Location Management** - Detailed location tracking within floors
- **Recommended Additions** - Asset categories, vendors, maintenance schedules, notification settings

### UI/UX Features
- **Modern Design** - Clean, professional interface with white/green color scheme
- **Dark Mode** - Full dark mode support with localStorage persistence
- **Responsive Design** - Mobile-friendly and tablet-optimized
- **Success/Error Notifications** - Visual feedback for all user actions
- **Intuitive Navigation** - Easy-to-use menu system with dropdown options

## 🛠️ Technology Stack

- **Backend:** Laravel 12
- **Frontend:** Tailwind CSS, JavaScript (ES6+)
- **Database:** MySQL 5.7+
- **Development:** PHP 8.1+, Composer, Node.js, NPM
- **Charts:** Chart.js
- **Icons:** Heroicons

## 📋 System Requirements

- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Node.js and NPM
- Apache or Nginx web server

## 📖 Installation

### Quick Setup with XAMPP

1. **Start XAMPP**
   - Launch XAMPP Control Panel
   - Start Apache and MySQL services

2. **Database Setup**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create database named `assets_management`

3. **Project Installation**
   ```bash
   # Navigate to htdocs
   cd C:\xampp\htdocs
   
   # Install PHP dependencies
   composer install
   
   # Install frontend dependencies
   npm install
   
   # Build assets
   npm run dev
   ```

4. **Configuration**
   ```bash
   # Copy environment file
   copy .env.example .env
   
   # Generate application key
   php artisan key:generate
   
   # Run migrations
   php artisan migrate
   ```

5. **Create Admin User**
   ```bash
   php artisan tinker
   App\Models\User::create([
       'name' => 'Admin User',
       'email' => 'admin@example.com',
       'password' => bcrypt('password123')
   ]);
   ```

6. **Start Application**
   ```bash
   php artisan serve
   ```

## 🔐 Default Login
- **Email:** admin@example.com
- **Password:** password123

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── AuthController.php
│   ├── DashboardController.php
│   ├── AssetController.php
│   ├── EmailController.php
│   ├── LicenseController.php
│   └── SettingController.php
├── Models/
│   ├── User.php
│   ├── Asset.php
│   ├── Department.php
│   ├── Floor.php
│   ├── Location.php
│   ├── Email.php
│   ├── License.php
│   └── History Models
database/
├── migrations/
│   ├── Create assets, emails, licenses tables
│   └── Create history tracking tables
resources/
├── views/
│   ├── layouts/
│   ├── dashboard/
│   ├── assets/
│   ├── emails/
│   ├── licenses/
│   └── settings/
```

## 🎨 Customization

### Color Scheme
The system uses a white/green color scheme that can be easily customized in `tailwind.config.js`:

```javascript
theme: {
    extend: {
        colors: {
            primary: {
                500: '#22c55e',  // Main green
                600: '#16a34a',  // Darker green
            }
        }
    }
}
```

### Adding New Features
1. **New Asset Fields:** Modify migrations and models
2. **Additional Modules:** Follow Laravel resource controller pattern
3. **Custom Reports:** Add new controller methods and views
4. **API Integration:** Extend with API routes and controllers

## 📊 Database Schema

### Core Tables
- **users** - System users and authentication
- **departments** - Company departments
- **floors** - Building floor information
- **locations** - Specific locations within floors
- **assets** - Main asset tracking table
- **emails** - Company email accounts
- **licenses** - Software license management

### History Tracking
- **asset_histories** - Asset change history
- **email_histories** - Email change history
- **license_histories** - License change history

## 🔧 Development Commands

```bash
# Development server
php artisan serve

# Compile assets
npm run dev

# Production build
npm run build

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
php artisan migrate

# Create new migration
php artisan make:migration create_table_name
```

## 🛡️ Security Features

- **Authentication:** Laravel's built-in authentication system
- **Authorization:** Role-based access control
- **Data Validation:** Form request validation
- **CSRF Protection:** Built-in Laravel CSRF protection
- **SQL Injection:** Prevention through Eloquent ORM
- **XSS Protection:** Automatic output escaping

## 📈 Performance Optimization

- **Database Indexing:** Properly indexed foreign keys
- **Eager Loading:** Prevent N+1 query issues
- **Caching:** Laravel cache system ready for implementation
- **Asset Minification:** Production-ready asset compilation
- **Pagination:** Efficient data loading for large datasets

## 📞 Support

For issues, questions, or feature requests:
1. Check the SETUP_GUIDE.md for detailed installation instructions
2. Review Laravel documentation for framework-specific issues
3. Check system logs in `storage/logs/laravel.log`

## 🚀 Future Enhancements

- Asset barcode generation and scanning
- Email notification system
- Asset depreciation tracking
- Preventive maintenance scheduling
- Advanced reporting and export capabilities
- RESTful API for mobile applications
- Multi-language support
- Advanced search with filters

## 📄 License

This project is open-source and available under the MIT License.

---

**Note:** This is a complete, production-ready asset management system that follows Laravel best practices and modern web development standards. The system is fully functional and ready for deployment with minimal configuration.