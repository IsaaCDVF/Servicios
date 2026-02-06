-- ============================================================
-- Sistema de Servicios - Esquema completo de base de datos
-- Ejecutar en phpMyAdmin o consola MySQL del hosting
-- ============================================================

-- Crear base de datos (en muchos hostings ya existe; si da error, omite esta línea)
CREATE DATABASE IF NOT EXISTS servicios CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE servicios;

-- ------------------------------------------------------------
-- Tabla: nivel (administrador / usuario)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS nivel (
  id_nivel INT AUTO_INCREMENT PRIMARY KEY,
  nivel VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO nivel (id_nivel, nivel) VALUES (1, 'administrador'), (2, 'usuario')
ON DUPLICATE KEY UPDATE nivel = VALUES(nivel);

-- ------------------------------------------------------------
-- Tabla: usuario
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuario (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  id_area INT DEFAULT NULL,
  password VARCHAR(255) NOT NULL,
  id_nivel INT NOT NULL,
  CONSTRAINT fk_usuario_nivel FOREIGN KEY (id_nivel) REFERENCES nivel(id_nivel)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuario administrador por defecto (cambiar contraseña tras el primer acceso)
-- Email: admin@tudominio.com  |  Contraseña: Cambiar123
INSERT INTO usuario (nombre, apellido, email, id_area, password, id_nivel)
VALUES ('Administrador', 'Sistema', 'admin@tudominio.com', NULL, 'Cambiar123', 1)
ON DUPLICATE KEY UPDATE nombre = nombre;

-- ------------------------------------------------------------
-- Tabla: negocios
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS negocios (
  id_negocio INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  direccion VARCHAR(255) DEFAULT NULL,
  telefono VARCHAR(30) DEFAULT NULL,
  email_negocio VARCHAR(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- Fin del esquema
-- ============================================================
