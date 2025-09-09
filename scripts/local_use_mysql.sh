#!/usr/bin/env bash
set -euo pipefail

# Usage:
#   bash scripts/local_use_mysql.sh <DB_NAME> [DB_USER] [DB_PASS] [DB_HOST] [DB_PORT]
# Examples:
#   bash scripts/local_use_mysql.sh iot_fst root ""
#   bash scripts/local_use_mysql.sh iot_fst iotfst StrongPass! 127.0.0.1 3306

DB_NAME=${1:-}
DB_USER=${2:-root}
DB_PASS=${3:-}
DB_HOST=${4:-127.0.0.1}
DB_PORT=${5:-3306}

if [[ -z "$DB_NAME" ]]; then
  echo "[ERR ] DB_NAME is required. Usage: bash scripts/local_use_mysql.sh <DB_NAME> [DB_USER] [DB_PASS] [DB_HOST] [DB_PORT]" >&2
  exit 1
fi

info()  { echo -e "\033[1;34m[INFO]\033[0m $*"; }
warn()  { echo -e "\033[1;33m[WARN]\033[0m $*"; }
error() { echo -e "\033[1;31m[ERR ]\033[0m $*"; }

ROOT_DIR=$(cd "$(dirname "$0")/.." && pwd)
cd "$ROOT_DIR"

if [[ ! -f .env ]]; then
  info "Membuat .env dari .env.example"
  cp .env.example .env
fi

# Set mode lokal
grep -q '^APP_ENV=' .env && sed -i 's/^APP_ENV=.*/APP_ENV=local/' .env || echo 'APP_ENV=local' >> .env
grep -q '^APP_DEBUG=' .env && sed -i 's/^APP_DEBUG=.*/APP_DEBUG=true/' .env || echo 'APP_DEBUG=true' >> .env

# Konfigurasi MySQL
grep -q '^DB_CONNECTION=' .env && sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env || echo 'DB_CONNECTION=mysql' >> .env
grep -q '^DB_HOST=' .env && sed -i "s/^DB_HOST=.*/DB_HOST=${DB_HOST//\//\/}/" .env || echo "DB_HOST=${DB_HOST}" >> .env
grep -q '^DB_PORT=' .env && sed -i "s/^DB_PORT=.*/DB_PORT=${DB_PORT}/" .env || echo "DB_PORT=${DB_PORT}" >> .env
grep -q '^DB_DATABASE=' .env && sed -i "s/^DB_DATABASE=.*/DB_DATABASE=${DB_NAME}/" .env || echo "DB_DATABASE=${DB_NAME}" >> .env
grep -q '^DB_USERNAME=' .env && sed -i "s/^DB_USERNAME=.*/DB_USERNAME=${DB_USER}/" .env || echo "DB_USERNAME=${DB_USER}" >> .env
if grep -q '^DB_PASSWORD=' .env; then
  sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=${DB_PASS//\//\/}/" .env
else
  echo "DB_PASSWORD=${DB_PASS}" >> .env
fi

# Sederhanakan driver agar tidak perlu tabel tambahan (opsional tapi membantu)
grep -q '^SESSION_DRIVER=' .env && sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env || echo 'SESSION_DRIVER=file' >> .env
grep -q '^CACHE_STORE=' .env && sed -i 's/^CACHE_STORE=.*/CACHE_STORE=file/' .env || echo 'CACHE_STORE=file' >> .env
grep -q '^QUEUE_CONNECTION=' .env && sed -i 's/^QUEUE_CONNECTION=.*/QUEUE_CONNECTION=sync/' .env || echo 'QUEUE_CONNECTION=sync' >> .env

# Pilih PHP CLI
choose_php() {
  local candidates=(
    php
  )
  for p in "${candidates[@]}"; do
    if command -v "$p" >/dev/null 2>&1; then
      echo "$p"; return 0
    fi
  done
  return 1
}

PHP_BIN=$(choose_php || true)
if [[ -z "${PHP_BIN:-}" ]]; then
  warn "PHP CLI tidak ditemukan di PATH. Pastikan 'php' tersedia."
  PHP_BIN=php
fi

info "Membersihkan cache config dan migrasi database (${DB_NAME})"
"$PHP_BIN" artisan config:clear || true
"$PHP_BIN" artisan migrate || {
  warn "Migrasi gagal. Pastikan database ${DB_NAME} sudah ada dan kredensial benar."
  echo "Tips: Buat DB dengan: sudo mysql -u root -e \"CREATE DATABASE ${DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;\""
  exit 1
}

info "Selesai. Aplikasi sekarang terkonfigurasi ke MySQL (${DB_NAME})"
