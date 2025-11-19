# ---------- Imagen base con PHP 8.2 ----------
FROM php:8.2-fpm

# ---------- Instalar dependencias del sistema ----------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip

# ---------- Extensiones necesarias ----------
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip bcmath

# ---------- Instalar Composer ----------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ---------- Copiar proyecto ----------
WORKDIR /var/www/html
COPY . .

# ---------- Instalar dependencias PHP ----------
RUN composer install --no-dev --optimize-autoloader

# ---------- Instalar Node + Compilar assets ----------
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build || true

# ---------- Permisos para Laravel ----------
RUN chmod -R 775 storage bootstrap/cache

# ---------- Puerto ----------
EXPOSE 8000

# ---------- Comando de inicio ----------
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
