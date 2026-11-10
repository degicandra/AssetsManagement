# Code Cleanup & Maintenance Guide

## Overview
This document outlines the code quality standards, cleanup procedures, and maintenance guidelines for the Asset Management System project.

## Files Removed

The following unnecessary files have been removed to keep the project clean:

### Test & Development Scripts
- `check_dashboard_data.php` - Development testing script
- `check_licenses.php` - Development testing script
- `test_licenses.php` - Testing script
- `test_license_status.php` - Testing script
- `verify_emails.php` - Email verification script
- `verify_import.php` - Import verification script
- `verify_import_raw.php` - Raw import verification script
- `verify_migration.php` - Migration verification script
- `verify_rsia_import.php` - RSIA import verification script

### One-Time Setup Scripts
- `import_assets.php` - Asset import script (one-time use)
- `import_emails.php` - Email import script (one-time use)
- `import_rsia_bunda.php` - RSIA import script (one-time use)
- `setup_import.php` - Setup script (one-time use)

### Data Files
- `asset_import_template.csv` - Template file
- `email_data.csv` - Test data file

### Outdated Documentation
- `DARKMODE_ACTIVATION_GUIDE.md` - Obsolete (covered in SETUP_GUIDE.md)
- `DARKMODE_FIX.md` - Obsolete (covered in SETUP_GUIDE.md)
- `DARKMODE_SYSTEM.md` - Obsolete (covered in SETUP_GUIDE.md)
- `IMPORT_ASSETS_GUIDE.md` - Obsolete (one-time setup)

### Corrupted Files
- `Cancel, bg-gray-200` - Malformed filename

## Code Quality Standards

### PHP Code (Laravel)

#### Formatting Standards
- **Indentation**: 4 spaces
- **Line Endings**: LF (Unix style)
- **Max Line Length**: Aim for 120 characters (enforced via Prettier)
- **Imports**: Alphabetically ordered

#### PSR Standards
- Follow PSR-12 Code Style Guide
- Use Laravel Pint for automated code fixing: `php artisan pint`

#### Best Practices
- Use type hints for all function parameters and return types
- Group related model methods together
- Document complex logic with clear comments
- Keep methods focused on a single responsibility (SRP)

### JavaScript/Frontend Code

#### Formatting Standards
- **Indentation**: 4 spaces
- **Quotes**: Single quotes for strings
- **Semicolons**: Required at end of statements
- **Line Length**: Max 120 characters

#### Configuration Files
- `.prettierrc` - Code formatting rules
- `.eslintrc.json` - Linting rules
- Both are configured for consistency

#### Best Practices
- Use `const` by default, `let` when reassignment needed, avoid `var`
- Arrow functions preferred for callbacks
- Remove console.log statements in production code

### Database

#### Migrations
- Each migration should have a single responsibility
- Include meaningful comments for complex logic
- Use descriptive table and column names

#### Models
- Keep relationships clearly defined
- Use eager loading to prevent N+1 queries
- Document custom accessors and mutators

## Code Cleanup Procedures

### Running Code formatters

#### PHP Code
```bash
# Format all PHP files using Laravel Pint
php artisan pint

# Or format specific directory
php artisan pint app/Http/Controllers
```

#### JavaScript Code
```bash
# Format JavaScript files
npx prettier --write "resources/js/**/*.js"

# Lint JavaScript files
npx eslint resources/js/ --fix
```

### Regular Maintenance Tasks

1. **Weekly**: Run code formatters before commits
2. **Monthly**: Review and clean up unused imports
3. **Quarterly**: Audit database queries for N+1 problems
4. **Annually**: Review dependencies and update when needed

## Project Structure

```
AssetsManagement/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Application controllers
│   │   ├── Middleware/         # Custom middleware
│   │   └── Requests/           # Form request validation
│   ├── Models/                 # Eloquent models (13 models)
│   └── Observers/              # Event observers
├── config/                     # Configuration files
├── database/
│   ├── factories/              # Model factories
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── resources/
│   ├── css/                    # Stylesheets
│   ├── js/                     # JavaScript files
│   └── views/                  # Blade templates
├── routes/                     # Route definitions
├── tests/                      # Test suites
├── SETUP_GUIDE.md              # Main setup documentation
├── README.md                   # Project documentation
├── .prettierrc                 # Prettier config (formatting)
├── .eslintrc.json              # ESLint config (linting)
├── pint.json                   # Laravel Pint config
└── composer.json / package.json # Dependencies
```

## Continuous Improvement

### Code Review Checklist
- [ ] Code follows formatting standards
- [ ] No unused imports or variables
- [ ] Functions have appropriate type hints
- [ ] Complex logic is documented
- [ ] No hardcoded values (use config)
- [ ] Database queries are optimized
- [ ] Error handling is appropriate

### Common Issues to Watch For

1. **Duplicate Code**: Extract to reusable methods
2. **Large Methods**: Break down into smaller, focused methods
3. **Magic Strings**: Use constants or configuration
4. **Missing Type Hints**: Add types for better IDE support
5. **Unused Imports**: Remove regularly
6. **Console Logs**: Remove before production

## Documentation

- **README.md**: Project overview and features
- **SETUP_GUIDE.md**: Installation and setup instructions
- Controllers, models, and complex methods should have doc blocks

## Development Workflow

1. Create feature branch from `main`
2. Make changes following code standards
3. Run code formatters: `php artisan pint` + `npx prettier --write`
4. Test all changes thoroughly
5. Create pull request with clear description
6. Code review before merging
7. Merge to `main`

## Tools & Scripts

### Installed Code Quality Tools
- **Laravel Pint** - PHP code formatter and fixer
- **Prettier** - JavaScript/CSS code formatter
- **ESLint** - JavaScript linter
- **PHPUnit** - PHP testing framework

### Quick Commands
```bash
# Format PHP code
php artisan pint

# Format JavaScript
npx prettier --write "resources/js/**/*.js" "resources/css/**/*.css"

# Run tests
php artisan test
./vendor/bin/phpunit
```

## Notes

- Project is now lean and focused on core functionality
- All development/test scripts have been removed
- Code is clean and follows modern Laravel best practices
- Configuration files ensure consistent code quality across the team

---

**Last Updated**: April 2026
**Project**: Asset Management System v1.0
