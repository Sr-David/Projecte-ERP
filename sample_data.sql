-- Script de carga de datos de prueba para ERP-CRM
-- Todos los datos se vincularán al idEmpresa 3

-- 1. Insertar tipos de cliente
INSERT INTO `ClientType` (`ClientType`, `Description`, `idEmpresa`) VALUES
('Empresa', 'Clientes corporativos y empresas', 3),
('Particular', 'Clientes individuales', 3),
('Autónomo', 'Profesionales independientes', 3),
('Administración Pública', 'Entidades gubernamentales', 3),
('ONG', 'Organizaciones sin ánimo de lucro', 3);

-- 2. Insertar clientes
INSERT INTO `Clients` (`Name`, `LastName`, `Email`, `Phone`, `Address`, `ClientTypeID`, `idEmpresa`, `CreatedAt`) VALUES
('María', 'González', 'maria.gonzalez@empresa.com', '612345678', 'Calle Principal 123, Barcelona', 1, 3, DATE_SUB(NOW(), INTERVAL RAND()*365 DAY)),
('Carlos', 'Martínez', 'carlos.martinez@gmail.com', '623456789', 'Avenida Central 45, Madrid', 2, 3, DATE_SUB(NOW(), INTERVAL RAND()*365 DAY)),
('Tecnologías', 'Avanzadas SL', 'info@tecnoavanzadas.com', '934567890', 'Polígono Industrial Norte 78, Valencia', 1, 3, DATE_SUB(NOW(), INTERVAL RAND()*365 DAY)),
('Ana', 'Sánchez', 'ana.sanchez@autonomo.es', '645678901', 'Plaza Mayor 12, Sevilla', 3, 3, DATE_SUB(NOW(), INTERVAL RAND()*365 DAY)),
('Pedro', 'López', 'pedro.lopez@outlook.com', '656789012', 'Calle Secundaria 34, Bilbao', 2, 3, DATE_SUB(NOW(), INTERVAL RAND()*180 DAY)),
('Distribuciones', 'Rápidas SA', 'contacto@distrapidas.com', '967890123', 'Avenida Industrial 56, Zaragoza', 1, 3, DATE_SUB(NOW(), INTERVAL RAND()*180 DAY)),
('Laura', 'Fernández', 'laura.fernandez@hotmail.com', '678901234', 'Calle Nueva 78, Málaga', 2, 3, DATE_SUB(NOW(), INTERVAL RAND()*180 DAY)),
('Ayuntamiento', 'de Toledo', 'sistemas@aytotoledo.es', '925123456', 'Plaza Consistorial 1, Toledo', 4, 3, DATE_SUB(NOW(), INTERVAL RAND()*90 DAY)),
('Fundación', 'Nuevo Amanecer', 'contacto@nuevoamanecer.org', '910123456', 'Calle Solidaria 23, Madrid', 5, 3, DATE_SUB(NOW(), INTERVAL RAND()*90 DAY)),
('Miguel', 'Torres', 'miguel.torres@gmail.com', '689012345', 'Avenida Principal 67, Alicante', 2, 3, DATE_SUB(NOW(), INTERVAL RAND()*60 DAY)),
('Soluciones', 'Digitales SL', 'info@soldig.com', '932345678', 'Calle Tecnológica 45, Barcelona', 1, 3, DATE_SUB(NOW(), INTERVAL RAND()*60 DAY)),
('Javier', 'Gómez', 'javier.gomez@autonomo.es', '634567890', 'Plaza Central 89, Valencia', 3, 3, DATE_SUB(NOW(), INTERVAL RAND()*30 DAY)),
('Elena', 'Díaz', 'elena.diaz@empresa.com', '645678901', 'Calle Mayor 12, Madrid', 2, 3, DATE_SUB(NOW(), INTERVAL RAND()*30 DAY)),
('Consultores', 'Asociados SA', 'info@consultasoc.com', '911234567', 'Avenida Empresarial 34, Sevilla', 1, 3, DATE_SUB(NOW(), INTERVAL RAND()*15 DAY)),
('Sara', 'Moreno', 'sara.moreno@outlook.com', '678901234', 'Calle Residencial 56, Bilbao', 2, 3, DATE_SUB(NOW(), INTERVAL RAND()*15 DAY));

-- 3. Insertar productos y servicios
INSERT INTO `ProductsServices` (`Name`, `Description`, `Price`, `Stock`, `EntryDate`, `idEmpresa`) VALUES
('Software ERP Básico', 'Licencia básica del software ERP para pequeñas empresas', 1499.99, 50, DATE_SUB(NOW(), INTERVAL RAND()*365 DAY), 3),
('Software ERP Avanzado', 'Licencia avanzada con módulos adicionales', 2999.99, 30, DATE_SUB(NOW(), INTERVAL RAND()*365 DAY), 3),
('Módulo de RRHH', 'Complemento para gestión de recursos humanos', 799.99, 45, DATE_SUB(NOW(), INTERVAL RAND()*300 DAY), 3),
('Módulo de Contabilidad', 'Complemento para gestión contable avanzada', 899.99, 40, DATE_SUB(NOW(), INTERVAL RAND()*300 DAY), 3),
('Módulo de Inventario', 'Complemento para gestión de inventario y almacén', 699.99, 35, DATE_SUB(NOW(), INTERVAL RAND()*250 DAY), 3),
('Servicio de Implementación', 'Servicio de implementación y configuración inicial', 1200.00, 999, DATE_SUB(NOW(), INTERVAL RAND()*250 DAY), 3),
('Formación Básica', 'Paquete de formación básica para usuarios (10 horas)', 500.00, 999, DATE_SUB(NOW(), INTERVAL RAND()*200 DAY), 3),
('Formación Avanzada', 'Paquete de formación avanzada para administradores (20 horas)', 1000.00, 999, DATE_SUB(NOW(), INTERVAL RAND()*200 DAY), 3),
('Soporte Técnico Anual', 'Contrato de soporte técnico por un año', 1500.00, 999, DATE_SUB(NOW(), INTERVAL RAND()*150 DAY), 3),
('Soporte Técnico Premium', 'Contrato de soporte técnico premium con respuesta prioritaria', 2500.00, 999, DATE_SUB(NOW(), INTERVAL RAND()*150 DAY), 3),
('Servicio de Migración de Datos', 'Servicio de migración desde sistemas antiguos', 1800.00, 999, DATE_SUB(NOW(), INTERVAL RAND()*100 DAY), 3),
('Servicio de Consultoría', 'Servicio de consultoría de procesos empresariales', 2000.00, 999, DATE_SUB(NOW(), INTERVAL RAND()*100 DAY), 3),
('Módulo de E-commerce', 'Integración con tiendas online', 1299.99, 25, DATE_SUB(NOW(), INTERVAL RAND()*50 DAY), 3),
('Módulo de CRM', 'Complemento para gestión de relaciones con clientes', 999.99, 30, DATE_SUB(NOW(), INTERVAL RAND()*50 DAY), 3),
('Aplicación Móvil', 'Aplicación móvil para acceso al sistema en dispositivos', 599.99, 100, DATE_SUB(NOW(), INTERVAL RAND()*30 DAY), 3);

-- 4. Insertar leads
INSERT INTO `Leads` (`Name`, `LastName`, `Email`, `Phone`, `Address`, `ClientTypeID`, `Source`, `Status`, `Notes`, `CreatedAt`, `AssignedToID`, `idEmpresa`) VALUES
('Roberto', 'Jiménez', 'roberto.jimenez@empresa.es', '611223344', 'Calle Innovación 12, Madrid', 1, 'Sitio Web', 'New', 'Interesado en el ERP Avanzado', DATE_SUB(NOW(), INTERVAL RAND()*90 DAY), 3, 3),
('Carmen', 'Pérez', 'carmen.perez@gmail.com', '622334455', 'Avenida Principal 34, Barcelona', 2, 'Referencia', 'In Progress', 'Busca una solución para gestionar su negocio', DATE_SUB(NOW(), INTERVAL RAND()*90 DAY), 3, 3),
('Inversiones', 'Futuro SL', 'contacto@inversionesfuturo.com', '933445566', 'Polígono Empresarial 56, Valencia', 1, 'Feria Comercial', 'Qualified', 'Empresa en expansión, necesita sistema completo', DATE_SUB(NOW(), INTERVAL RAND()*60 DAY), 3, 3),
('Alberto', 'García', 'alberto.garcia@hotmail.com', '644556677', 'Plaza Central 78, Sevilla', 3, 'LinkedIn', 'In Progress', 'Autónomo con varios empleados, busca solución escalable', DATE_SUB(NOW(), INTERVAL RAND()*60 DAY), 3, 3),
('Distribuidora', 'Nacional SA', 'info@disnacsa.com', '955667788', 'Avenida Industrial 90, Zaragoza', 1, 'Google', 'New', 'Gran empresa con múltiples sedes', DATE_SUB(NOW(), INTERVAL RAND()*45 DAY), 3, 3),
('Luisa', 'Martín', 'luisa.martin@outlook.com', '666778899', 'Calle Mayor 12, Bilbao', 2, 'Referencia', 'Disqualified', 'Presupuesto limitado, no compatible con nuestras soluciones', DATE_SUB(NOW(), INTERVAL RAND()*45 DAY), 3, 3),
('Hospital', 'San Juan', 'sistemas@hospitalsj.org', '917889900', 'Avenida Salud 34, Madrid', 4, 'Email Marketing', 'Qualified', 'Institución sanitaria que busca optimizar procesos', DATE_SUB(NOW(), INTERVAL RAND()*30 DAY), 3, 3),
('Fundación', 'Educativa', 'contacto@fundedu.org', '928990011', 'Calle Formación 56, Las Palmas', 5, 'Evento', 'In Progress', 'ONG del sector educativo con crecimiento rápido', DATE_SUB(NOW(), INTERVAL RAND()*30 DAY), 3, 3),
('Jorge', 'Sanz', 'jorge.sanz@gmail.com', '677889900', 'Plaza Principal 78, Alicante', 2, 'Facebook', 'New', 'Interesado en módulos específicos', DATE_SUB(NOW(), INTERVAL RAND()*15 DAY), 3, 3),
('Marta', 'López', 'marta.lopez@empresa.com', '688990011', 'Calle Comercial 90, Barcelona', 3, 'Instagram', 'New', 'Busca solución para gestionar clientes', DATE_SUB(NOW(), INTERVAL RAND()*15 DAY), 3, 3);

-- 5. Insertar proyectos
INSERT INTO `Projects` (`Name`, `Description`, `ClientID`, `StartDate`, `EndDate`, `Status`, `Budget`, `BillingType`, `Notes`, `idEmpresa`, `CreatedAt`) VALUES
('Implementación ERP Tecnologías Avanzadas', 'Proyecto de implementación completa del sistema ERP', 3, DATE_SUB(NOW(), INTERVAL 120 DAY), DATE_ADD(NOW(), INTERVAL 60 DAY), 'In Progress', 8500.00, 'Fixed', 'Cliente prioritario con múltiples sedes', 3, DATE_SUB(NOW(), INTERVAL 150 DAY)),
('Migración de datos Distribuciones Rápidas', 'Migración desde sistema legacy a nuevo ERP', 6, DATE_SUB(NOW(), INTERVAL 90 DAY), DATE_SUB(NOW(), INTERVAL 30 DAY), 'Completed', 4200.00, 'Fixed', 'Migración completada con éxito', 3, DATE_SUB(NOW(), INTERVAL 100 DAY)),
('Formación usuarios Ayuntamiento de Toledo', 'Formación para 15 usuarios del departamento de administración', 8, DATE_SUB(NOW(), INTERVAL 45 DAY), DATE_SUB(NOW(), INTERVAL 15 DAY), 'Completed', 3000.00, 'Fixed', 'Se requiere una segunda fase para usuarios avanzados', 3, DATE_SUB(NOW(), INTERVAL 60 DAY)),
('Consultoría procesos Fundación Nuevo Amanecer', 'Análisis y optimización de procesos internos', 9, DATE_SUB(NOW(), INTERVAL 60 DAY), DATE_ADD(NOW(), INTERVAL 30 DAY), 'In Progress', 5000.00, 'Hourly', 'ONG con procesos muy específicos', 3, DATE_SUB(NOW(), INTERVAL 70 DAY)),
('Implementación módulos Soluciones Digitales', 'Implementación de módulos específicos para comercio electrónico', 11, DATE_SUB(NOW(), INTERVAL 30 DAY), DATE_ADD(NOW(), INTERVAL 90 DAY), 'In Progress', 6500.00, 'Fixed', 'Cliente con alto potencial de crecimiento', 3, DATE_SUB(NOW(), INTERVAL 40 DAY)),
('Desarrollo personalizado Consultores Asociados', 'Desarrollo de funcionalidades a medida', 14, DATE_SUB(NOW(), INTERVAL 15 DAY), DATE_ADD(NOW(), INTERVAL 75 DAY), 'In Progress', 12000.00, 'Fixed', 'Requiere integraciones con sistemas externos', 3, DATE_SUB(NOW(), INTERVAL 20 DAY)),
('Soporte técnico anual María González', 'Contrato de soporte técnico para sistema implementado', 1, DATE_SUB(NOW(), INTERVAL 200 DAY), DATE_ADD(NOW(), INTERVAL 165 DAY), 'In Progress', 1500.00, 'Fixed', 'Cliente desde hace más de un año', 3, DATE_SUB(NOW(), INTERVAL 210 DAY)),
('Actualización sistema Ana Sánchez', 'Actualización a la última versión del software', 4, DATE_SUB(NOW(), INTERVAL 10 DAY), DATE_ADD(NOW(), INTERVAL 20 DAY), 'In Progress', 2000.00, 'Fixed', 'Incluye nuevos módulos solicitados', 3, DATE_SUB(NOW(), INTERVAL 15 DAY));

-- 6. Insertar propuestas de venta
INSERT INTO `SalesProposals` (`ClientID`, `CreatedAt`, `State`, `Details`, `idEmpresa`) VALUES
(1, DATE_SUB(NOW(), INTERVAL 340 DAY), 'Completed', 'Venta de licencia ERP Básico con soporte técnico', 3),
(3, DATE_SUB(NOW(), INTERVAL 300 DAY), 'Completed', 'Venta de licencia ERP Avanzado con módulos adicionales', 3),
(6, DATE_SUB(NOW(), INTERVAL 280 DAY), 'Completed', 'Venta de módulos específicos y servicio de implementación', 3),
(8, DATE_SUB(NOW(), INTERVAL 250 DAY), 'Completed', 'Venta de licencias múltiples con formación', 3),
(4, DATE_SUB(NOW(), INTERVAL 220 DAY), 'Completed', 'Venta de licencia básica con soporte anual', 3),
(9, DATE_SUB(NOW(), INTERVAL 200 DAY), 'Completed', 'Venta de licencia con descuento para ONG', 3),
(11, DATE_SUB(NOW(), INTERVAL 180 DAY), 'Completed', 'Venta de sistema completo con personalización', 3),
(2, DATE_SUB(NOW(), INTERVAL 150 DAY), 'Completed', 'Venta de licencia personal con formación básica', 3),
(14, DATE_SUB(NOW(), INTERVAL 120 DAY), 'Completed', 'Venta de licencia avanzada con módulos premium', 3),
(5, DATE_SUB(NOW(), INTERVAL 100 DAY), 'Completed', 'Venta de licencia básica para autónomo', 3),
(12, DATE_SUB(NOW(), INTERVAL 80 DAY), 'Completed', 'Venta de licencia con módulos específicos', 3),
(7, DATE_SUB(NOW(), INTERVAL 60 DAY), 'Completed', 'Venta de actualización de licencia', 3),
(10, DATE_SUB(NOW(), INTERVAL 40 DAY), 'Completed', 'Venta de licencia básica con posibilidad de ampliación', 3),
(13, DATE_SUB(NOW(), INTERVAL 20 DAY), 'Completed', 'Venta de licencia avanzada con soporte premium', 3),
(1, DATE_SUB(NOW(), INTERVAL 150 DAY), 'Completed', 'Venta de módulos adicionales para sistema existente', 3),
(3, DATE_SUB(NOW(), INTERVAL 100 DAY), 'Completed', 'Venta de servicio de consultoría', 3),
(6, DATE_SUB(NOW(), INTERVAL 70 DAY), 'Completed', 'Venta de actualización de sistema', 3),
(8, DATE_SUB(NOW(), INTERVAL 40 DAY), 'Completed', 'Venta de formación avanzada para personal nuevo', 3),
(15, DATE_SUB(NOW(), INTERVAL 10 DAY), 'In Progress', 'Propuesta pendiente de aprobación', 3),
(9, DATE_SUB(NOW(), INTERVAL 5 DAY), 'In Progress', 'Propuesta en negociación', 3);

-- 7. Insertar detalles de ventas
INSERT INTO `SalesDetails` (`ProposalID`, `ProductServiceID`, `QuantitySold`, `UnitPrice`, `idEmpresa`) VALUES
(1, 1, 1, 1499.99, 3),
(1, 9, 1, 1500.00, 3),
(2, 2, 1, 2999.99, 3),
(2, 3, 1, 799.99, 3),
(2, 4, 1, 899.99, 3),
(2, 6, 1, 1200.00, 3),
(3, 1, 2, 1499.99, 3),
(3, 5, 1, 699.99, 3),
(3, 6, 1, 1200.00, 3),
(4, 2, 5, 2999.99, 3),
(4, 7, 2, 500.00, 3),
(4, 8, 1, 1000.00, 3),
(5, 1, 1, 1499.99, 3),
(5, 9, 1, 1500.00, 3),
(6, 1, 1, 1299.99, 3), -- Precio con descuento para ONG
(6, 7, 1, 400.00, 3),  -- Precio con descuento para ONG
(7, 2, 1, 2999.99, 3),
(7, 3, 1, 799.99, 3),
(7, 4, 1, 899.99, 3),
(7, 5, 1, 699.99, 3),
(7, 12, 1, 2000.00, 3),
(8, 1, 1, 1499.99, 3),
(8, 7, 1, 500.00, 3),
(9, 2, 1, 2999.99, 3),
(9, 10, 1, 2500.00, 3),
(9, 13, 1, 1299.99, 3),
(10, 1, 1, 1499.99, 3),
(11, 1, 1, 1499.99, 3),
(11, 14, 1, 999.99, 3),
(12, 2, 1, 2999.99, 3),
(13, 1, 1, 1499.99, 3),
(14, 2, 1, 2999.99, 3),
(14, 10, 1, 2500.00, 3),
(15, 3, 1, 799.99, 3),
(15, 4, 1, 899.99, 3),
(16, 12, 1, 2000.00, 3),
(17, 15, 5, 599.99, 3),
(18, 8, 2, 1000.00, 3);

-- 8. Insertar notas
INSERT INTO `Notes` (`Title`, `Content`, `RelatedTo`, `RelatedID`, `CreatedBy`, `idEmpresa`, `created_at`) VALUES
('Reunión inicial con cliente', 'Primera toma de contacto. Cliente interesado en el sistema completo.', 'client', 3, 1, 3, DATE_SUB(NOW(), INTERVAL 160 DAY)),
('Requisitos específicos', 'El cliente necesita módulos personalizados para su industria.', 'client', 3, 1, 3, DATE_SUB(NOW(), INTERVAL 155 DAY)),
('Seguimiento propuesta', 'Llamada de seguimiento realizada. Cliente revisando opciones.', 'client', 6, 1, 3, DATE_SUB(NOW(), INTERVAL 290 DAY)),
('Formación pendiente', 'Programar sesión de formación para nuevos usuarios.', 'project', 1, 1, 3, DATE_SUB(NOW(), INTERVAL 100 DAY)),
('Incidencia resuelta', 'Problema con la conexión a la base de datos solucionado.', 'client', 1, 1, 3, DATE_SUB(NOW(), INTERVAL 320 DAY)),
('Ampliación de servicios', 'Cliente interesado en adquirir módulos adicionales.', 'client', 11, 1, 3, DATE_SUB(NOW(), INTERVAL 170 DAY)),
('Feedback positivo', 'El cliente está satisfecho con la implementación del sistema.', 'project', 2, 1, 3, DATE_SUB(NOW(), INTERVAL 40 DAY)),
('Próxima versión', 'Informar al cliente sobre las nuevas funcionalidades de la próxima versión.', 'client', 9, 1, 3, DATE_SUB(NOW(), INTERVAL 190 DAY)),
('Posible referencia', 'Cliente dispuesto a servir como referencia para nuevos clientes.', 'client', 4, 1, 3, DATE_SUB(NOW(), INTERVAL 210 DAY)),
('Datos migrados', 'Migración de datos completada con éxito.', 'project', 2, 1, 3, DATE_SUB(NOW(), INTERVAL 50 DAY)),
('Incidencia pendiente', 'Problema con el módulo de informes. En proceso de resolución.', 'client', 14, 1, 3, DATE_SUB(NOW(), INTERVAL 110 DAY)),
('Renovación contrato', 'Preparar propuesta para renovación de contrato de soporte.', 'client', 1, 1, 3, DATE_SUB(NOW(), INTERVAL 30 DAY)),
('Integración solicitada', 'Cliente solicita integración con su sistema de e-commerce.', 'client', 11, 1, 3, DATE_SUB(NOW(), INTERVAL 160 DAY)),
('Lead cualificado', 'Lead interesado en adquirir el sistema completo.', 'lead', 3, 1, 3, DATE_SUB(NOW(), INTERVAL 55 DAY)),
('Seguimiento lead', 'Llamada de seguimiento realizada. Lead evaluando presupuesto.', 'lead', 7, 1, 3, DATE_SUB(NOW(), INTERVAL 25 DAY)),
('Presentación completada', 'Demostración del producto realizada con éxito.', 'lead', 8, 1, 3, DATE_SUB(NOW(), INTERVAL 20 DAY)),
('Proyecto en riesgo', 'Posible retraso en la implementación por cambios solicitados.', 'project', 5, 1, 3, DATE_SUB(NOW(), INTERVAL 15 DAY)),
('Oportunidad de venta', 'Cliente interesado en adquirir licencias adicionales.', 'client', 8, 1, 3, DATE_SUB(NOW(), INTERVAL 230 DAY)),
('Reunión programada', 'Reunión de seguimiento agendada para la próxima semana.', 'client', 13, 1, 3, DATE_SUB(NOW(), INTERVAL 10 DAY)),
('Nueva funcionalidad', 'Nota sobre desarrollo de funcionalidad personalizada solicitada.', 'project', 6, 1, 3, DATE_SUB(NOW(), INTERVAL 5 DAY)); 