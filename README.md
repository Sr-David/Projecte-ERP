<div align="center">
  <img src="https://github.com/user-attachments/assets/59f7dbfd-bd9e-4020-9528-38c0805a0eae" alt="Elevate CRM Logo" width="400px">
  <h1>Elevate CRM</h1>
  <p>Sistema de gestión de relaciones con clientes para empresas modernas</p>
  
  <div>
    <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 10">
    <img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
    <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  </div>
</div>

## 📋 Descripción

Elevate CRM es un sistema completo de gestión de relaciones con clientes diseñado para optimizar procesos de ventas, seguimiento de proyectos y facturación. Proporciona una interfaz moderna y elegante con todas las herramientas necesarias para la gestión eficiente de tu negocio.

### ✨ Características Principales

- **Dashboard Interactivo**: Visualiza KPIs y métricas importantes de tu negocio
- **Gestión de Clientes**: Mantén registros detallados de tus clientes y sus interacciones
- **Seguimiento de Proyectos**: Administra proyectos, tareas y plazos
- **Facturación**: Genera facturas y realiza seguimiento de pagos
- **Informes**: Analiza el rendimiento de tu negocio con informes detallados
- **Diseño Responsivo**: Funciona perfectamente en dispositivos móviles y de escritorio

## 🖼️ Capturas de Pantalla

<div align="center">
  <p>Dashboard y panel de control</p>
  <img src= "https://github.com/user-attachments/assets/d9b9f47f-0823-4e29-89e5-6b9020d220b0" >
  
  <p>Página de login</p>
  <img src= "https://github.com/user-attachments/assets/c947cb19-74e5-47db-9647-b76ec31ead5c" >

  <p>Main</p>
  <img src= "https://github.com/user-attachments/assets/4779fdb3-6425-4dc2-bddf-6aed15beed9b" >


</div>

## 🔧 Instalación

### Requisitos Previos

- Docker y Docker Compose
- Git

### Pasos para Iniciar el Proyecto

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tuusuario/Projecte-ERP.git
   cd Projecte-ERP
   ```

2. Construye las imágenes de los contenedores:
   ```bash
   docker compose build
   ```

3. Levanta los contenedores:
   ```bash
   docker compose up -d
   ```

### Configuración de la Base de Datos

1. Copia el archivo SQL dentro del contenedor:
   ```bash
   docker cp .\dump-erp_crm.sql crm-erp-BD:/dump.sql
   ```

2. Accede al contenedor de la base de datos:
   ```bash
   docker exec -it crm-erp-BD bash
   ```

3. Importa la estructura de la base de datos:
   ```bash
   mysql -u root -p laravel < /dump.sql
   ```
   (Usa la contraseña definida en el archivo `docker-compose.yml`)

### Configuración Final

1. Accede al contenedor de Laravel:
   ```bash
   docker exec -it laravel_app bash
   ```

2. Configura los permisos:
   ```bash
   chmod -R 775 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

3. Sal del contenedor:
   ```bash
   exit
   ```

## 🚀 Uso

Una vez completada la instalación, puedes acceder a la aplicación a través de:
- **URL:** http://localhost:8000
- **Login:** http://localhost:8000/login

## 🛠️ Tecnologías Utilizadas

- **Backend**: 
  - Laravel 10.x (PHP 8.2)
  - MySQL 8.0
  
- **Frontend**: 
  - HTML5, CSS3, JavaScript
  - Tailwind CSS
  - Componentes interactivos

- **Infraestructura**: 
  - Docker
  - Nginx

## 📁 Estructura del Proyecto

```
Projecte-ERP/
├── Laravel/           # Código fuente de la aplicación Laravel
│   ├── app/           # Controladores, modelos y lógica de negocio
│   ├── resources/     # Vistas y assets frontend
│   └── ...
├── docker/            # Configuración de contenedores Docker
├── dump-erp_crm.sql   # Estructura inicial de la base de datos
└── docker-compose.yml # Configuración de servicios
```

## 📄 Licencia

Este proyecto está bajo la Licencia MIT - consulta el archivo [LICENSE](LICENSE) para más detalles.

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Para cambios importantes, por favor abre un issue primero para discutir lo que te gustaría cambiar.

---

<div align="center">
  <p>Desarrollado con ❤️ por Elevate Team</p>
</div>
