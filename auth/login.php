<?php
session_start();
require_once __DIR__ . '/../config/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['email'], $_POST['password'])) {
    header('Location: ../index.php?error=credenciales');
    exit;
}

$email = trim($_POST['email']);
$password = $_POST['password'];

if ($email === '' || $password === '') {
    header('Location: ../index.php?error=credenciales');
    exit;
}

$link = Conectar::conexion();
$stmt = $link->prepare(
    "SELECT u.nombre, u.apellido, u.email, u.id_area, u.id_nivel, u.password, n.nivel 
     FROM usuario u 
     INNER JOIN nivel n ON u.id_nivel = n.id_nivel 
     WHERE u.email = ?"
);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    $link->close();
    header('Location: ../index.php?error=credenciales');
    exit;
}

$row = $result->fetch_assoc();
$stmt->close();
$link->close();

// Comparar contraseña (si en BD está hasheada usar password_verify($password, $row['password']))
if ($row['password'] !== $password) {
    header('Location: ../index.php?error=credenciales');
    exit;
}

$_SESSION['id_usuario'] = $row['email']; // identificador de sesión (si tienes id en usuario, úsalo)
$_SESSION['nombre'] = $row['nombre'];
$_SESSION['apellido'] = $row['apellido'];
$_SESSION['email'] = $row['email'];
$_SESSION['id_area'] = $row['id_area'];
$_SESSION['id_nivel'] = $row['id_nivel'];
$_SESSION['nivel'] = strtolower(trim($row['nivel']));

if ($_SESSION['nivel'] === 'administrador') {
    header('Location: ../panel_administrador.php');
} else {
    header('Location: ../panel_usuario.php');
}
exit;
