<?php
require_once __DIR__ . '/includes/session.php';
requerir_administrador();
$nombre = htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellido']);
$pagina_activa = 'inicio';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - Sistema de Servicios</title>
    <link rel="stylesheet" href="assets/estilos.css">
</head>
<body>
    <div class="layout">
        <?php include __DIR__ . '/includes/menu_admin.php'; ?>
        <main class="main">
            <div class="header">
                <h1>Panel de Administrador</h1>
                <a href="auth/logout.php" class="btn-salir">Cerrar sesión</a>
            </div>
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&h=200&fit=crop" alt="" class="hero-image" loading="lazy">
            <p>Bienvenido, <strong><?php echo $nombre; ?></strong>. Gestión de usuarios y negocios.</p>
            <div class="card">
                <h3>Accesos rápidos</h3>
                <div class="quick-actions">
                    <a href="admin/mi_perfil.php" class="btn btn-primary">Mi perfil</a>
                    <a href="admin/buscar_negocios.php" class="btn btn-secondary">Buscar negocios</a>
                    <a href="admin/modificar_usuarios.php" class="btn btn-secondary">Modificar usuarios</a>
                    <a href="admin/buscar_usuarios.php" class="btn btn-secondary">Buscar usuarios</a>
                    <a href="admin/abc_negocios.php" class="btn btn-secondary">ABC Negocios</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
