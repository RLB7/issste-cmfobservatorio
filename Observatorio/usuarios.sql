CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    usuario VARCHAR(50) UNIQUE,
    password_hash VARCHAR(255),
    rol ENUM('ADMIN','TECNICO','USUARIO') NOT NULL,
    activo TINYINT(1) DEFAULT 1
);
