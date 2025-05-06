# Projecte-ERP
Proyecto CRM para Venta de Coches y Motos
test
ElevateCRM


# Pasos para iniciar el proyecto y los contenedores

Desde esta carpeta ejecutar primeramente el comando en powershell:

    docker compose build

Después de esto, es necesario ejecutar el comando powershell:

    docker compose up -d

En este paso ya se puede probar la conexión A la base de datos. Se crea una conexión con el SGDBDD y se importa el dump-ERP_CRM-xxxx.sql

A continuación 

    docker exec -it laravel_app bash
    
    chmod -R 775 storage bootstrap/cache
    
    chown -R www-data:www-data storage bootstrap/cache
    
    exit

