CREATE DATABASE IF NOT EXISTS taskshield CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE taskshield;

CREATE TABLE tecnicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    especialidad VARCHAR(100) DEFAULT NULL,
    tareas_activas INT DEFAULT 0
) ENGINE=InnoDB;

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

INSERT INTO tecnicos (nombre, email, especialidad, tareas_activas) VALUES
('Laura Gómez', 'laura@soporte.es', 'Redes y Servidores', 1),
('Carlos Ruiz', 'carlos@soporte.es', 'Hardware', 0);

INSERT INTO incidencias (titulo, descripcion, prioridad, estado, email_cliente, tecnico_id) VALUES
('Caída de red planta 2', 'No hay conexión a internet en los puestos del ala norte.', 'Urgente', 'En Proceso', 'admin@empresa.com', 1),
('Impresora atascada', 'La impresora láser de recepción marca error de rodillo.', 'Baja', 'Pendiente', 'recepcion@empresa.com', NULL);