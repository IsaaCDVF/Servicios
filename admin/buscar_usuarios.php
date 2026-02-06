<?php
require_once __DIR__ . '/../includes/session.php';
requerir_administrador();
require_once __DIR__ . '/../config/BD.php';

$bd = new bd();
$resultados = array();
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';
$pagina_activa = 'buscar_usuarios';

if ($busqueda !== '') {
    $esc = $bd->db->real_escape_string($busqueda);
    $resultados = $bd->getFilas(
        "SELECT u.nombre, u.apellido, u.email, u.id_area, n.nivel FROM usuario u INNER JOIN nivel n ON u.id_nivel = n.id_nivel " .
        "WHERE u.nombre LIKE '%$esc%' OR u.apellido LIKE '%$esc%' OR u.email LIKE '%$esc%' ORDER BY u.nombre"
    );
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar usuarios - Administrador</title>
    <link rel="stylesheet" href="../assets/estilos.css">
</head>
<body>
    <div class="layout">
        <?php include __DIR__ . '/../includes/menu_admin.php'; ?>
        <main class="main">
            <div class="header">
                <h1>Buscar usuarios</h1>
                <a href="../auth/logout.php" class="btn-salir">Cerrar sesión</a>
            </div>
            <div class="card">
                <h3>Búsqueda</h3>
                <form method="GET" action="" class="form-row-inline">
                    <div class="form-group">
                        <label for="q">Nombre, apellido o email</label>
                        <input type="text" id="q" name="q" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Escriba para buscar">
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
            <?php if ($busqueda !== ''): ?>
            <div class="card">
                <h3>Resultados (<?php echo count($resultados); ?>)</h3>
                <?php if (count($resultados) === 0): ?>
                    <p>No se encontraron usuarios.</p>
                <?php else: ?>
                <div class="table-wrap"><table>
                    <thead>
                        <tr><th>Nombre</th><th>Apellido</th><th>Email</th><th>Nivel</th><th>Id área</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $u): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($u['apellido']); ?></td>
                            <td><?php echo htmlspecialchars($u['email']); ?></td>
                            <td><?php echo htmlspecialchars($u['nivel']); ?></td>
                            <td><?php echo $u['id_area'] !== null ? (int)$u['id_area'] : '-'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table></div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
