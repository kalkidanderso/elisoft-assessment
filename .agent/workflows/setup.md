---
description: Setup CodeIgniter 4 project locally
---

# Local Development Setup Workflow

This workflow sets up the NGO ERP system on your local machine for development.

## Prerequisites

- PHP 8.1 or higher installed
- Composer installed
- MySQL 8.0 or higher
- Git installed

## Step 1: Verify PHP Installation

// turbo
```bash
php --version
```

Expected output: PHP 8.1.x or higher

## Step 2: Verify Composer Installation

// turbo
```bash
composer --version
```

## Step 3: Create CodeIgniter 4 Project

```bash
cd /home/kalk/all/task/elisoft
composer create-project codeigniter4/appstarter . --no-dev
```

## Step 4: Configure Environment

// turbo
```bash
cp env .env
```

## Step 5: Update Environment Variables

Edit `.env` file with your database credentials:
```
CI_ENVIRONMENT = development

database.default.hostname = localhost
database.default.database = ngo_erp
database.default.username = root
database.default.password = your_password
database.default.DBDriver = MySQLi
```

## Step 6: Create MySQL Database

```bash
mysql -u root -p -e "CREATE DATABASE ngo_erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

## Step 7: Install Additional Dependencies

// turbo
```bash
cd /home/kalk/all/task/elisoft
composer require --dev phpunit/phpunit
```

## Step 8: Set Permissions

// turbo
```bash
chmod -R 777 writable/
mkdir -p public/uploads/beneficiaries
chmod -R 777 public/uploads/
```

## Step 9: Run Database Migrations

```bash
php spark migrate
```

## Step 10: Seed Demo Data

```bash
php spark db:seed DemoDataSeeder
```

## Step 11: Start Development Server

```bash
php spark serve
```

The application will be available at: http://localhost:8080

## Step 12: Test Login

Open browser and navigate to:
- URL: http://localhost:8080
- Admin: `admin` / `Admin@123`
- User: `user` / `User@123`

## Troubleshooting

**Issue:** Database connection failed
**Solution:** Verify MySQL is running and credentials in `.env` are correct

**Issue:** Migration fails
**Solution:** Check if database exists and user has proper permissions

**Issue:** Permission denied errors
**Solution:** Run `chmod -R 777 writable/` to fix write permissions

**Issue:** Composer install fails
**Solution:** Run `composer install --ignore-platform-reqs` if PHP extensions missing

## Development Tools

**Useful Commands:**

```bash
# Clear cache
php spark cache:clear

# Run tests
./vendor/bin/phpunit

# Create new migration
php spark migrate:create create_table_name

# Rollback migration
php spark migrate:rollback

# Database refresh (rollback + migrate + seed)
php spark migrate:refresh
php spark db:seed DemoDataSeeder

# Generate app key
php spark key:generate
```

## Next Steps

After local setup is complete:
1. Review the implementation plan
2. Start building modules according to task.md
3. Test each module locally before deployment
4. Follow the deployment workflow when ready
