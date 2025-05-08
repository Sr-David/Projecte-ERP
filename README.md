![imagen(2)(1)](https://github.com/user-attachments/assets/59f7dbfd-bd9e-4020-9528-38c0805a0eae)




# Projecte-ERP
Proyecto CRM para Venta de Coches y Motos
test
ElevateCRM


# Pasos para iniciar el proyecto y los contenedores


1. Abre una línea de comandos en la carpeta raíz del proyecto.
2. Ejecuta el siguiente comando para construir las imágenes de los contenedores:

    docker compose build

3. Una vez construido, levanta los contenedores con el siguiente comando:

    docker compose up -d

4. Si necesitas eliminar los contenedores, utiliza el siguiente comando:

    docker compose down



# Cargar la estructura de la base de datos

Con los contenedores ya creados, sigue estos pasos para cargar la estructura de la base de datos (esto solo es necesario una vez, siempre que no se eliminen los contenedores):

Para cargar la estructura de la base de datos se utiliza el archivo dump-erp_crm.sql. Hay que seguir los siguientes pasos:

1. Primeramente se copia el archivo dentro del contenedor de la base de datos. Este comando se tiene que hacer desde la carpeta raiz

    docker cp .\dump-erp_crm.sql crm-erp-BD:/dump.sql

2. Accede a la línea de comandos interna del contenedor de la base de datos:

    docker exec -it crm-erp-BD bash

3. Ejecuta el dump en la base de datos:

    mysql -u root -p laravel < /dump.sql

4. Introduce la contraseña que se encuentra en el archivo `docker-compose.yml` y espera a que el proceso termine.


# Ultimos pasos


1. Accede al contenedor de la aplicación Laravel:

    docker exec -it laravel_app bash

2. Asigna los permisos necesarios:
    
    chmod -R 775 storage bootstrap/cache
    
3. Ahora la siguiente comanda

    chown -R www-data:www-data storage bootstrap/cache

4. Sal del contenedor:

    exit


Después de estos pasos, el proyecto estará listo para ser utilizado.


## Tecnologías Utilizadas

- **Laravel**: Framework PHP para el desarrollo de aplicaciones web.
- **Docker**: Contenedores para la gestión de servicios.
- **MySQL**: Base de datos relacional.
- **Nginx**: Servidor web.
