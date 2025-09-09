#!/usr/bin/env bash
set -euo pipefail

# === Configure me ===
# Absolute path to your domain home created by CyberPanel (no trailing slash).
# Example: /home/example.com
DOMAIN_HOME="/home/iot.fst.unja.ac.id"

# App directory (Laravel project root) and Web root (public_html)
APP_DIR="${DOMAIN_HOME}/iot_fst_dashboard"
WEB_ROOT="${DOMAIN_HOME}/public_html"

# Optional: site URL (used to set APP_URL if provided)
APP_URL="https://iot.fst.unja.ac.id"

# Optional: set to user:group owner of the site (as shown by 'stat -c %U:%G').
# Leave empty to skip chown.
CHOWN_TARGET=""

# Optional: deploy from Git (1 to enable). If disabled, ensure code is already in $APP_DIR.
USE_GIT=0
GIT_URL="https://your.repo/url.git"
GIT_BRANCH="main"

# Optional: database migrate/seed (1 to enable seeding)
RUN_MIGRATIONS=1
RUN_SEED=0

# Optional: build frontend assets with Node if package.json exists
RUN_NPM_BUILD=0

# =====================

info()  { echo -e "\033[1;34m[INFO]\033[0m $*"; }
warn()  { echo -e "\033[1;33m[WARN]\033[0m $*"; }
error() { echo -e "\033[1;31m[ERR ]\033[0m $*"; }

choose_php() {
  local candidates=(
    /usr/local/lsws/lsphp83/bin/php
    /usr/local/lsws/lsphp82/bin/php
    /usr/local/lsws/lsphp81/bin/php
    /usr/bin/php
  )
  for p in "${candidates[@]}"; do
    if [ -x "$p" ]; then
      local ver
      ver=$("$p" -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;') || true
      if [[ "$ver" == "" ]]; then continue; fi
      # Require >= 8.2 for Laravel 12
      local major minor
      major=${ver%%.*}
      minor=${ver#*.}
      if (( major > 8 )) || { (( major == 8 )) && (( minor >= 2 )); }; then
        echo "$p"
        return 0
      fi
    fi
  done
  return 1
}

PHP_BIN=$(choose_php || true)
if [[ -z "${PHP_BIN:-}" ]]; then
  error "Tidak menemukan PHP >= 8.2 (lsphp82/83 atau /usr/bin/php). Sesuaikan PHP terlebih dahulu."
  exit 1
fi

# Prefer system composer with the chosen PHP to avoid CLI version mismatch
if [[ -x /usr/bin/composer ]]; then
  COMPOSER_CMD=("$PHP_BIN" /usr/bin/composer)
elif command -v composer >/dev/null 2>&1; then
  COMPOSER_CMD=(composer)
else
  error "Composer tidak ditemukan. Install composer terlebih dahulu."
  exit 1
fi

info "Menggunakan PHP: $PHP_BIN ($($PHP_BIN -v | head -n1))"
info "App dir: $APP_DIR"
info "Web root: $WEB_ROOT"

mkdir -p "$APP_DIR" "$WEB_ROOT"

if (( USE_GIT == 1 )); then
  if [ ! -d "$APP_DIR/.git" ]; then
    info "Cloning repository $GIT_URL (branch: $GIT_BRANCH) ke $APP_DIR"
    git clone --branch "$GIT_BRANCH" --depth 1 "$GIT_URL" "$APP_DIR"
  else
    info "Menarik update dari Git (branch: $GIT_BRANCH) di $APP_DIR"
    git -C "$APP_DIR" fetch --depth 1 origin "$GIT_BRANCH"
    git -C "$APP_DIR" checkout "$GIT_BRANCH"
    git -C "$APP_DIR" reset --hard "origin/$GIT_BRANCH"
  fi
else
  warn "USE_GIT=0. Pastikan kode sudah ada di $APP_DIR"
fi

if [ ! -f "$APP_DIR/composer.json" ]; then
  error "composer.json tidak ditemukan di $APP_DIR. Pastikan Anda sudah mengupload/clone project Laravel di sini."
  exit 1
fi

cd "$APP_DIR"
info "Menjalankan composer install (no-dev, optimized)"
"${COMPOSER_CMD[@]}" install --no-dev --prefer-dist --optimize-autoloader

if [ ! -f .env ]; then
  info "Membuat .env dari .env.example (silakan sesuaikan nilai-nilai penting)"
  cp -n .env.example .env || true
fi

# Set beberapa nilai env umum
sed -i 's/^APP_ENV=.*/APP_ENV=production/' .env || true
sed -i 's/^APP_DEBUG=.*/APP_DEBUG=false/' .env || true
if [[ -n "${APP_URL}" ]]; then
  # ganti atau tambahkan APP_URL
  if grep -q '^APP_URL=' .env; then
    sed -i "s|^APP_URL=.*|APP_URL=${APP_URL}|" .env
  else
    echo "APP_URL=${APP_URL}" >> .env
  fi
fi

if ! grep -q '^APP_KEY=' .env || grep -Eq '^APP_KEY=\s*$' .env; then
  info "Generate APP_KEY"
  "$PHP_BIN" artisan key:generate --force
fi

info "Set permissions untuk storage dan bootstrap/cache"
chmod -R ug+rwX storage bootstrap/cache || true

if [[ -n "$CHOWN_TARGET" ]]; then
  info "Mengubah owner menjadi $CHOWN_TARGET (opsional)"
  chown -R "$CHOWN_TARGET" "$APP_DIR" "$WEB_ROOT" || warn "Gagal chown, lanjutkan."
fi

info "Membuat storage symlink (di dalam project)"
"$PHP_BIN" artisan storage:link || warn "storage:link gagal (biasanya sudah ada)"

if (( RUN_MIGRATIONS == 1 )); then
  info "Menjalankan migrasi database"
  "$PHP_BIN" artisan migrate --force
  if (( RUN_SEED == 1 )); then
    info "Menjalankan db:seed"
    "$PHP_BIN" artisan db:seed --force
  fi
fi

if (( RUN_NPM_BUILD == 1 )) && [ -f package.json ]; then
  if command -v npm >/dev/null 2>&1; then
    info "Build aset frontend (npm ci && npm run build)"
    npm ci
    npm run build
  else
    warn "npm tidak ditemukan. Lewati build aset."
  fi
fi

info "Optimasi cache konfigurasi/route/view"
"$PHP_BIN" artisan config:cache || true
"$PHP_BIN" artisan route:cache || true
"$PHP_BIN" artisan view:cache || true

# --- Web root (shim mode): gunakan public_html sebagai web root ---
info "Menyiapkan web root (public_html) dengan index shim dan .htaccess"
rm -f "$WEB_ROOT/index.html" || true
install -D -m 0644 "$APP_DIR/public/.htaccess" "$WEB_ROOT/.htaccess" || true
cat > "$WEB_ROOT/index.php" <<PHP
<?php
define('LARAVEL_START', microtime(true));
require __DIR__ . '/../$(basename "$APP_DIR")/vendor/autoload.php';

// Jalur bootstrap/app relatif dari web root ke app dir

\$app = require_once __DIR__ . '/../$(basename "$APP_DIR")/bootstrap/app.php';
\$kernel = \$app->make(Illuminate\\Contracts\\Http\\Kernel::class);
\$request = Illuminate\\Http\\Request::capture();
\$response = \$kernel->handle(\$request);
\$response->send();
\$kernel->terminate(\$request, \$response);
PHP

# Symlink aset statik agar dilayani langsung
ln -sfn "../$(basename "$APP_DIR")/public/build"    "$WEB_ROOT/build"   || true
ln -sfn "../$(basename "$APP_DIR")/public/storage"  "$WEB_ROOT/storage" || \
  ln -sfn "../$(basename "$APP_DIR")/storage/app/public" "$WEB_ROOT/storage" || true

cat <<EOT
---
Selesai.
Pastikan di CyberPanel:
- Domain mengarah ke: $WEB_ROOT (default akun) atau atur DocumentRoot ke $APP_DIR/public bila ingin tanpa shim.
- SSL sudah di-issue (Let's Encrypt)

Cron scheduler (opsional):
  * * * * * $PHP_BIN $APP_DIR/artisan schedule:run >> /dev/null 2>&1

Queue (contoh perintah worker):
  $PHP_BIN $APP_DIR/artisan queue:work --sleep=3 --tries=3 --max-time=3600

Log penting:
- OpenLiteSpeed: /usr/local/lsws/logs/error.log
- Domain logs: $DOMAIN_HOME/logs/
---
EOT
