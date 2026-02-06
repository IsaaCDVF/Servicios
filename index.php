<?php
session_start();
if (isset($_SESSION['id_usuario']) && isset($_SESSION['nivel'])) {
    if ($_SESSION['nivel'] === 'administrador') {
        header('Location: panel_administrador.php');
    } else {
        header('Location: panel_usuario.php');
    }
    exit;
}
$error = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Login - Sistema de Servicios</title>
    <link rel="stylesheet" href="assets/estilos.css">
    <link rel="stylesheet" href="assets/login.css">
</head>
<body class="login-page">
    <div class="login-bg" aria-hidden="true">
        <img src="https://images.unsplash.com/photo-1557683316-973673baf926?w=1920&q=80" alt="" class="login-bg-img">
        <div class="login-bg-overlay"></div>
    </div>
    <div class="login-container">
        <div class="login-card">
            <div class="login-brand">
                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=120&h=120&fit=crop" alt="Servicios" width="64" height="64" loading="eager">
                <h1>Iniciar sesión</h1>
                <p class="login-subtitle">Sistema de Servicios</p>
            </div>
            <?php if ($error === 'credenciales'): ?>
                <div class="alert alert-error">Email o contraseña incorrectos. Intente de nuevo.</div>
            <?php endif; ?>
            <form action="auth/login.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="usuario@ejemplo.com" required autofocus autocomplete="email">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
