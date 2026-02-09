---
description: Deploy NGO ERP System to Railway
---

# Deployment Workflow for NGO Beneficiary Management System

This workflow guides you through deploying the CodeIgniter 4 application to Railway with MySQL database.

## Prerequisites

- Complete application built and tested locally
- GitHub account with repository created
- Railway account (sign up at railway.app)
- All environment variables documented

## Step 1: Prepare Application for Production

Update `.env` file for production readiness:
```bash
CI_ENVIRONMENT = production
app.baseURL = 'https://your-app.railway.app/'
```

## Step 2: Create Production Database Export

Export your local database with demo data:
```bash
mysqldump -u root -p ngo_erp > database/schema.sql
```

## Step 3: Initialize Git Repository

// turbo
```bash
cd /home/kalk/all/task/elisoft
git init
git add .
git commit -m "Initial commit: NGO Beneficiary Management System"
```

## Step 4: Push to GitHub

Create a new repository on GitHub, then:
```bash
git remote add origin https://github.com/YOUR_USERNAME/ngo-erp-system.git
git branch -M main
git push -u origin main
```

## Step 5: Deploy to Railway

1. Go to https://railway.app and sign in with GitHub
2. Click "New Project"
3. Select "Deploy from GitHub repo"
4. Choose your `ngo-erp-system` repository
5. Railway will auto-detect PHP and deploy

## Step 6: Add MySQL Database

1. In your Railway project, click "New"
2. Select "Database" → "MySQL"
3. Railway will provision a MySQL instance
4. Copy the connection details

## Step 7: Configure Environment Variables

In Railway project settings → Variables, add:
```
CI_ENVIRONMENT=production
DATABASE_HOST=[from Railway MySQL]
DATABASE_NAME=railway
DATABASE_USER=root
DATABASE_PASSWORD=[from Railway MySQL]
DATABASE_PORT=3306
app_baseURL=https://[your-app].railway.app/
```

## Step 8: Import Database Schema

Connect to Railway MySQL and import:
```bash
railway run mysql -u root -p railway < database/schema.sql
```

Or use Railway's MySQL client in the dashboard.

## Step 9: Run Migrations

```bash
railway run php spark migrate
railway run php spark db:seed DemoDataSeeder
```

## Step 10: Verify Deployment

1. Open the Railway-provided URL
2. Test login with demo credentials
3. Verify all features work
4. Check logs for any errors

## Step 11: Enable Public Domain

1. In Railway project settings
2. Go to "Settings" → "Domains"
3. Click "Generate Domain"
4. Copy the public URL for submission

## Alternative: Deploy to InfinityFree

If Railway has issues, use InfinityFree:

1. Sign up at infinityfree.net
2. Create hosting account
3. Upload files via FTP to `htdocs/`
4. Create MySQL database in cPanel
5. Import `database/schema.sql`
6. Update `.env` with InfinityFree database credentials
7. Set `writable/` permissions to 755

## Troubleshooting

**Issue:** Database connection fails
**Solution:** Verify Railway MySQL variables match `.env`

**Issue:** 404 errors on routes
**Solution:** Ensure `.htaccess` is uploaded and mod_rewrite enabled

**Issue:** Photo uploads fail
**Solution:** Check `writable/uploads/` permissions (755 or 777)

**Issue:** White screen / 500 error
**Solution:** Enable debug mode temporarily, check `writable/logs/`

## Post-Deployment Checklist

- [ ] Live URL accessible
- [ ] Login works (admin + user accounts)
- [ ] Database populated with demo data
- [ ] All CRUD operations functional
- [ ] File uploads working
- [ ] No console errors
- [ ] Mobile responsive
- [ ] README updated with live URL
