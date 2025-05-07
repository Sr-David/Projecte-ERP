![imagen(1)](https://github.com/user-attachments/assets/5a7dc411-bbd1-473e-8c7f-4aabf5354e38)



🇬🇧 English: ElevateCRM is a cutting-edge Customer Relationship Management (CRM) system designed to streamline business operations, boost customer engagement, and scale effortlessly. With a Dockerized setup, it’s built for developers and businesses who want a robust, secure, and easy-to-deploy solution.
🇪🇸 Español: ElevateCRM es un sistema de gestión de relaciones con clientes (CRM) de última generación, diseñado para optimizar procesos empresariales, mejorar la interacción con los clientes y escalar sin complicaciones. Con una configuración basada en Docker, está pensado para desarrolladores y empresas que buscan una solución robusta, segura y fácil de implementar.

📋 Tabla de Contenidos

Características
Requisitos Previos
Instalación
Paso 1: Construir los Contenedores Docker
Paso 2: Iniciar los Contenedores


Configuración de la Base de Datos
Paso 1: Copiar el Archivo de Volcado
Paso 2: Acceder al Contenedor de la Base de Datos
Paso 3: Importar el Volcado


Configuración Final
Paso 1: Establecer Permisos de Archivos
Paso 2: Salir del Contenedor


Ejecutar la Aplicación
Contribuir
Licencia
Contacto


🌟 Características

Gestión Completa de Clientes: Administra leads, clientes y ventas con una interfaz intuitiva.
Despliegue con Docker: Configuración simplificada para entornos locales y de producción.
Base de Datos MySQL: Estructura preconfigurada para un arranque rápido.
Seguridad Garantizada: Permisos optimizados para aplicaciones basadas en Laravel.
Escalabilidad: Arquitectura preparada para negocios de cualquier tamaño.


🛠️ Requisitos Previos
Antes de empezar, asegúrate de tener lo siguiente:

Docker y Docker Compose instalados (Guía de Instalación).
PowerShell (Windows) o una terminal (Linux/macOS).
Opcional: Un cliente SQL (como MySQL Workbench) para verificar la base de datos manualmente.
Archivos necesarios: docker-compose.yml en la raíz del proyecto y dump-erp_crm.sql para la base de datos.


🚀 Instalación
Clona el repositorio y sigue estos pasos para poner en marcha el proyecto:
git clone https://github.com/your-username/elevate-crm.git
cd elevate-crm

Paso 1: Construir los Contenedores Docker
En la carpeta raíz del proyecto, ejecuta en PowerShell o tu terminal:
docker compose build

Esto construye las imágenes de los servicios (aplicación y base de datos) definidos en docker-compose.yml.
Paso 2: Iniciar los Contenedores
Arranca los contenedores en modo desacoplado:
docker compose up -d

Comprueba que los contenedores estén funcionando:
docker ps

Deberías ver los contenedores crm-erp-BD (base de datos) y laravel_app (aplicación) activos.

🗄️ Configuración de la Base de Datos
Para configurar la estructura de la base de datos, importa el archivo de volcado SQL proporcionado.
Paso 1: Copiar el Archivo de Volcado
Copia el archivo dump-erp_crm.sql al contenedor de la base de datos:
docker cp ./dump-erp_crm.sql crm-erp-BD:/dump.sql

Paso 2: Acceder al Contenedor de la Base de Datos
Entra en la consola del contenedor de la base de datos:
docker exec -it crm-erp-BD bash

Paso 3: Importar el Volcado
Dentro del contenedor, importa el volcado SQL en la base de datos laravel:
mysql -u root -p laravel < /dump.sql

Introduce la contraseña de la base de datos especificada en docker-compose.yml. El proceso suele ser inmediato. Sal del contenedor:
exit


🔧 Configuración Final
Ajusta los permisos de archivos para que la aplicación Laravel funcione correctamente.
Paso 1: Establecer Permisos de Archivos
Accede al contenedor de la aplicación:
docker exec -it laravel_app bash

Configura los permisos para las carpetas storage y bootstrap/cache:
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

Paso 2: Salir del Contenedor
Sal del contenedor:
exit


🌐 Ejecutar la Aplicación
¡ElevateCRM está listo! Accede a la aplicación a través de la URL o puerto definido en docker-compose.yml (por ejemplo, http://localhost:8000).
Para verificar la base de datos, usa un cliente SQL con las credenciales de docker-compose.yml.

🤝 Contribuir
¡Queremos que ElevateCRM sea aún mejor con tu ayuda! Para contribuir:

Haz un fork del repositorio.
Crea una rama para tu funcionalidad: git checkout -b feature/tu-funcionalidad.
Commitea tus cambios: git commit -m "Añade tu funcionalidad".
Sube la rama: git push origin feature/tu-funcionalidad.
Abre un Pull Request.

Asegúrate de seguir los estándares de código del proyecto e incluye pruebas si es necesario.

📜 Licencia
Este proyecto está licenciado bajo la Licencia MIT. Consulta el archivo LICENSE para más detalles.

📬 Contacto
Para dudas, sugerencias o problemas:

Abre un issue en este repositorio.
Contacta con los mantenedores en tu-email@ejemplo.com.

⭐ ¡Si te gusta ElevateCRM, déjanos una estrella en GitHub!
