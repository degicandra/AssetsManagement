@echo off
REM Asset Management System - Code Cleanup Script
REM This script runs all code formatters and linters

echo ========================================
echo Asset Management System - Code Cleanup
echo ========================================
echo.

REM Check if we're in the right directory
if not exist composer.json (
    echo Error: composer.json not found. Please run this script from the project root.
    pause
    exit /b 1
)

echo [1/3] Running Laravel Pint (PHP Code Formatter)...
php artisan pint
if %errorlevel% neq 0 (
    echo Warning: Laravel Pint encountered an issue
)
echo.

echo [2/3] Running Prettier (JavaScript/CSS Formatter)...
call npx prettier --write "resources/js/**/*.js" "resources/css/**/*.css" 2>nul
if %errorlevel% neq 0 (
    echo Note: Prettier not fully configured or Node.js issue
)
echo.

echo [3/3] Running ESLint (JavaScript Linter)...
call npx eslint resources/js/ --fix 2>nul
if %errorlevel% neq 0 (
    echo Note: ESLint not fully configured or Node.js issue
)
echo.

echo ========================================
echo Code cleanup completed!
echo ========================================
echo.
pause
