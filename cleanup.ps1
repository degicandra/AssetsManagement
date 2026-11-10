# Asset Management System - Code Cleanup Script (PowerShell)
# This script runs all code formatters and linters

Write-Host "========================================" -ForegroundColor Green
Write-Host "Asset Management System - Code Cleanup" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

# Check if we're in the right directory
if (-not (Test-Path "composer.json")) {
    Write-Host "Error: composer.json not found. Please run this script from the project root." -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}

# Step 1: Laravel Pint (PHP Code Formatter)
Write-Host "[1/3] Running Laravel Pint (PHP Code Formatter)..." -ForegroundColor Cyan
php artisan pint
if ($LASTEXITCODE -ne 0) {
    Write-Host "Warning: Laravel Pint encountered an issue" -ForegroundColor Yellow
}
Write-Host ""

# Step 2: Prettier (JavaScript/CSS Formatter)
Write-Host "[2/3] Running Prettier (JavaScript/CSS Formatter)..." -ForegroundColor Cyan
npx prettier --write "resources/js/**/*.js" "resources/css/**/*.css" 2>$null
if ($LASTEXITCODE -ne 0) {
    Write-Host "Note: Prettier not fully configured or Node.js issue" -ForegroundColor Yellow
}
Write-Host ""

# Step 3: ESLint (JavaScript Linter)
Write-Host "[3/3] Running ESLint (JavaScript Linter)..." -ForegroundColor Cyan
npx eslint resources/js/ --fix 2>$null
if ($LASTEXITCODE -ne 0) {
    Write-Host "Note: ESLint not fully configured or Node.js issue" -ForegroundColor Yellow
}
Write-Host ""

Write-Host "========================================" -ForegroundColor Green
Write-Host "Code cleanup completed!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Read-Host "Press Enter to exit"
