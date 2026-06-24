#!/usr/bin/env bash
set -e

echo "[boot] Caching config + routes + views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[boot] Running migrations..."
php artisan migrate --force

echo "[boot] Seeding (idempotent — no-op if data already exists)..."
php artisan db:seed --force

echo "[boot] Starting server on port ${PORT:-8000}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
