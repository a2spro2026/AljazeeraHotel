#!/usr/bin/env bash
# Mise à jour d'Al Jazeera Hotel (h-aljazeera.a2spr.com).
# Le code arrive soit par « git push vps a2spr » depuis le poste de développement,
# soit par « git pull » si un remote est configuré sur le serveur.
# Usage : sudo bash deploy/a2spr/update.sh
set -euo pipefail

APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
cd "$APP_DIR"

[ "$(id -u)" -eq 0 ] || { echo "Lancez le script avec sudo." >&2; exit 1; }
[ -f .env ] || { echo "Aucun .env : lancez d'abord install.sh." >&2; exit 1; }

PHP_V="$(grep -oE 'php[0-9]+\.[0-9]+-fpm\.sock' "/etc/nginx/sites-available/h-aljazeera.a2spr.com" | head -n1 | sed -E 's/php([0-9.]+)-fpm\.sock/\1/' || true)"
PHP_BIN="$(command -v "php$PHP_V" 2>/dev/null || command -v php)"
DEPLOY_USER="$(stat -c '%U' artisan)"
WEB_USER="$(stat -c '%G' storage)"
as_deploy() { sudo -u "$DEPLOY_USER" "$@"; }
as_web()    { sudo -u "$WEB_USER" "$@"; }

as_web "$PHP_BIN" artisan down || true
trap 'as_web "$PHP_BIN" artisan up' EXIT

if [ -n "$(as_deploy git remote)" ]; then
    as_deploy git pull --ff-only
fi
as_deploy "$PHP_BIN" "$(command -v composer)" install --no-dev --optimize-autoloader --no-interaction
as_deploy "$PHP_BIN" artisan migrate --force
chown -R "$DEPLOY_USER":"$WEB_USER" storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache
as_web "$PHP_BIN" artisan optimize:clear
as_web "$PHP_BIN" artisan config:cache
as_web "$PHP_BIN" artisan route:cache
as_web "$PHP_BIN" artisan view:cache

echo "Mise à jour terminée."
