<?php
require_once __DIR__ . '/../includes/session.php';
requerir_administrador();
require_once __DIR__ . '/../config/BD.php';

$bd = new bd();
$mensaje = '';
$usuarios = array();
$pagina_activa = 'modificar_usuarios';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'], $_POST['email_orig'])) {
    $email_orig = trim($_POST['email_orig']);
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $id_nivel = (int)($_POST['id_nivel'] ?? 0);
    $id_area = isset($_POST['id_area']) ? (int)$_POST['id_area'] : 'NULL';
    $pass = $_POST['password'] ?? '';
    $campos = "nombre = '" . $bd->db->real_escape_string($nombre) . "', apellido = '" . $bd->db->real_escape_string($apellido) . "', email = '" . $bd->db->real_escape_string($email) . "', id_nivel = " . $id_nivel . ", id_area = " . ($id_area === 'NULL' ? 'NULL' : $id_area);
    if ($pass !== '') {
        $campos .= ", password = '" . $bd->db->real_escape_string($pass) . "'";
    }
    $sql = "UPDATE usuario SET $campos WHERE email = '" . $bd->db->real_escape_string($email_orig) . "'";
    if ($bd->abc($sql)) {
        $mensaje = 'Usuario actualizado correctamente.';
    } else {
        $mensaje = 'Error al actualizar.';
    }
}

$usuarios = $bd->getFilas("SELECT u.nombre, u.apellido, u.email, u.id_area, u.id_nivel, n.nivel FROM usuario u INNER JOIN nivel n ON u.id_nivel = n.id_nivel ORDER BY u.nombre");
$niveles = $bd->getFilas("SELECT id_nivel, nivel FROM nivel");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar usuarios - Administrador</title>
    <link rel="stylesheet" href="../assets/estilos.css">
</head>
<body>
    <div class="layout">
        <?php include __DIR__ . '/../includes/menu_admin.php'; ?>
        <main class="main">
            <div class="header">
                <h1>Modificar usuarios</h1>
                <a href="../auth/logout.php" class="btn-salir">Cerrar sesión</a>
            </div>
            <?php if ($mensaje): ?><div class="alert alert-success"><?php echo htmlspecialchars($mensaje); ?></div><?php endif; ?>
            <div class="card">
                <h3>Listado de usuarios</h3>
                <p>Seleccione un usuario para editar.</p>
                <div class="table-wrap"><table>
                    <thead>
                        <tr><th>Nombre</th><th>Apellido</th><th>Email</th><th>Nivel</th><th>Acción</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($u['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><?php echo htmlspecialchars($u['nivel']); ?></td>
                            <td><a href="?editar=<?php echo urlencode($u['email']); ?>" class="btn btn-secondary">Editar</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table></div>
            </div>
            <?php
            $editar_email = isset($_GET['editar']) ? trim($_GET['editar']) : '';
            if ($editar_email !== ''):
                $edit = null;
                foreach ($usuarios as $u) { if ($u['email'] === $editar_email) { $edit = $u; break; } }
                if ($edit):
            ?>
            <div class="card">
                <h3>Editar usuario: <?php echo htmlspecialchars($edit['email']); ?></h3>
                <form method="POST" action="">
                    <input type="hidden" name="email_orig" value="<?php echo htmlspecialchars($edit['email']); ?>">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($edit['nombre']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" value="<?php echo htmlspecialchars($edit['apellido']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($edit['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Nivel</label>
                        <select name="id_nivel">
                            <?php foreach ($niveles as $n): ?>
                            <option value="<?php echo (int)$n['id_nivel']; ?>" <?php echo ($n['id_nivel'] == $edit['id_nivel']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($n['nivel']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nueva contraseña (dejar en blanco para no cambiar)</label>
                        <input type="password" name="password" placeholder="••••••••">
                    </div>
                    <button type="submit" name="guardar" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
            <?php endif; endif; ?>
        </main>
    </div>
</body>
</html>
