# UM Rental Website

University of Macau rental platform for bicycle/scooter usage, including student rental flow, staff operations, and admin management.

## What You Need to Run

- Windows 10/11 + XAMPP (Apache + MySQL)
- PHP 8.1+ (XAMPP bundled PHP is fine)
- MySQL 8.0+ (or MariaDB compatible with current schema)
- Web browser (Chrome/Edge/Firefox)

## Recommended XAMPP Setup

1. Start `Apache` and `MySQL` in XAMPP Control Panel.
2. Put this project under your XAMPP web root (example: `...\xampp\htdocs\project`).
3. Open terminal in project root and initialize database:

```bat
setup_database.bat full root
```

## Database Setup Scripts (.bat)

- `setup_database.bat`
  - Main setup script for this project.
  - Supports modes: `full`, `minimal`, `prod`.
  - Supports profiles: `root`, `um_app`.
  - Example commands:
    - `setup_database.bat full root`
    - `setup_database.bat minimal root`
    - `setup_database.bat prod um_app`
- `setup_database_um_app.bat`
  - Compatibility wrapper that forwards to `setup_database.bat` using `um_app` profile.
  - Example commands:
    - `setup_database_um_app.bat full`
    - `setup_database_um_app.bat minimal`
    - `setup_database_um_app.bat prod`

### Portability Note (No fixed drive required)

`setup_database.bat` does not hardcode `C:` or `D:`. It detects `mysql.exe` in this order:

1. System `PATH`
2. Relative path from project (`..\..\mysql\bin\mysql.exe`)
3. `%XAMPP_HOME%\mysql\bin\mysql.exe` (if `XAMPP_HOME` is set)

This means the project can run from different drives/folders as long as MySQL client is available.

## Database and Seed

- Main schema: `database/schema.sql`
- Demo seed: `database/seed_demo_data.sql`
- Reset demo state: `database/reset_demo_state.sql`
- If you only need quick basic setup:
  - `database/basic_schema.sql`
  - `database/basic_seed.sql`

## URLs

- Home: `http://localhost/project/home.php`
- Login: `http://localhost/project/login.php`
- Student Dashboard: `http://localhost/project/dashboard.php`
- Staff Dashboard: `http://localhost/project/staff/staff_dashboard.php`
- Admin Dashboard: `http://localhost/project/admin/admin_dashboard.php`

## Demo Accounts (admin / staff / student)

Use these seeded accounts:

- Admin
  - Campus ID: `dc325107`
  - Role: `admin`
- Staff
  - Campus ID: `t2000001`
  - Role: `staff`
- Student
  - Campus ID: `s1000001`
  - Role: `student`

Demo password (all seeded users): `Password123`

## Environment Variables (Optional)

- `DB_HOST`
- `DB_PORT`
- `DB_NAME`
- `DB_USER`
- `DB_PASS`
- `DB_SOCKET`

If env vars are not set, local DB fallback config is used.

## Quick Verification Checklist

- Apache and MySQL are both green/running in XAMPP.
- `setup_database.bat full root` runs without SQL errors.
- Login works with the 3 roles above.
- Student can rent/return.
- Staff can manage rental data.
- Admin can access admin-only actions.

## More Docs

- Project docs index: `docs/README.md`
- Database setup details: `database/README.md`
- Runtime requirement checklist: `requirment.txt`
- API overview: `docs/specs/API_OVERVIEW.md`
- Test checklist: `docs/testing/TEST_CHECKLIST.md`
- Security policy: `docs/security/SECURITY_POLICY.md`
- Work log: `log.txt`
