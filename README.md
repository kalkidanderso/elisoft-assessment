# NGO ERP System - Beneficiary Registration & Project Tracking Module

A comprehensive web-based system for NGOs to track beneficiaries, manage households, coordinate projects, and monitor progress. Built with **CodeIgniter 4** and designed for efficient beneficiary management.

![Dashboard](https://img.shields.io/badge/Status-Production_Ready-green)
![PHP](https://img.shields.io/badge/PHP-8.3.6-blue)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.7.0-red)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange)

---

## Features

### Authentication & Authorization
- **Secure Login**: Bcrypt password hashing with session management
- **Role-Based Access Control**: Admin and User roles with permission-based features
- **Protected Routes**: Authentication middleware for secure pages

### Beneficiary Management
- **Comprehensive Registration**: Personal information, photo upload, and ID tracking
- **Auto-Generated IDs**: Unique beneficiary IDs (format: `BEN-YYYY-00001`)
- **Profile Management**: View, edit, and update beneficiary details
- **Photo Upload**: Image storage with compression support
- **Duplicate Detection**: Prevent duplicate registrations
- **Search & Filter**: Advanced search capabilities

### Household Management  
- **Household Registration**: Family size, vulnerability status, income level tracking
- **Auto-Generated Codes**: Unique household codes (format: `HH-0001`)
- **Beneficiary Linking**: Associate beneficiaries with households
- **Vulnerability Assessment**: Track risk levels (Low, Medium, High, Critical)

### Projects & Interventions
- **Project Creation**: Define projects with budgets, timelines, and locations
- **Beneficiary Enrollment**: Link beneficiaries to projects
- **Progress Tracking**: Monitor project participation and status

### Monitoring & Alerts
- **System Alerts**: Automatic notifications for follow-ups and high-risk cases
- **Case Management**: Track social worker interactions and notes
- **Dashboard Analytics**: Real-time statistics and insights

### UI/UX
- **Responsive Design**: Bootstrap 5 with gradient color schemes
- **DataTables Integration**: Advanced table features with search and pagination
- **Professional Aesthetics**: Clean, modern interface with Font Awesome icons
- **Dark Blue Theme**: Professional color palette with glassmorphism effects

---

## Technology Stack

| Component | Technology |
|-----------|------------|
| **Backend** | PHP 8.3.6, CodeIgniter 4.7.0 |
| **Database** | MySQL 8.0 |
| **Frontend** | Bootstrap 5.3.2, Font Awesome 6.4.2 |
| **JavaScript** | jQuery 3.7.1, DataTables 1.13.7 |
| **Fonts** | Google Fonts (Inter) |

---

## Installation

### Prerequisites
- PHP 8.0 or higher
- Composer
- MySQL 8.0 or higher
- Apache/Nginx web server

### Step 1: Clone the Repository
```bash
cd /your/project/directory
git clone <repository-url>
cd elisoft
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Configure Environment
```bash
# Copy environment file
cp env .env

# Edit .env file
nano .env
```

Update the following in `.env`:
```ini
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = ngo_erp
database.default.username = root
database.default.password = YOUR_MYSQL_PASSWORD
database.default.DBDriver = MySQLi
database.default.port = 3306
```

### Step 4: Create Database
```bash
mysql -u root -p
```
```sql
CREATE DATABASE ngo_erp;
EXIT;
```

### Step 5: Import Schema
```bash
mysql -u root -p ngo_erp < database/schema.sql
```

### Step 6: Set Permissions
```bash
chmod -R 777 writable/
mkdir -p writable/uploads/beneficiaries
```

### Step 7: Start Development Server
```bash
php spark serve --host=0.0.0.0 --port=8080
```

Visit: **http://localhost:8080**

---

## Demo Credentials

### Administrator Account
- **Username**: `admin`
- **Password**: `password`
- **Role**: Full system access

### Field Officer Account  
- **Username**: `user`
- **Password**: `password`
- **Role**: Limited access

---

## Project Structure

```
elisoft/
├── app/
│   ├── Controllers/
│   │   ├── Auth.php              # Authentication
│   │   ├── Dashboard.php         # Dashboard
│   │   ├── Beneficiaries.php     # Beneficiary CRUD
│   │   ├── Households.php        # Household management
│   │   ├── Projects.php          # Project management
│   │   ├── Alerts.php            # Alert system
│   │   └── Monitoring.php        # Monitoring & case notes
│   ├── Models/
│   │   ├── UserModel.php         # User authentication
│   │   ├── BeneficiaryModel.php  # Beneficiary model
│   │   └── HouseholdModel.php    # Household model
│   ├── Views/
│   │   ├── layouts/main.php      # Main layout template
│   │   ├── auth/login.php        # Login page
│   │   ├── dashboard/index.php   # Dashboard
│   │   ├── beneficiaries/        # Beneficiary views
│   │   ├── households/           # Household views
│   │   ├── projects/             # Project views
│   │   └── alerts/               # Alert views
│   ├── Filters/
│   │   └── AuthFilter.php        # Authentication middleware
│   └── Config/
│       ├── Routes.php            # Route definitions
│       └── Filters.php           # Filter registration
├── database/
│   └── schema.sql                # Database schema
├── writable/
│   └── uploads/                  # File uploads
└── public/
    └── index.php                 # Entry point
```

---

## Database Schema

### Core Tables
- **users**: System users with roles (Admin/User)
- **beneficiaries**: Beneficiary profiles with auto-generated IDs
- **households**: Household data with vulnerability tracking
- **baseline_data**: Socioeconomic information (education, health, livelihood)
- **projects**: Project definitions with budgets and timelines
- **interventions**: Service types (cash assistance, training, etc.)
- **beneficiary_projects**: Many-to-many linking table
- **attendance**: Attendance tracking for events and trainings
- **case_notes**: Social worker notes and follow-ups
- **alerts**: System-generated notifications
- **referrals**: External service referrals

---

## Key Functionalities

### Beneficiary Registration
1. Navigate to **Beneficiaries** → **Register New Beneficiary**
2. Fill in personal details (name, age, gender, address)
3. Upload photo (optional)
4. Assign to household (optional)
5. System auto-generates unique Beneficiary ID

### Household Registration
1. Go to **Households** → **Register New Household**
2. Enter family size, vulnerability status, income level
3. System auto-generates unique Household Code
4. Link beneficiaries to the household

### Dashboard Analytics
- Total beneficiaries count
- Active projects overview
- Pending alerts summary
- Total households count
- Recently registered beneficiaries

---

## Security Features

- **Bcrypt Password Hashing**: Industry-standard encryption
- **CSRF Protection**: Built-in CodeIgniter CSRF tokens
- **Session Management**: Secure session handling
- **Role-Based Access Control**: Admin-only features
- **Input Validation**: Server-side validation on all forms
- **SQL Injection Prevention**: CodeIgniter Query Builder
- **Soft Deletes**: Data recovery capability

---

## Deployment

### Railway.app (Recommended)
1. Create a Railway account
2. Create new project → Deploy from GitHub
3. Add MySQL plugin
4. Configure environment variables
5. Import database schema
6. Deploy!

### InfinityFree
1. Upload files via FTP
2. Create MySQL database in cPanel
3. Import schema.sql
4. Update `.env` with production credentials
5. Set file permissions

---

## Development Notes

### Assumptions
- Single-organization deployment
- English language only (expandable)
- Local file storage for photos (cloud migration possible)
- Cron-based alert generation

### Limitations
- No email notifications (can be added)
- Basic reporting (exportable to CSV/PDF)
- No multi-tenancy support
- Single currency (USD)

### Future Enhancements
- [ ] Email notification system
- [ ] Advanced reporting with charts
- [ ] SMS integration for alerts
- [ ] Multi-language support
- [ ] Cloud file storage (AWS S3)
- [ ] Mobile app integration

---

## Author

**Kalkidan** - NGO ERP Development Team

---

## License

This project is developed for educational and humanitarian purposes.

---

## Support

For technical issues or questions:
- Check the implementation plan: `/brain/implementation_plan.md`
- Review database schema: `/database/schema.sql`
- Check logs: `/writable/logs/`

---

## Assessment Checklist

- Beneficiary & Household Registration
- Baseline & Socioeconomic Information capture
- Project & Intervention Management
- Monitoring & Case Management
- Alerts & Referral Tracking
- Role-based authentication
- Professional UI/UX
- Database normalization (3NF)
- Secure password hashing
- Live demo with credentials

---

Built for humanitarian impact.
