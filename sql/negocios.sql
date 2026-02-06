-- Tabla opcional para ABC Negocios y Buscar negocios.
-- Ejecutar en la base de datos 'servicios' si aún no existe.

CREATE TABLE IF NOT EXISTS negocios (
  id_negocio INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  direccion VARCHAR(255) DEFAULT NULL,
  telefono VARCHAR(30) DEFAULT NULL,
  email_negocio VARCHAR(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
