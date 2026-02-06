<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['nivel'])) {
    $self = str_replace('\\', '/', $_SERVER['PHP_SELF']);
    $base = (strpos($self, 'usuario/') !== false || strpos($self, 'admin/') !== false) ? '../' : '';
    header('Location: ' . $base . 'index.php');
    exit;
}

function _base_url() {
    $self = str_replace('\\', '/', $_SERVER['PHP_SELF']);
    return (strpos($self, 'usuario/') !== false || strpos($self, 'admin/') !== false) ? '../' : '';
}

/**
 * Requiere que el usuario sea de nivel 'administrador'.
 * Incluir después de session.php en páginas solo de admin.
 */
function requerir_administrador() {
    if (empty($_SESSION['nivel']) || $_SESSION['nivel'] !== 'administrador') {
        header('Location: ' . _base_url() . 'panel_usuario.php');
        exit;
    }
}

/**
 * Requiere que el usuario sea de nivel 'usuario' (no administrador).
 * Incluir después de session.php en páginas solo de usuario.
 */
function requerir_usuario() {
    if (empty($_SESSION['nivel']) || $_SESSION['nivel'] === 'administrador') {
        header('Location: ' . _base_url() . 'panel_administrador.php');
        exit;
    }
}
