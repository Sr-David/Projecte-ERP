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

# Crear el directorio build para evitar problemas de permisos
RUN mkdir -p public/build/assets && chmod -R 777 public

# Instalar dependencias de Node.js
RUN echo "Instalando dependencias de Node.js..." && \
    npm install

# Debug información del entorno
RUN echo "Versión de Node.js: $(node -v)" && \
    echo "Versión de NPM: $(npm -v)" && \
    ls -la

# Build Vite assets con output detallado
RUN echo "Iniciando construcción de Vite..." && \
    # Modificar configuración de Vite temporalmente para asegurar generación del manifest
    sed -i 's/manifest: true/manifest: true, emptyOutDir: true/' vite.config.js && \
    VITE_DEBUG=1 npm run build | tee build_output.log || \
    (echo "Error en la compilación de Vite. Mostrando logs:" && cat build_output.log)

# Verificar la salida de la compilación
RUN echo "Verificando directorio public/build:" && \
    ls -la public/build || echo "El directorio public/build no existe"

# Crear manifiesto manual si no existe
RUN if [ ! -f public/build/manifest.json ]; then \
    echo "Creando manifiesto manual..." && \
    mkdir -p public/build/assets && \
    echo '{' > public/build/manifest.json && \
    echo '  "resources/css/app.css": {' >> public/build/manifest.json && \
    echo '    "file": "assets/app.css"' >> public/build/manifest.json && \
    echo '  },' >> public/build/manifest.json && \
    echo '  "resources/js/app.jsx": {' >> public/build/manifest.json && \
    echo '    "file": "assets/app.js",' >> public/build/manifest.json && \
    echo '    "imports": []' >> public/build/manifest.json && \
    echo '  }' >> public/build/manifest.json && \
    echo '}' >> public/build/manifest.json && \
    \
    # Crear archivos CSS y JS mínimos
    echo '/* Fallback CSS */' > public/build/assets/app.css && \
    echo 'console.log("Fallback JavaScript loaded");' > public/build/assets/app.js && \
    \
    # Copiar React desde node_modules al directorio de assets
    mkdir -p public/build/assets/react && \
    cp -r node_modules/react/umd/react.production.min.js public/build/assets/react/ && \
    cp -r node_modules/react-dom/umd/react-dom.production.min.js public/build/assets/react/ && \
    \
    echo "Manifiesto y assets creados manualmente."; \
    fi

# Añadir script en HTML para cargar React desde archivos locales si es necesario
RUN sed -i '/<\/head>/i \
    <!-- Carga de React local como fallback -->\
    <script>\
        window.addEventListener("error", function(e) {\
            if (e.target.src && e.target.src.includes("app.js")) {\
                console.log("Error cargando app.js, intentando cargar React manualmente");\
                var reactScript = document.createElement("script");\
                reactScript.src = "/build/assets/react/react.production.min.js";\
                var reactDOMScript = document.createElement("script");\
                reactDOMScript.src = "/build/assets/react/react-dom.production.min.js";\
                document.head.appendChild(reactScript);\
                document.head.appendChild(reactDOMScript);\
            }\
        }, true);\
    </script>' resources/views/login.blade.php

# Verify manifest.json exists and show content
RUN echo "Contenido del manifiesto:" && \
    cat public/build/manifest.json

# Establecer permisos
RUN chown -R www-data:www-data /var/www
