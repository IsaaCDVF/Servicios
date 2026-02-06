<?php
require_once __DIR__ . '/includes/session.php';
requerir_usuario();
$nombre = htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']);
$pagina_activa = 'inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Usuario - Sistema de Servicios</title>
    <link rel="stylesheet" href="assets/estilos.css">
</head>
<body>
    <div class="layout">
        <?php include __DIR__ . '/includes/menu_usuario.php'; ?>
        <main class="main">
            <div class="header">
                <h1>Panel de Usuario</h1>
                <a href="auth/logout.php" class="btn-salir">Cerrar sesión</a>
            </div>
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&h=200&fit=crop" alt="" class="hero-image" loading="lazy">
            <p>Bienvenido, <strong><?php echo $nombre; ?></strong>. Solo puedes editar tus datos y buscar negocios.</p>
            <div class="card">
                <h3>Accesos rápidos</h3>
                <div class="quick-actions">
                    <a href="usuario/mi_perfil.php" class="btn btn-primary">Mi perfil</a>
                    <a href="usuario/buscar_negocios.php" class="btn btn-secondary">Buscar negocios</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
