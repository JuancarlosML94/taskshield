-- Creación de la base de datos para Taskshield
DROP DATABASE IF EXISTS taskshield;
CREATE DATABASE taskshield CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE taskshield;

-- Tabla de Técnicos
CREATE TABLE tecnicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    tareas_activas INT DEFAULT 0
) ENGINE=InnoDB;

-- Tabla de Incidencias
CREATE TABLE incidencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    prioridad ENUM('Baja', 'Media', 'Alta', 'Urgente') DEFAULT 'Media',
    estado ENUM('Pendiente', 'En Proceso', 'Resuelta') DEFAULT 'Pendiente',
    email_cliente VARCHAR(100) NOT NULL,
    tecnico_id INT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_tecnico FOREIGN KEY (tecnico_id) REFERENCES tecnicos(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Datos de prueba iniciales
INSERT INTO tecnicos (nombre, email, tareas_activas) VALUES 
('Ana Gómez', 'ana.gomez@empresa.com', 0),
('Carlos Ruiz', 'carlos.ruiz@empresa.com', 0);

INSERT INTO incidencias (titulo, descripcion, prioridad, estado, email_cliente, tecnico_id) VALUES 
('Error en impresora planta 2', 'La impresora departamental no coge papel y da error de bandeja.', 'Media', 'Pendiente', 'cliente1@empresa.com', NULL),
('Fallo de acceso VPN', 'No es posible conectar a la VPN corporativa desde remoto.', 'Alta', 'Pendiente', 'cliente2@empresa.com', NULL);