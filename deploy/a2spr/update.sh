#!/usr/bin/env bash
# Mise à jour d'Al Jazeera Hotel (h-aljazeera.a2spr.com) après un push sur la branche a2spr.
# Usage : sudo bash deploy/a2spr/update.sh
set -euo pipefail

APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
cd "$APP_DIR"

[ "$(id -u)" -eq 0 ] || { echo "Lancez le script avec sudo." >&2; exit 1; }
[ -f .env ] || { echo "Aucun .env : lancez d'abord install.sh." >&2; exit 1; }

PHP_V="$(grep -oE 'php[0-9]+\.[0-9]+-fpm\.sock' "/etc/nginx/sites-available/h-aljazeera.a2spr.com" | head -n1 | sed -E 's/php([0-9.]+)-fpm\.sock/\1/')"
PHP_BIN="$(command -v "php$PHP_V" || command -v php)"
WEB_USER="$(stat -c '%U' storage)"

"$PHP_BIN" artisan down || true
trap '"$PHP_BIN" artisan up' EXIT
git pull --ff-only
COMPOSER_ALLOW_SUPERUSER=1 "$PHP_BIN" "$(command -v composer)" install --no-dev --optimize-autoloader --no-interaction
"$PHP_BIN" artisan migrate --force
chown -R "$WEB_USER":"$WEB_USER" storage bootstrap/cache
sudo -u "$WEB_USER" "$PHP_BIN" artisan optimize:clear
sudo -u "$WEB_USER" "$PHP_BIN" artisan config:cache
sudo -u "$WEB_USER" "$PHP_BIN" artisan route:cache
sudo -u "$WEB_USER" "$PHP_BIN" artisan view:cache

echo "Mise à jour terminée."
