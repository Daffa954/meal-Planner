# ==========================================
# TAHAP 1: Merakit Frontend (Node.js & Vite)
# ==========================================
FROM node:20-alpine AS frontend-builder
WORKDIR /app

# Salin file package.json dan install dependency JS
COPY package*.json ./
RUN npm install

# Salin seluruh kode aplikasi
COPY . .

# Jalankan build Vite (menghasilkan folder /public/build)
RUN npm run build


# ==========================================
# TAHAP 2: Merakit Backend & Server (PHP + Nginx)
# ==========================================
FROM php:8.3-fpm-alpine

# Install komponen sistem Linux yang dibutuhkan PHP
RUN apk add --no-cache nginx libpng-dev libxml2-dev zip unzip git curl oniguruma-dev libzip-dev
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Ambil Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Salin seluruh kode backend
COPY . .

# Install dependency PHP
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

# MAGIC TRICK: Ambil hasil build Vite dari TAHAP 1 dan masukkan ke TAHAP 2
COPY --from=frontend-builder /app/public/build /var/www/public/build

# Atur hak akses agar Laravel bisa menulis log & cache
RUN chown -R www-data:www-data /var/www/storage /var/www/cache

# Salin konfigurasi Nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Buka port 80
EXPOSE 80

# Jalankan Nginx dan PHP-FPM secara paralel
CMD ["sh", "-c", "nginx && php-fpm"]