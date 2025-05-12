#!/bin/bash

echo "Parando los contenedores..."
docker-compose down

echo "Eliminando las imágenes anteriores..."
docker rmi $(docker images -q laravel_app) 2>/dev/null || true

echo "Limpiando caché y archivos antiguos..."
rm -rf Laravel/bootstrap/cache/*.php 2>/dev/null || true
rm -rf Laravel/public/build 2>/dev/null || true

echo "Reconstruyendo la imagen de la aplicación..."
docker-compose build app

echo "Iniciando los contenedores..."
docker-compose up -d

echo "Esperando a que los contenedores estén listos..."
sleep 5

echo "Verificando los logs de la aplicación..."
docker-compose logs app | tail -n 50

echo "Verificando el manifiesto de Vite..."
docker-compose exec app cat /var/www/public/build/manifest.json || {
  echo "ADVERTENCIA: No se encontró el manifiesto, pero el contenedor está en ejecución."
  echo "Se usará la versión de fallback."
}

echo "Proceso completado. Ahora puedes acceder a http://localhost:8000/login" 