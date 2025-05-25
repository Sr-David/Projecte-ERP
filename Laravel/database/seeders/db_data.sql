-- Datos para la tabla UserAdministration (Empresas)
INSERT INTO `UserAdministration` (`idEmpresa`, `Name`, `Username`, `Password`, `Permissions`) VALUES
(1, 'Empresa Principal', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '{"admin":true}'),
(2, 'Empresa Secundaria', 'admin2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '{"admin":true}'),
(3, 'Empresa Demo', 'demo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '{"admin":true}');

-- Datos para la tabla Users
INSERT INTO `Users` (`idUser`, `Name`, `Username`, `Password`, `Permissions`, `idEmpresa`) VALUES
(1, 'Usuario Normal', 'user1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '{"clientes":{"ver":true,"crear":true,"editar":true,"borrar":true},"proyectos":{"ver":true,"crear":true,"editar":true,"borrar":true},"productos":{"ver":true,"crear":true,"editar":true,"borrar":true},"ventas":{"ver":true,"crear":true,"editar":true,"borrar":true},"reportes":{"ver":true},"notas":{"ver":true,"crear":true,"editar":true,"borrar":true},"leads":{"ver":true,"crear":true,"editar":true,"borrar":true}}', 1),
(2, 'Usuario Ventas', 'sales1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '{"clientes":{"ver":true,"crear":true,"editar":false,"borrar":false},"ventas":{"ver":true,"crear":true,"editar":true,"borrar":false}}', 1),
(3, 'Usuario Proyectos', 'project1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '{"proyectos":{"ver":true,"crear":true,"editar":true,"borrar":true},"notas":{"ver":true,"crear":true,"editar":true,"borrar":true}}', 1),
(4, 'Usuario Emp2', 'user2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '{"clientes":{"ver":true,"crear":true,"editar":true,"borrar":true},"proyectos":{"ver":true,"crear":true,"editar":true,"borrar":true}}', 2),
(5, 'Usuario Demo', 'userdemo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '{"clientes":{"ver":true,"crear":true,"editar":true,"borrar":true},"proyectos":{"ver":true,"crear":true,"editar":true,"borrar":true},"productos":{"ver":true,"crear":true,"editar":true,"borrar":true},"ventas":{"ver":true,"crear":true,"editar":true,"borrar":true},"reportes":{"ver":true},"notas":{"ver":true,"crear":true,"editar":true,"borrar":true},"leads":{"ver":true,"crear":true,"editar":true,"borrar":true}}', 3);

-- Datos para la tabla ClientType
INSERT INTO `ClientType` (`idClientType`, `ClientType`, `Description`, `idEmpresa`) VALUES
(1, 'Cliente Regular', 'Clientes habituales con compras recurrentes', 1),
(2, 'Cliente Premium', 'Clientes con beneficios especiales y atención prioritaria', 1),
(3, 'Cliente Corporativo', 'Empresas y organizaciones', 1),
(4, 'Cliente Ocasional', 'Clientes con compras esporádicas', 1),
(5, 'Cliente VIP', 'Clientes más importantes con trato preferencial', 2),
(6, 'Cliente Estándar', 'Clientes habituales', 2),
(7, 'Cliente Demo', 'Clientes de demostración', 3),
(8, 'Cliente Demo Premium', 'Clientes premium de demostración', 3);

-- Datos para la tabla Clients
INSERT INTO `Clients` (`idClient`, `Name`, `LastName`, `Email`, `Phone`, `Address`, `ClientTypeID`, `idEmpresa`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'María', 'López', 'maria.lopez@ejemplo.com', '612345678', 'Calle Principal 123', 1, 1, '2025-01-15 10:30:00', '2025-01-15 10:30:00'),
(2, 'Juan', 'García', 'juan.garcia@ejemplo.com', '623456789', 'Avenida Central 456', 2, 1, '2025-02-10 14:20:00', '2025-02-10 14:20:00'),
(3, 'Empresa ABC', 'S.L.', 'contacto@empresaabc.com', '912345678', 'Polígono Industrial 78', 3, 1, '2025-02-20 09:15:00', '2025-03-05 11:30:00'),
(4, 'Pedro', 'Martínez', 'pedro.martinez@ejemplo.com', '634567890', 'Plaza Mayor 23', 1, 1, '2025-03-05 16:45:00', '2025-03-05 16:45:00'),
(5, 'Laura', 'Sánchez', 'laura.sanchez@ejemplo.com', '645678901', 'Calle Nueva 89', 2, 1, '2025-03-10 11:20:00', '2025-03-10 11:20:00'),
(6, 'Carlos', 'Jiménez', 'carlos.jimenez@ejemplo.com', '656789012', 'Avenida Norte 12', 1, 1, '2025-04-02 13:40:00', '2025-04-02 13:40:00'),
(7, 'Ana', 'Rodríguez', 'ana.rodriguez@ejemplo.com', '667890123', 'Calle Sur 45', 1, 1, '2025-04-15 10:10:00', '2025-04-15 10:10:00'),
(8, 'Miguel', 'Fernández', 'miguel.fernandez@ejemplo.com', '678901234', 'Paseo del Parque 7', 4, 1, '2025-04-20 17:30:00', '2025-04-20 17:30:00'),
(9, 'Consultora XYZ', 'Inc.', 'info@consultoraxyz.com', '914567890', 'Calle Comercial 34', 3, 1, '2025-05-03 09:30:00', '2025-05-03 09:30:00'),
(10, 'Lucía', 'Gómez', 'lucia.gomez@ejemplo.com', '689012345', 'Avenida Principal 56', 2, 1, '2025-05-10 14:50:00', '2025-05-10 14:50:00'),
(11, 'Roberto', 'Díaz', 'roberto.diaz@ejemplo.com', '690123456', 'Calle Ancha 78', 5, 2, '2025-03-15 12:20:00', '2025-03-15 12:20:00'),
(12, 'Elena', 'Torres', 'elena.torres@ejemplo.com', '601234567', 'Avenida Este 90', 6, 2, '2025-04-05 11:15:00', '2025-04-05 11:15:00'),
(13, 'Cliente', 'Demo', 'cliente.demo@ejemplo.com', '600000001', 'Calle Demo 1', 7, 3, '2025-05-01 10:00:00', '2025-05-01 10:00:00'),
(14, 'Empresa', 'Demo', 'empresa.demo@ejemplo.com', '600000002', 'Avenida Demo 2', 8, 3, '2025-05-05 11:30:00', '2025-05-05 11:30:00');

-- Datos para la tabla Leads
INSERT INTO `Leads` (`idLead`, `Name`, `LastName`, `Email`, `Phone`, `Address`, `ClientTypeID`, `Source`, `Status`, `Notes`, `CreatedAt`, `UpdatedAt`, `AssignedToID`, `idEmpresa`) VALUES
(1, 'Javier', 'Ruiz', 'javier.ruiz@ejemplo.com', '612345679', 'Calle Azul 34', 1, 'Formulario Web', 'New', 'Interesado en servicios de desarrollo web', '2025-05-01 08:30:00', '2025-05-01 08:30:00', 1, 1),
(2, 'Marta', 'Herrera', 'marta.herrera@ejemplo.com', '623456780', 'Avenida del Sol 56', 2, 'Referido', 'In Progress', 'Solicita presupuesto para proyecto de comercio electrónico', '2025-05-05 14:45:00', '2025-05-07 10:20:00', 1, 1),
(3, 'Distribuidora PQR', 'S.A.', 'contacto@distribuidorapqr.com', '913456789', 'Calle Industrial 78', 3, 'LinkedIn', 'Qualified', 'Busca renovar su plataforma tecnológica', '2025-05-08 11:30:00', '2025-05-10 09:15:00', 1, 1),
(4, 'Daniel', 'Navarro', 'daniel.navarro@ejemplo.com', '634567891', 'Plaza del Centro 12', 1, 'Conferencia', 'New', 'Interesado en app móvil', '2025-05-12 16:00:00', '2025-05-12 16:00:00', 1, 1),
(5, 'Sofía', 'Castro', 'sofia.castro@ejemplo.com', '645678902', 'Calle Mayor 45', 2, 'Formulario Web', 'In Progress', 'Necesita sistema de gestión de inventario', '2025-05-15 10:30:00', '2025-05-17 14:20:00', 1, 1),
(6, 'Alejandro', 'Morales', 'alejandro.morales@ejemplo.com', '656789013', 'Avenida Central 67', null, 'Feria Comercial', 'New', 'Interesado en servicios de consultoría', '2025-05-18 13:40:00', '2025-05-18 13:40:00', 2, 2);

-- Datos para la tabla Projects
INSERT INTO `Projects` (`idProject`, `Name`, `Description`, `ClientID`, `StartDate`, `EndDate`, `Status`, `Budget`, `BillingType`, `Notes`, `idEmpresa`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'Desarrollo Web Corporativa', 'Creación de sitio web corporativo con sección de blog y catálogo de productos', 1, '2025-01-20', '2025-03-15', 'Completed', 3500.00, 'Fixed', 'Proyecto finalizado satisfactoriamente', 1, '2025-01-15 10:30:00', '2025-03-15 16:00:00'),
(2, 'App Móvil de Fidelización', 'Desarrollo de aplicación móvil para programa de fidelización de clientes', 2, '2025-02-15', '2025-06-30', 'In Progress', 8000.00, 'Fixed', 'Fase de desarrollo en curso', 1, '2025-02-10 14:20:00', '2025-05-05 11:30:00'),
(3, 'Sistema de Gestión ERP', 'Implementación de sistema ERP personalizado para gestión de recursos', 3, '2025-03-01', '2025-08-15', 'In Progress', 12000.00, 'Hourly', 'Primera fase completada, desarrollo de módulos avanzados en curso', 1, '2025-02-25 09:15:00', '2025-05-10 14:45:00'),
(4, 'Rediseño de Tienda Online', 'Actualización y mejora de la tienda online existente', 5, '2025-04-01', '2025-05-15', 'Completed', 2500.00, 'Fixed', 'Entregado con mejoras adicionales', 1, '2025-03-25 13:40:00', '2025-05-15 17:20:00'),
(5, 'Consultoría SEO', 'Optimización de posicionamiento en buscadores', 7, '2025-04-20', '2025-06-20', 'In Progress', 1800.00, 'Hourly', 'Auditoría inicial completada', 1, '2025-04-15 10:10:00', '2025-05-05 14:30:00'),
(6, 'Campaña de Marketing Digital', 'Diseño y ejecución de estrategia de marketing en redes sociales', 9, '2025-05-10', '2025-07-31', 'Pending', 3500.00, 'Fixed', 'En espera de aprobación de materiales', 1, '2025-05-03 09:30:00', '2025-05-20 11:45:00'),
(7, 'Portal Intranet', 'Desarrollo de portal intranet para comunicación interna', 11, '2025-04-01', '2025-06-30', 'In Progress', 4500.00, 'Fixed', 'Desarrollo de módulos de comunicación en curso', 2, '2025-03-15 12:20:00', '2025-05-10 15:30:00'),
(8, 'Proyecto Demo 1', 'Proyecto de demostración con funcionalidades básicas', 13, '2025-05-02', '2025-07-15', 'In Progress', 2000.00, 'Fixed', 'Proyecto demo para pruebas', 3, '2025-05-01 12:00:00', '2025-05-10 09:00:00'),
(9, 'Proyecto Demo 2', 'Proyecto de demostración avanzado', 14, '2025-05-10', '2025-09-30', 'Pending', 5000.00, 'Hourly', 'Pendiente de iniciar', 3, '2025-05-05 14:30:00', '2025-05-05 14:30:00');

-- Datos para la tabla ProductsServices
INSERT INTO `ProductsServices` (`idProductService`, `Name`, `Description`, `Price`, `Stock`, `EntryDate`, `idEmpresa`) VALUES
(1, 'Desarrollo Web Básico', 'Sitio web informativo de hasta 5 páginas', 800.00, 999, '2025-01-10 08:00:00', 1),
(2, 'Desarrollo Web Premium', 'Sitio web avanzado con CMS y funcionalidades personalizadas', 2500.00, 999, '2025-01-10 08:05:00', 1),
(3, 'Aplicación Móvil', 'Desarrollo de aplicación para iOS y Android', 5000.00, 999, '2025-01-10 08:10:00', 1),
(4, 'Mantenimiento Web Mensual', 'Servicio de mantenimiento y actualización mensual', 120.00, 999, '2025-01-10 08:15:00', 1),
(5, 'Consultoría Tecnológica', 'Servicio de asesoramiento tecnológico (precio por hora)', 90.00, 999, '2025-01-10 08:20:00', 1),
(6, 'Diseño Gráfico', 'Servicio de diseño gráfico para materiales promocionales', 75.00, 999, '2025-01-10 08:25:00', 1),
(7, 'Hosting Premium', 'Servicio de alojamiento web anual', 150.00, 50, '2025-01-10 08:30:00', 1),
(8, 'Dominio .com', 'Registro de dominio .com por un año', 15.00, 100, '2025-01-10 08:35:00', 1),
(9, 'Certificado SSL', 'Certificado de seguridad para sitio web', 50.00, 80, '2025-01-10 08:40:00', 1),
(10, 'Optimización SEO Básica', 'Paquete básico de optimización para buscadores', 300.00, 999, '2025-01-10 08:45:00', 1),
(11, 'Desarrollo Web Corporativo', 'Sitio web empresarial con múltiples funcionalidades', 3000.00, 999, '2025-01-15 09:00:00', 2),
(12, 'Servicio de Email Marketing', 'Gestión de campañas de email marketing', 200.00, 999, '2025-01-15 09:05:00', 2),
(13, 'Servicio Demo 1', 'Servicio de demostración básico', 500.00, 999, '2025-05-01 09:00:00', 3),
(14, 'Servicio Demo 2', 'Servicio de demostración premium', 1500.00, 999, '2025-05-01 09:15:00', 3);

-- Datos para la tabla SalesProposals
INSERT INTO `SalesProposals` (`idSalesProposals`, `ClientID`, `CreatedAt`, `State`, `Details`, `idEmpresa`) VALUES
(1, 1, '2025-01-17 10:30:00', 'completed', 'Propuesta para desarrollo de sitio web corporativo', 1),
(2, 2, '2025-02-12 14:20:00', 'completed', 'Propuesta para app móvil de fidelización', 1),
(3, 3, '2025-02-27 09:15:00', 'completed', 'Propuesta para implementación de sistema ERP', 1),
(4, 4, '2025-03-10 16:45:00', 'pending', 'Propuesta para servicio de mantenimiento web', 1),
(5, 5, '2025-03-27 13:40:00', 'completed', 'Propuesta para rediseño de tienda online', 1),
(6, 7, '2025-04-17 10:10:00', 'completed', 'Propuesta para consultoría SEO', 1),
(7, 8, '2025-04-22 17:30:00', 'pending', 'Propuesta para diseño de materiales promocionales', 1),
(8, 9, '2025-05-05 09:30:00', 'pending', 'Propuesta para campaña de marketing digital', 1),
(9, 11, '2025-03-20 12:20:00', 'completed', 'Propuesta para desarrollo de portal intranet', 2),
(10, 13, '2025-05-03 10:00:00', 'completed', 'Propuesta demo completada', 3),
(11, 14, '2025-05-08 11:00:00', 'pending', 'Propuesta demo pendiente', 3);

-- Datos para la tabla SalesDetails
INSERT INTO `SalesDetails` (`idSaleDetail`, `ProposalID`, `ProductServiceID`, `QuantitySold`, `UnitPrice`, `idEmpresa`, `created_at`) VALUES
(1, 1, 2, 1, 2500.00, 1, '2025-01-17 10:35:00'),
(2, 1, 7, 1, 150.00, 1, '2025-01-17 10:35:00'),
(3, 1, 8, 1, 15.00, 1, '2025-01-17 10:35:00'),
(4, 2, 3, 1, 5000.00, 1, '2025-02-12 14:25:00'),
(5, 3, 5, 20, 90.00, 1, '2025-02-27 09:20:00'),
(6, 5, 2, 1, 2500.00, 1, '2025-03-27 13:45:00'),
(7, 6, 10, 1, 300.00, 1, '2025-04-17 10:15:00'),
(8, 6, 5, 15, 90.00, 1, '2025-04-17 10:15:00'),
(9, 9, 11, 1, 3000.00, 2, '2025-03-20 12:25:00'),
(10, 10, 13, 1, 500.00, 3, '2025-05-03 10:15:00'),
(11, 10, 14, 1, 1500.00, 3, '2025-05-03 10:15:00');

-- Datos para la tabla Notes
INSERT INTO `Notes` (`idNote`, `Title`, `Content`, `RelatedTo`, `RelatedID`, `CreatedBy`, `idEmpresa`, `created_at`, `updated_at`) VALUES
(1, 'Reunión inicial proyecto web', 'Notas de la reunión inicial con el cliente. Se definieron los requisitos principales del sitio.', 'project', 1, 1, 1, '2025-01-20 11:30:00', '2025-01-20 11:30:00'),
(2, 'Seguimiento app móvil', 'El cliente solicita incluir funcionalidad de notificaciones push.', 'project', 2, 1, 1, '2025-03-05 14:45:00', '2025-03-05 14:45:00'),
(3, 'Contacto con María López', 'La cliente está interesada en ampliar servicios.', 'client', 1, 1, 1, '2025-03-10 09:20:00', '2025-03-10 09:20:00'),
(4, 'Problema técnico servidor', 'El servidor presentó problemas de rendimiento. Se requiere investigar.', 'general', null, 1, 1, '2025-04-05 16:30:00', '2025-04-05 16:30:00'),
(5, 'Solicitud de cambios tienda online', 'El cliente solicita modificar la sección de productos destacados.', 'project', 4, 1, 1, '2025-04-25 10:15:00', '2025-04-25 10:15:00'),
(6, 'Seguimiento lead calificado', 'El lead muestra gran interés en nuestros servicios de desarrollo.', 'lead', 3, 1, 1, '2025-05-12 11:45:00', '2025-05-12 11:45:00'),
(7, 'Propuesta comercial enviada', 'Se envió propuesta para el proyecto de marketing. En espera de respuesta.', 'sale', 8, 1, 1, '2025-05-15 15:20:00', '2025-05-15 15:20:00'),
(8, 'Solicitud de información', 'El cliente solicita información sobre servicios de hosting.', 'client', 11, 4, 2, '2025-04-02 14:30:00', '2025-04-02 14:30:00'),
(9, 'Nota demo proyecto', 'Contenido de nota de demostración para proyecto', 'project', 8, 5, 3, '2025-05-03 15:00:00', '2025-05-03 15:00:00'),
(10, 'Nota demo cliente', 'Contenido de nota de demostración para cliente', 'client', 13, 5, 3, '2025-05-04 16:30:00', '2025-05-04 16:30:00'); 