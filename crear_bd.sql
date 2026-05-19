-- =====================================================
-- BASE DE DATOS: gatitos
-- DESCRIPCIÓN: Sistema de login para MI BELLO MACHALITO
-- =====================================================

-- Crear base de datos si no existe
CREATE DATABASE IF NOT EXISTS gatitos;
USE gatitos;

-- =====================================================
-- TABLA: usuarios
-- =====================================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    nombre_completo VARCHAR(100),
    rol ENUM('Administrador', 'Usuario Regular') DEFAULT 'Usuario Regular',
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_ultima_conexion DATETIME,
    INDEX idx_username (username),
    INDEX idx_rol (rol)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: sesiones_login
-- =====================================================
CREATE TABLE IF NOT EXISTS sesiones_login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    fecha_login DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_logout DATETIME,
    ip_address VARCHAR(45),
    navegador VARCHAR(255),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario (id_usuario),
    INDEX idx_fecha (fecha_login)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: intentos_login (para seguridad)
-- =====================================================
CREATE TABLE IF NOT EXISTS intentos_login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    fecha_intento DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    exitoso BOOLEAN DEFAULT FALSE,
    INDEX idx_username (username),
    INDEX idx_fecha (fecha_intento),
    INDEX idx_ip (ip_address)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- INSERTAR USUARIOS INICIALES
-- =====================================================
INSERT INTO usuarios (username, password, email, nombre_completo, rol, estado) VALUES
(
    'admin',
    '$2y$10$X4JzYfgFH2aAZmfCvX8tJOJ7p.QZdZhVqNM2Zk5LVpZq8cMGk4zK6',
    'admin@gatitos.com',
    'Administrador Sistema',
    'Administrador',
    'activo'
),
(
    'usuario',
    '$2y$10$X4JzYfgFH2aAZmfCvX8tJOJ7p.QZdZhVqNM2Zk5LVpZq8cMGk4zK6',
    'usuario@gatitos.com',
    'Usuario Regular',
    'Usuario Regular',
    'activo'
);

-- Notas sobre las contraseñas:
-- admin: admin123 (hash bcrypt)
-- usuario: usuario123 (hash bcrypt)
-- Para actualizar contraseñas, usa PHP con password_hash()

-- =====================================================
-- VISTAS ÚTILES
-- =====================================================

-- Vista: Últimas conexiones
CREATE OR REPLACE VIEW vista_ultimas_conexiones AS
SELECT 
    u.username,
    u.nombre_completo,
    u.rol,
    sl.fecha_login,
    sl.fecha_logout,
    sl.ip_address,
    TIMEDIFF(IFNULL(sl.fecha_logout, NOW()), sl.fecha_login) AS tiempo_conectado
FROM usuarios u
LEFT JOIN sesiones_login sl ON u.id = sl.id_usuario
ORDER BY sl.fecha_login DESC
LIMIT 50;

-- Vista: Resumen de intentos fallidos
CREATE OR REPLACE VIEW vista_intentos_fallidos AS
SELECT 
    username,
    COUNT(*) AS total_intentos,
    MAX(fecha_intento) AS ultimo_intento,
    GROUP_CONCAT(DISTINCT ip_address) AS ips
FROM intentos_login
WHERE exitoso = FALSE AND fecha_intento > DATE_SUB(NOW(), INTERVAL 24 HOUR)
GROUP BY username
ORDER BY total_intentos DESC;
