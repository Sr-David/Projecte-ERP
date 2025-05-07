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

# Como cargar la estructura de la base de datos

Para cargar la estructura de la base de datos se utiliza el archivo dump-erp_crm.sql. 
Primeramente se copia el archivo dentro del contenedor de la base de datos

    docker cp .\dump-erp_crm.sql crm-erp-BD:/dump.sql

A continuación entramos en la linea de comandos interna del contenedor

    docker exec -it crm-erp-BD bash

Ahora nos disponemos a ejecutar el dump en la base de datos

    mysql -u root -p laravel < /dump.sql

Solo hay que introducir la contraseña del docker-compose y esperar a que se cargue el proceso (suele ser inmediato)

# Ultimos pasos


A continuación se realizan los ultimos retoques para que los permisos permitan al contenedor funcionar como debe

    docker exec -it laravel_app bash

Asignamos permisos
    
    chmod -R 775 storage bootstrap/cache
    
Ahora la siguiente comanda

    chown -R www-data:www-data storage bootstrap/cache

Ya podemos salir

    exit


Después de estos pasos ya se puede trabajar con el proyecto. 
