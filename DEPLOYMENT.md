Laravel 12 on CyberPanel (OpenLiteSpeed) — Quick Deploy

Requirements
- PHP >= 8.2 selected for the domain (CyberPanel PHP Selector).
- Composer installed on server.
- Database created (name, user, password).
- Domain created in CyberPanel with SSL.

One-time Setup
1) SSH into server as the site user or root.
2) Edit `scripts/deploy_cyberpanel.sh` configuration section:
   - `DOMAIN_HOME` → e.g. `/home/example.com`
   - `APP_DIR` → Laravel project path (default: `$DOMAIN_HOME/iot_fst_dashboard`)
   - `WEB_ROOT` → Web root path (default: `$DOMAIN_HOME/public_html`)
   - `APP_URL` → e.g. `https://example.com` (optional)
   - Optionally set `CHOWN_TARGET` (user:group shown by `stat -c %U:%G /home/example.com/public_html`).
   - Optionally enable `USE_GIT=1` and set `GIT_URL`, `GIT_BRANCH`.
   - Optionally enable `RUN_MIGRATIONS`, `RUN_SEED`, and `RUN_NPM_BUILD`.
3) Run:
   - `bash scripts/deploy_cyberpanel.sh`

What the script does
- Picks a suitable PHP binary (prefers `lsphp83`/`lsphp82`).
- Clones or updates the repo into `APP_DIR` (optional).
- Runs `composer install --no-dev --optimize-autoloader` inside `APP_DIR`.
- Creates `.env` if missing, sets `APP_ENV/APP_DEBUG`, applies `APP_URL` if provided, and generates `APP_KEY`.
- Fixes permissions for `storage` and `bootstrap/cache`.
- Creates `storage` symlink in Laravel project.
- Runs `php artisan migrate --force` (and seeds if enabled).
- Optionally builds frontend assets (`npm ci && npm run build`).
- Caches config/routes/views.
- Prepares `WEB_ROOT` with Laravel `.htaccess`, index shim, and symlinks to `build` and `storage`.
- Prints cron and queue commands to use.

CyberPanel Notes
- Default account web root is `.../public_html` (script sets shim and symlinks).
- Alternative (cleaner): set Document Root to `/home/<domain>/iot_fst_dashboard/public` via Website vHost Conf.
- Issue SSL via Websites → Manage → Issue SSL.
- Scheduler: Cron → Add Cron
  - `* * * * * /usr/local/lsws/lsphp82/bin/php /home/<domain>/iot_fst_dashboard/artisan schedule:run >> /dev/null 2>&1`
- Queue: use Supervisor to run
  - `/usr/local/lsws/lsphp82/bin/php /home/<domain>/iot_fst_dashboard/artisan queue:work --sleep=3 --tries=3 --max-time=3600`

Troubleshooting
- 403 Forbidden → Document Root not set to `public` or permissions.
- 500 Error → Missing `APP_KEY`, wrong env/DB, or stale cache (`php artisan config:clear`).
- 404 routes → `.htaccess` in `public/` not applied; check vHost and rewrite.
- Logs:
  - OpenLiteSpeed: `/usr/local/lsws/logs/error.log`
  - Domain: `/home/<domain>/logs/`
