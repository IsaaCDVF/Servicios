<?php
require_once __DIR__ . '/../includes/session.php';
requerir_administrador();
require_once __DIR__ . '/../config/BD.php';

$bd = new bd();
$mensaje = '';
$tabla_negocios = 'negocios';
$pagina_activa = 'abc_negocios';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $email_negocio = trim($_POST['email_negocio'] ?? '');
    $esc = function($v) use ($bd) { return "'" . $bd->db->real_escape_string($v) . "'"; };
    if (isset($_POST['alta']) && $nombre !== '') {
        $sql = "INSERT INTO $tabla_negocios (nombre, direccion, telefono, email_negocio) VALUES (" . $esc($nombre) . "," . $esc($direccion) . "," . $esc($telefono) . "," . $esc($email_negocio) . ")";
        if ($bd->abc($sql)) $mensaje = 'Negocio dado de alta.';
    } elseif (isset($_POST['baja']) && isset($_POST['id_negocio'])) {
        $id = (int)$_POST['id_negocio'];
        if ($bd->abc("DELETE FROM $tabla_negocios WHERE id_negocio = $id")) $mensaje = 'Negocio eliminado.';
    } elseif (isset($_POST['cambio']) && isset($_POST['id_negocio']) && $nombre !== '') {
        $id = (int)$_POST['id_negocio'];
        $sql = "UPDATE $tabla_negocios SET nombre=" . $esc($nombre) . ", direccion=" . $esc($direccion) . ", telefono=" . $esc($telefono) . ", email_negocio=" . $esc($email_negocio) . " WHERE id_negocio = $id";
        if ($bd->abc($sql)) $mensaje = 'Negocio actualizado.';
    }
}

$negocios = $bd->getFilas("SELECT * FROM $tabla_negocios ORDER BY nombre");
if (!is_array($negocios)) $negocios = array();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABC Negocios - Administrador</title>
    <link rel="stylesheet" href="../assets/estilos.css">
</head>
<body>
    <div class="layout">
        <?php include __DIR__ . '/../includes/menu_admin.php'; ?>
        <main class="main">
            <div class="header">
                <h1>ABC Negocios</h1>
                <a href="../auth/logout.php" class="btn-salir">Cerrar sesión</a>
            </div>
            <?php if ($mensaje): ?><div class="alert alert-success"><?php echo htmlspecialchars($mensaje); ?></div><?php endif; ?>
            <div class="card">
                <h3>Alta de negocio</h3>
                <form method="POST">
                    <div class="form-group"><label>Nombre</label><input type="text" name="nombre" required></div>
                    <div class="form-group"><label>Dirección</label><input type="text" name="direccion"></div>
                    <div class="form-group"><label>Teléfono</label><input type="text" name="telefono"></div>
                    <div class="form-group"><label>Email</label><input type="email" name="email_negocio"></div>
                    <button type="submit" name="alta" class="btn btn-primary">Dar de alta</button>
                </form>
            </div>
            <div class="card">
                <h3>Listado de negocios</h3>
                <?php if (count($negocios) > 0): ?>
                <div class="table-wrap"><table>
                    <thead>
                        <tr><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Email</th><th>Acciones</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($negocios as $n): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($n['nombre'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($n['direccion'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($n['telefono'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($n['email_negocio'] ?? ''); ?></td>
                            <td>
                                <a href="?editar=<?php echo (int)($n['id_negocio'] ?? 0); ?>" class="btn btn-secondary">Editar</a>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar este negocio?');">
                                    <input type="hidden" name="id_negocio" value="<?php echo (int)($n['id_negocio'] ?? 0); ?>">
                                    <button type="submit" name="baja" class="btn btn-secondary">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table></div>
                <?php else: ?>
                <p>No hay negocios. Usa el formulario de alta.</p>
                <?php endif; ?>
            </div>
            <?php
            $editar_id = isset($_GET['editar']) ? (int)$_GET['editar'] : 0;
            if ($editar_id > 0):
                $edit = null;
                foreach ($negocios as $n) { if (($n['id_negocio'] ?? 0) == $editar_id) { $edit = $n; break; } }
                if ($edit):
            ?>
            <div class="card">
                <h3>Editar negocio</h3>
                <form method="POST">
                    <input type="hidden" name="id_negocio" value="<?php echo (int)$edit['id_negocio']; ?>">
                    <div class="form-group"><label>Nombre</label><input type="text" name="nombre" value="<?php echo htmlspecialchars($edit['nombre'] ?? ''); ?>" required></div>
                    <div class="form-group"><label>Dirección</label><input type="text" name="direccion" value="<?php echo htmlspecialchars($edit['direccion'] ?? ''); ?>"></div>
                    <div class="form-group"><label>Teléfono</label><input type="text" name="telefono" value="<?php echo htmlspecialchars($edit['telefono'] ?? ''); ?>"></div>
                    <div class="form-group"><label>Email</label><input type="email" name="email_negocio" value="<?php echo htmlspecialchars($edit['email_negocio'] ?? ''); ?>"></div>
                    <button type="submit" name="cambio" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
            <?php endif; endif; ?>
        </main>
    </div>
</body>
</html>
