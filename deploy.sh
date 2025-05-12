#!/bin/bash

# Este script debe ejecutarse en el servidor de producción

# Parar y eliminar contenedores existentes
echo "Parando contenedores existentes..."
docker-compose down

# Actualizar el código desde el repositorio
echo "Actualizando código desde el repositorio..."
git pull

# Limpieza previa
echo "Limpiando caché y archivos antiguos..."
rm -rf Laravel/bootstrap/cache/*.php
rm -rf Laravel/public/build

# Reconstruir y reiniciar los contenedores
echo "Reconstruyendo contenedores..."
docker-compose build app
docker-compose up -d

# Verificar que los assets se han compilado correctamente
echo "Verificando la existencia del manifiesto de Vite..."
sleep 10 # Esperar a que el contenedor esté completamente iniciado

# Comprobar si el manifiesto existe en el contenedor
docker-compose exec app ls -la /var/www/public/build/manifest.json || {
  echo "ERROR: No se encontró el manifiesto de Vite. Compilando manualmente..."
  docker-compose exec app npm run build
  
  # Verificar de nuevo
  docker-compose exec app ls -la /var/www/public/build/manifest.json || {
    echo "ERROR CRÍTICO: No se pudo generar el manifiesto de Vite después de intentos manuales."
    exit 1
  }
}

echo "Despliegue completado con éxito. El sistema está disponible en http://SERVER_IP:8000/login" 