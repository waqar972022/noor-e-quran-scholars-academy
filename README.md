# Qalam Academy

Minimal Laravel 13 foundation for the Online Learning & Digital Library Platform.

## Requirements

- PHP 8.3+
- Composer
- MySQL
- Node.js 18+

## Setup

1. Copy `.env.example` to `.env` if needed.
2. Update the MySQL placeholders in `.env`:
   - `DB_DATABASE=qalam_academy`
   - `DB_USERNAME=qalam_user`
   - `DB_PASSWORD=change-me`
3. Install PHP dependencies:
   ```bash
   composer install
   ```
4. Generate the app key if the project is fresh:
   ```bash
   php artisan key:generate
   ```
5. Run the migrations and seed the base data:
   ```bash
   php artisan migrate --seed
   ```
6. Install frontend dependencies if you want the Blade styles compiled:
   ```bash
   npm install
   npm run dev
   ```
7. Start the app:
   ```bash
   php artisan serve
   ```

## Included Foundation

- Responsive Blade layout with header, footer, and content area
- Urdu RTL-ready content blocks
- `settings` table, model, seeder, and `setting()` helper
- `users` table with `name`, `email`, `password`, `role`, `phone`, `account_status`, and timestamps
- Default admin user seeded with:
  - Email: `admin@qalam.test`
  - Password: `Admin@12345`
  - Phone: `03001234567`
- Authentication pages for register, login, and logout
- Role-based redirect after login:
  - Admin -> `/admin`
  - User -> `/dashboard`
- Admin-only route protection through middleware
- PKT timezone and `pkr()` helper for currency formatting

## Notes

- Change the seeded admin password after the first login.
- The settings table seeds these editable keys:
  - `site_name`
  - `jazzcash_number`
  - `jazzcash_account_name`
  - `basic_plan_price`
  - `standard_plan_price`
  - `premium_plan_price`
