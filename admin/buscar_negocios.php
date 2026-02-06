<?php
require_once __DIR__ . '/../includes/session.php';
requerir_administrador();
require_once __DIR__ . '/../config/BD.php';

$bd = new bd();
$resultados = array();
$busqueda = isset($_GET['q']) ? trim($_GET['q']) : '';
$tabla_negocios = 'negocios';
$pagina_activa = 'buscar_negocios';

if ($busqueda !== '') {
    $esc = $bd->db->real_escape_string($busqueda);
    $resultados = $bd->getFilas(
        "SELECT * FROM $tabla_negocios WHERE nombre LIKE '%$esc%' OR direccion LIKE '%$esc%' OR telefono LIKE '%$esc%' OR email_negocio LIKE '%$esc%' ORDER BY nombre"
    );
}
if (!is_array($resultados)) $resultados = array();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar negocios - Administrador</title>
    <link rel="stylesheet" href="../assets/estilos.css">
</head>
<body>
    <div class="layout">
        <?php include __DIR__ . '/../includes/menu_admin.php'; ?>
        <main class="main">
            <div class="header">
                <h1>Buscar negocios</h1>
                <a href="../auth/logout.php" class="btn-salir">Cerrar sesión</a>
            </div>
            <div class="card">
                <h3>Búsqueda</h3>
                <form method="GET" action="" class="form-row-inline">
                    <div class="form-group">
                        <label for="q">Nombre, dirección, teléfono o email del negocio</label>
                        <input type="text" id="q" name="q" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Escriba para buscar">
                    </div>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
            <?php if ($busqueda !== ''): ?>
            <div class="card">
                <h3>Resultados (<?php echo count($resultados); ?>)</h3>
                <?php if (count($resultados) === 0): ?>
                    <p>No se encontraron negocios.</p>
                <?php else: ?>
                <div class="table-wrap"><table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $n): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($n['nombre'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($n['direccion'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($n['telefono'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($n['email_negocio'] ?? ''); ?></td>
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
