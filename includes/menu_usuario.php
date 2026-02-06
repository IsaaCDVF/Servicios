<?php
// Incluir en páginas de nivel Usuario. Definir $pagina_activa: 'inicio' | 'mi_perfil' | 'buscar_negocios'
$self = str_replace('\\', '/', $_SERVER['PHP_SELF']);
$base = (strpos($self, 'usuario/') !== false) ? '../' : '';
$icon_home = '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path d="M9 22V12h6v10"/></svg>';
$icon_user = '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>';
$icon_search = '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>';
$icon_logout = '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>';
?>
<div class="menu-overlay" id="menuOverlay" aria-hidden="true"></div>
<button type="button" class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=80&h=80&fit=crop" alt="" width="36" height="36" loading="lazy">
        <span>Usuario</span>
    </div>
    <nav class="sidebar-nav">
        <a href="<?php echo $base; ?>panel_usuario.php" class="nav-item <?php echo ($pagina_activa ?? '') === 'inicio' ? 'activo' : ''; ?>"><?php echo $icon_home; ?><span>Inicio</span></a>
        <a href="<?php echo $base; ?>usuario/mi_perfil.php" class="nav-item <?php echo ($pagina_activa ?? '') === 'mi_perfil' ? 'activo' : ''; ?>"><?php echo $icon_user; ?><span>Mi perfil</span></a>
        <a href="<?php echo $base; ?>usuario/buscar_negocios.php" class="nav-item <?php echo ($pagina_activa ?? '') === 'buscar_negocios' ? 'activo' : ''; ?>"><?php echo $icon_search; ?><span>Buscar negocios</span></a>
        <a href="<?php echo $base; ?>auth/logout.php" class="nav-item btn-salir"><?php echo $icon_logout; ?><span>Cerrar sesión</span></a>
    </nav>
</aside>
<script>
(function(){
    var t=document.getElementById('menuToggle'),o=document.getElementById('menuOverlay');
    if(t){t.addEventListener('click',function(){ document.body.classList.toggle('sidebar-open'); });}
    if(o){o.addEventListener('click',function(){ document.body.classList.remove('sidebar-open'); });}
})();
</script>
