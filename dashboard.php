<?php
/**
 * Dashboard - Página protegida después del login
 */

// Iniciar sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_logueado']) || $_SESSION['usuario_logueado'] !== true) {
    // Redirigir al login si no está autenticado
    header('Location: login.html');
    exit();
}

// Obtener datos del usuario
$username = $_SESSION['username'];
$rol = $_SESSION['rol'];
$tiempo_login = $_SESSION['tiempo_login'];
$tiempo_conectado = time() - $tiempo_login;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MI BELLO MACHALITO</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .dashboard-container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .header-dashboard {
            background: linear-gradient(135deg, #f70909 0%, #ff6b6b 100%);
            color: white;
            padding: 2rem;
            border-radius: 18px;
            margin-bottom: 2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-dashboard h1 {
            margin: 0;
            font-size: 2rem;
        }

        .user-info {
            text-align: right;
        }

        .user-info p {
            margin: 0.3rem 0;
            font-size: 0.95rem;
        }

        .logout-btn {
            background-color: white;
            color: #f70909;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, filter 0.2s ease;
            font-size: 0.95rem;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            filter: brightness(0.95);
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #f70909;
        }

        .card h3 {
            color: #f70909;
            margin-top: 0;
            margin-bottom: 0.8rem;
        }

        .card p {
            text-align: left;
            color: #333;
            line-height: 1.6;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-btn {
            background-color: #f30a0a;
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, filter 0.2s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            filter: brightness(0.9);
        }

        .action-btn.secondary {
            background-color: #555;
        }

        .admin-section {
            background: rgba(255, 200, 200, 0.5);
            border-left-color: #f70909;
        }

        .welcome-message {
            background: rgba(247, 9, 9, 0.1);
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #f70909;
        }

        .welcome-message h2 {
            color: #f70909;
            margin-top: 0;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .stat-box {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
            border: 2px solid #f70909;
        }

        .stat-box .number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #f70909;
        }

        .stat-box .label {
            font-size: 0.9rem;
            color: #666;
            margin-top: 0.3rem;
        }

        footer {
            text-align: center;
            padding: 2rem;
            color: #666;
            border-top: 1px solid #ddd;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Header del Dashboard -->
        <div class="header-dashboard">
            <div>
                <h1>🐱 Bienvenido, <?php echo htmlspecialchars($username); ?>!</h1>
            </div>
            <div class="user-info">
                <p><strong>Rol:</strong> <?php echo htmlspecialchars($rol); ?></p>
                <p id="tiempo">Conectado: <span>0s</span></p>
                <form action="logout.php" method="POST" style="margin: 0; display: inline;">
                    <button type="submit" class="logout-btn">Cerrar Sesión</button>
                </form>
            </div>
        </div>

        <!-- Mensaje de Bienvenida -->
        <div class="welcome-message">
            <h2>🎉 ¡Bienvenido a MI BELLO MACHALITO!</h2>
            <p>Has iniciado sesión correctamente. Ahora tienes acceso a todas nuestras opciones exclusivas.</p>
        </div>

        <!-- Estadísticas -->
        <div class="stats">
            <div class="stat-box">
                <div class="number">🛍️</div>
                <div class="label">Productos Disponibles</div>
            </div>
            <div class="stat-box">
                <div class="number">📦</div>
                <div class="label">Órdenes Realizadas</div>
            </div>
            <div class="stat-box">
                <div class="number">💬</div>
                <div class="label">Mensajes Sin Leer</div>
            </div>
        </div>

        <!-- Grid de Contenido -->
        <div class="content-grid">
            <!-- Card de Información -->
            <div class="card">
                <h3>📋 Mi Información</h3>
                <p>
                    <strong>Usuario:</strong> <?php echo htmlspecialchars($username); ?><br>
                    <strong>Rol:</strong> <?php echo htmlspecialchars($rol); ?><br>
                    <strong>Acceso:</strong> ✅ Activo
                </p>
            </div>

            <!-- Card de Navegación -->
            <div class="card">
                <h3>🔗 Navegación Rápida</h3>
                <p>
                    Acceso rápido a nuestras secciones principales:
                    <div class="action-buttons" style="margin-top: 1rem; display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="productos.html" class="action-btn" style="background-color: #f30a0a; text-decoration: none;">Ver Productos</a>
                        <a href="consultas.html" class="action-btn secondary" style="text-decoration: none;">Consultas</a>
                        <a href="contacto.html" class="action-btn secondary" style="text-decoration: none;">Contacto</a>
                    </div>
                </p>
            </div>

            <?php if ($username === 'admin'): ?>
            <!-- Card de Administración (Solo para Admin) -->
            <div class="card admin-section">
                <h3>⚙️ Panel Administrativo</h3>
                <p>
                    Como administrador, tienes acceso especial a:
                    <ul style="margin: 0.8rem 0; padding-left: 1.5rem;">
                        <li>Gestionar usuarios</li>
                        <li>Ver reportes</li>
                        <li>Configurar sistema</li>
                        <li>Ver análitica</li>
                    </ul>
                </p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Botones de Acción -->
        <div class="action-buttons">
            <a href="index.html" class="action-btn secondary" style="text-decoration: none;">Volver al Inicio</a>
            <form action="logout.php" method="POST" style="display: inline-block; width: 100%;">
                <button type="submit" class="action-btn">Cerrar Sesión</button>
            </form>
        </div>

        <footer>
            <p>&copy; 2026 Paloma Ignacia Pozo Briones. Todos los derechos reservados.</p>
        </footer>
    </div>

    <script>
        // Actualizar el tiempo conectado
        function actualizarTiempo() {
            const inicio = new Date().getTime() - (<?php echo time() - $tiempo_login; ?> * 1000);
            
            setInterval(function() {
                const ahora = new Date().getTime();
                const segundos = Math.floor((ahora - inicio) / 1000);
                
                let tiempo = '';
                if (segundos < 60) {
                    tiempo = segundos + 's';
                } else if (segundos < 3600) {
                    const minutos = Math.floor(segundos / 60);
                    tiempo = minutos + 'm ' + (segundos % 60) + 's';
                } else {
                    const horas = Math.floor(segundos / 3600);
                    const minutos = Math.floor((segundos % 3600) / 60);
                    tiempo = horas + 'h ' + minutos + 'm';
                }
                
                document.querySelector('#tiempo span').textContent = tiempo;
            }, 1000);
        }
        
        actualizarTiempo();
    </script>
</body>
</html>
