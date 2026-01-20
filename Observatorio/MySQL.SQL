CREATE DATABASE IF NOT EXISTS control_incidencias
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE control_incidencias;

CREATE TABLE incidencias (
    id INT AUTO_INCREMENT PRIMARY KEY,              -- "No"
    incidencia_problema VARCHAR(255) NOT NULL,      -- "INCIDENCIA/PROBLEMA"
    prioridad_impacto ENUM('BAJA','MEDIA','ALTA','CRÍTICA') NOT NULL DEFAULT 'MEDIA',  -- "PRIORIDAD/IMPACTO"
    fecha_apertura DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,                        -- "FECHA APERTURA"
    creado_por VARCHAR(100) NOT NULL,               -- "CREADOR POR"
    asignado_a VARCHAR(100) DEFAULT NULL,           -- "ASIGNADO A"
    fecha_resolucion DATETIME DEFAULT NULL,         -- "FECHA DE RESOLUCION"
    estado ENUM('ABIERTA','EN PROCESO','RESUELTA','CERRADA') NOT NULL DEFAULT 'ABIERTA', -- "ESTADO"
    corregido TINYINT(1) NOT NULL DEFAULT 0,        -- "CORREGIDO" (0 = NO, 1 = SÍ)
    observaciones TEXT NULL,
    INDEX idx_estado (estado),
    INDEX idx_prioridad (prioridad_impacto)
) ENGINE=InnoDB;
