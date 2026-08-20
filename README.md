# Shohayok — Laravel 12 / Blade / MySQL

Shohayok is a multi-role service and rental marketplace with public pages, user accounts, provider dashboard and admin dashboard.

## Newly completed flows

- **Provider activation payment**: Admin controls regular price and discount percentage. The provider page shows regular price, discount amount and total. When the discount is 100%, the provider account activates without payment. When the total is above zero, the user sends money manually by bKash/Nagad, submits sender number + transaction ID, and the admin approves or rejects it.
- **Manual payment settings**: Admin → Settings contains provider fee, discount %, bKash number and Nagad number. This means you can launch with 100% discount and later enable paid registration without changing code.
- **User/provider ↔ admin messaging**: Authenticated users and providers have a floating chat box in the bottom-right. Messages appear in Admin → Messages. Admin can open a conversation and reply. Providers also have a Messages link in their dashboard.
- **Bangla/English switch**: Session-based Laravel locale switch with `lang/en/ui.php` and `lang/bn/ui.php`. Common navigation, provider payment and chat labels are localized. More labels can be added to the same files.
- **Google Maps**: Explore and listing detail pages use Google Maps JavaScript API, Places library and listing coordinates. The key can be stored in `.env` or Admin → Settings.

## Requirements

- PHP 8.2+
- MySQL 8+ / MariaDB compatible with Laravel 12
- Composer
- Node.js/npm only if you want to rebuild frontend assets

The ZIP includes the current project dependencies/assets where available, but on a normal machine you should still use Composer/npm when changing dependencies.

## Quick setup

1. Extract the ZIP.
2. Create a MySQL database named `shohayok`.
3. Copy `.env.example` to `.env` if `.env` is missing.
4. Configure database values in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shohayok
DB_USERNAME=root
DB_PASSWORD=
```

5. Add your Google Maps key (recommended) in `.env`:

```env
GOOGLE_MAPS_API_KEY=YOUR_NEW_RESTRICTED_KEY
```

Do not commit a production API key to Git. Restrict the key to your website domains and only the APIs you need.

6. Run:

```bash
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan optimize:clear
php artisan serve
```

If frontend assets need rebuilding:

```bash
npm install
npm run build
```

Open `http://127.0.0.1:8000`.

## Demo accounts after seeding

- Admin: `admin@shohayok.test` / `password`
- Provider: `provider@shohayok.test` / `password`
- User: `user@shohayok.test` / `password`

Change these passwords before production deployment.

## Provider payment flow

Go to **Admin → Settings** and set:

- Provider Registration Price
- Discount (%)
- bKash Send Money Number
- Nagad Send Money Number

Example launch setup: regular price `1000`, discount `100`. Total becomes `0` and provider activation does not require a transaction. Later change discount to `0` (or any value below 100) and the same page automatically shows the manual payment form.

Paid applications appear in **Admin → Provider Payments**. Approving a payment switches the account role to provider. Provider profile verification remains an admin approval step.

## Google Maps

Enable/restrict the key for the Google Maps services used by your website, then put the key in `.env` or Admin → Settings. The application first checks the database setting and falls back to `GOOGLE_MAPS_API_KEY`.

## Future live payment gateway

The manual bKash/Nagad flow intentionally works without merchant API credentials. When official merchant credentials are available, a live gateway controller can replace the manual transaction verification while keeping the same admin-controlled provider pricing.

## Production checklist

- `APP_ENV=production`
- `APP_DEBUG=false`
- Strong database credentials
- HTTPS enabled
- Restrict Google API key by production domain
- Configure SMTP
- Replace demo accounts/passwords
- Configure queue worker if asynchronous notifications are enabled later
- Run `php artisan optimize`

## Final UI additions
- Shohayok selected logo is installed at `public/images/shohayok-logo.png` and used in navbar/footer.
- Animated floating bubbles are restored behind the home search area.
- `public/css-final.css` is loaded directly so these final UI changes work even before rebuilding Vite assets.
