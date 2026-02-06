<?php
require_once __DIR__ . '/../includes/session.php';
requerir_usuario();
require_once __DIR__ . '/../config/BD.php';

$bd = new bd();
$mensaje = '';
$email_session = $_SESSION['email'];
$pagina_activa = 'mi_perfil';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $campos = "nombre = '" . $bd->db->real_escape_string($nombre) . "', apellido = '" . $bd->db->real_escape_string($apellido) . "', email = '" . $bd->db->real_escape_string($email) . "'";
    if ($pass !== '') {
        $campos .= ", password = '" . $bd->db->real_escape_string($pass) . "'";
    }
    $sql = "UPDATE usuario SET $campos WHERE email = '" . $bd->db->real_escape_string($email_session) . "'";
    if ($bd->abc($sql)) {
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['email'] = $email;
        $email_session = $email;
        $mensaje = 'Sus datos se han actualizado correctamente.';
    } else {
        $mensaje = 'Error al actualizar.';
    }
}

$perfil = $bd->getFilas("SELECT nombre, apellido, email FROM usuario WHERE email = '" . $bd->db->real_escape_string($email_session) . "'");
$datos = isset($perfil[0]) ? $perfil[0] : array('nombre' => '', 'apellido' => '', 'email' => '');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil - Usuario</title>
    <link rel="stylesheet" href="../assets/estilos.css">
</head>
<body>
    <div class="layout">
        <?php include __DIR__ . '/../includes/menu_usuario.php'; ?>
        <main class="main">
            <div class="header">
                <h1>Mis datos personales</h1>
                <a href="../auth/logout.php" class="btn-salir">Cerrar sesión</a>
            </div>
            <?php if ($mensaje): ?><div class="alert alert-success"><?php echo htmlspecialchars($mensaje); ?></div><?php endif; ?>
            <div class="card">
                <h3>Editar mis datos</h3>
                <form method="POST">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($datos['nombre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" value="<?php echo htmlspecialchars($datos['apellido']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($datos['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Nueva contraseña (dejar en blanco para no cambiar)</label>
                        <input type="password" name="password" placeholder="••••••••">
                    </div>
                    <button type="submit" name="guardar" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
