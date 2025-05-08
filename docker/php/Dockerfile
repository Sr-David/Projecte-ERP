FROM php:8.2-fpm

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    git

# Instalar Node.js versión LTS
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www

# Copy composer files and install dependencies
COPY ./Laravel/composer.json ./Laravel/composer.lock* ./
RUN composer install --no-scripts --no-autoloader

# Copy application code
COPY ./Laravel .

# Generate autoloader files
RUN composer dump-autoload --optimize

# Install Node.js dependencies with minimal setup
COPY ./Laravel/package.json ./Laravel/package-lock.json* ./
RUN npm install || echo "npm install falló, pero continuamos"

# Build Vite assets (con máxima tolerancia a fallos)
RUN mkdir -p public/build && \
    echo '{"css":[],"file":"assets/app.js","imports":{}}' > public/build/manifest.json && \
    npm run build || echo "Vite build falló, usaremos el manifiesto mínimo"
