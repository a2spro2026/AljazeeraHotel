#!/usr/bin/env bash
# Installation d'Al Jazeera Hotel sur h-aljazeera.a2spr.com (VPS Nginx + PHP-FPM + MySQL).
# À lancer depuis le dossier du projet cloné :  sudo bash deploy/a2spr/install.sh
# Le script ne crée que des éléments propres à ce site et s'arrête avant toute
# modification si l'un d'eux existe déjà (config Nginx, base, utilisateur MySQL, .env).
set -euo pipefail

DOMAIN="h-aljazeera.a2spr.com"
DB_NAME="aljazeera"
DB_USER="aljazeera"
APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/../.." && pwd)"
NGINX_AVAILABLE="/etc/nginx/sites-available/$DOMAIN"
NGINX_ENABLED="/etc/nginx/sites-enabled/$DOMAIN"

step() { printf '\n\033[1;33m==> %s\033[0m\n' "$1"; }
ok()   { printf '\033[1;32m    ✔ %s\033[0m\n' "$1"; }
fail() { printf '\n\033[1;31mERREUR : %s\033[0m\n' "$1" >&2; exit 1; }

# ---------------------------------------------------------------------------
step "1/8 Vérifications (aucune modification tant qu'elles ne sont pas toutes OK)"
# ---------------------------------------------------------------------------
[ "$(id -u)" -eq 0 ] || fail "lancez le script avec sudo."
[ -f "$APP_DIR/artisan" ] || fail "projet Laravel introuvable dans $APP_DIR."
cd "$APP_DIR"

[ ! -e .env ] || fail "$APP_DIR/.env existe déjà (installation déjà faite ?). Rien n'a été modifié."
[ ! -e "$NGINX_AVAILABLE" ] && [ ! -e "$NGINX_ENABLED" ] \
    || fail "une configuration Nginx existe déjà pour $DOMAIN. Rien n'a été modifié."
if grep -rlsF "$DOMAIN" /etc/nginx/sites-enabled /etc/nginx/conf.d >/dev/null 2>&1; then
    fail "$DOMAIN est déjà déclaré dans la configuration Nginx. Rien n'a été modifié."
fi
ok "aucune configuration existante pour $DOMAIN"

for cmd in nginx mysql composer openssl; do
    command -v "$cmd" >/dev/null 2>&1 || fail "commande '$cmd' introuvable sur le serveur."
done

PHP_BIN=""; PHP_SOCK=""; PHP_V=""
CLI_V="$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;' 2>/dev/null || true)"
for v in "$CLI_V" 8.5 8.4 8.3 8.2; do
    [ -n "$v" ] || continue
    if [ -S "/run/php/php$v-fpm.sock" ] && command -v "php$v" >/dev/null 2>&1 \
       && "php$v" -r 'exit(version_compare(PHP_VERSION,"8.2.0",">=")?0:1);'; then
        PHP_V="$v"; PHP_BIN="$(command -v "php$v")"; PHP_SOCK="/run/php/php$v-fpm.sock"; break
    fi
done
[ -n "$PHP_SOCK" ] || fail "aucun PHP-FPM 8.2+ trouvé dans /run/php (requis par Laravel 12)."
ok "PHP $PHP_V ($PHP_SOCK)"

WEB_USER="$(grep -hE '^\s*user\s*=' "/etc/php/$PHP_V/fpm/pool.d/www.conf" 2>/dev/null | head -n1 | cut -d= -f2 | tr -d ' ' || true)"
WEB_USER="${WEB_USER:-www-data}"
id "$WEB_USER" >/dev/null 2>&1 || fail "utilisateur web '$WEB_USER' introuvable."
ok "utilisateur web : $WEB_USER"

if ! mysql -uroot -e "SELECT 1" >/dev/null 2>&1; then
    read -rsp "Mot de passe root MySQL : " MYSQL_ROOT_PW; echo
    export MYSQL_PWD="$MYSQL_ROOT_PW"
    mysql -uroot -e "SELECT 1" >/dev/null 2>&1 || fail "connexion MySQL root impossible."
fi
[ -z "$(mysql -uroot -Nse "SHOW DATABASES LIKE '$DB_NAME'")" ] \
    || fail "la base MySQL '$DB_NAME' existe déjà. Rien n'a été modifié."
[ "$(mysql -uroot -Nse "SELECT COUNT(*) FROM mysql.user WHERE user='$DB_USER'")" = "0" ] \
    || fail "l'utilisateur MySQL '$DB_USER' existe déjà. Rien n'a été modifié."
ok "base '$DB_NAME' et utilisateur '$DB_USER' disponibles"

# ---------------------------------------------------------------------------
step "2/8 Informations à saisir"
# ---------------------------------------------------------------------------
read -rp  "Identifiant de l'espace Direction : " DIR_LOGIN
read -rsp "Mot de passe de l'espace Direction : " DIR_PASS; echo
[ -n "$DIR_LOGIN" ] && [ -n "$DIR_PASS" ] || fail "identifiant et mot de passe Direction obligatoires."
read -rp  "Email pour le certificat HTTPS (laisser vide si Certbot est déjà configuré) : " LE_EMAIL

DB_PASS="$(openssl rand -hex 16)"
FACT_PASS="$(openssl rand -hex 6)"
COMM_PASS="$(openssl rand -hex 6)"

env_quote() {
    if [[ "$1" =~ ^[A-Za-z0-9._@:/+-]*$ ]]; then printf '%s' "$1"
    elif [[ "$1" != *"'"* ]]; then printf "'%s'" "$1"
    else fail "le caractère ' n'est pas accepté dans les valeurs du .env."
    fi
}
set_env() {
    local val; val="$(env_quote "$2")"
    K="$1" V="$val" awk 'BEGIN{k=ENVIRON["K"];v=ENVIRON["V"];f=0}
        index($0,k"=")==1{print k"="v;f=1;next}{print}
        END{if(!f)print k"="v}' .env > .env.tmp
    cat .env.tmp > .env && rm -f .env.tmp
}
artisan_web() { sudo -u "$WEB_USER" "$PHP_BIN" artisan "$@"; }

# ---------------------------------------------------------------------------
step "3/8 Dépendances PHP (composer)"
# ---------------------------------------------------------------------------
COMPOSER_ALLOW_SUPERUSER=1 "$PHP_BIN" "$(command -v composer)" install \
    --no-dev --optimize-autoloader --no-interaction
ok "dépendances installées"

# ---------------------------------------------------------------------------
step "4/8 Base de données MySQL dédiée"
# ---------------------------------------------------------------------------
mysql -uroot <<SQL
CREATE DATABASE \`$DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
SQL
unset MYSQL_PWD
ok "base '$DB_NAME' créée (accès limité à cette base)"

# ---------------------------------------------------------------------------
step "5/8 Fichier .env de production"
# ---------------------------------------------------------------------------
cp .env.example .env
set_env APP_ENV production
set_env APP_DEBUG false
set_env APP_URL "http://$DOMAIN"
set_env LOG_LEVEL error
set_env DB_CONNECTION mysql
set_env DB_HOST 127.0.0.1
set_env DB_PORT 3306
set_env DB_DATABASE "$DB_NAME"
set_env DB_USERNAME "$DB_USER"
set_env DB_PASSWORD "$DB_PASS"
set_env SPACE_DIRECTION_LOGIN "$DIR_LOGIN"
set_env SPACE_DIRECTION_PASSWORD "$DIR_PASS"
set_env SPACE_FACTURATION_LOGIN Facturation
set_env SPACE_FACTURATION_PASSWORD "$FACT_PASS"
set_env SPACE_COMMERCIAL_LOGIN Commercial
set_env SPACE_COMMERCIAL_PASSWORD "$COMM_PASS"
chown root:"$WEB_USER" .env
chmod 640 .env
"$PHP_BIN" artisan key:generate --force
ok ".env créé (lisible uniquement par root et $WEB_USER)"

# ---------------------------------------------------------------------------
step "6/8 Laravel : tables, droits, caches"
# ---------------------------------------------------------------------------
"$PHP_BIN" artisan migrate --force
"$PHP_BIN" artisan storage:link || true
chown -R "$WEB_USER":"$WEB_USER" storage bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache
artisan_web config:cache
artisan_web route:cache
artisan_web view:cache
ok "application prête"

# ---------------------------------------------------------------------------
step "7/8 Nginx : site $DOMAIN (les autres sites ne sont pas modifiés)"
# ---------------------------------------------------------------------------
sed -e "s|__DOMAIN__|$DOMAIN|g" -e "s|__APP_DIR__|$APP_DIR|g" -e "s|__PHP_SOCK__|$PHP_SOCK|g" \
    deploy/a2spr/nginx.conf > "$NGINX_AVAILABLE"
if [ ! -f /etc/nginx/snippets/fastcgi-php.conf ]; then
    sed -i 's|include snippets/fastcgi-php.conf;|include fastcgi_params;|' "$NGINX_AVAILABLE"
fi
ln -s "$NGINX_AVAILABLE" "$NGINX_ENABLED"
if ! nginx -t; then
    rm -f "$NGINX_ENABLED" "$NGINX_AVAILABLE"
    fail "Nginx a refusé la configuration : elle a été retirée, Nginx n'a pas été rechargé."
fi
systemctl reload nginx
ok "site actif en HTTP"

# ---------------------------------------------------------------------------
step "8/8 HTTPS (Let's Encrypt)"
# ---------------------------------------------------------------------------
HTTPS=0
if command -v certbot >/dev/null 2>&1; then
    CERT_ARGS=(--nginx -d "$DOMAIN" --redirect --non-interactive --agree-tos)
    [ -n "$LE_EMAIL" ] && CERT_ARGS+=(-m "$LE_EMAIL")
    if certbot "${CERT_ARGS[@]}"; then HTTPS=1; fi
fi
if [ "$HTTPS" = 1 ]; then
    set_env APP_URL "https://$DOMAIN"
    set_env SESSION_SECURE_COOKIE true
    artisan_web config:cache
    ok "HTTPS actif"
else
    printf '\033[1;31m    ✘ HTTPS non activé. Relancez : sudo certbot --nginx -d %s --redirect\033[0m\n' "$DOMAIN"
fi

PROTO=http; [ "$HTTPS" = 1 ] && PROTO=https
cat <<EOF

=====================================================================
 Installation terminée : $PROTO://$DOMAIN
---------------------------------------------------------------------
 Espace Direction   : identifiant saisi ci-dessus
 Espace Facturation : Facturation / $FACT_PASS
 Espace Commercial  : Commercial  / $COMM_PASS
 (notez ces mots de passe ; ils sont aussi dans $APP_DIR/.env)
---------------------------------------------------------------------
 Vérification : $PROTO://$DOMAIN/.env doit renvoyer 403 ou 404
 Mises à jour : sudo bash $APP_DIR/deploy/a2spr/update.sh
=====================================================================
EOF
