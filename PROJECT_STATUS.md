# Build status

This source package is a Laravel 12 project foundation implementing the requested Shohayok UI direction and core flows.

Validated before packaging:
- PHP syntax check passed for all PHP files.
- Blade templates are included for public home, auth, explore, listing details, provider dashboard/bookings, admin dashboard, banners and settings.
- Database migrations and seed data are included.
- Design reference screenshots are included under `design-reference/`.

The runtime dependencies (`vendor/` and `node_modules/`) are intentionally not bundled. Run Composer and npm commands from README on the target machine.

Google Maps, SMTP, SSLCommerz/Stripe and production social login require the corresponding credentials in `.env` and/or Admin Settings before production use.
