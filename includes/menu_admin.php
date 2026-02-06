<?php
// Incluir en páginas de nivel Administrador. Definir $pagina_activa: 'inicio' | 'mi_perfil' | 'buscar_negocios' | 'modificar_usuarios' | 'buscar_usuarios' | 'abc_negocios'
$self = str_replace('\\', '/', $_SERVER['PHP_SELF']);
$base = (strpos($self, 'admin/') !== false) ? '../' : '';
$icon_home = '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><path d="M9 22V12h6v10"/></svg>';
$icon_user = '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>';
$icon_search = '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>';
$icon_users = '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>';
$icon_briefcase = '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>';
$icon_logout = '<svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>';
?>
<div class="menu-overlay" id="menuOverlay" aria-hidden="true"></div>
<button type="button" class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
</button>
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=80&h=80&fit=crop" alt="" width="36" height="36" loading="lazy">
        <span>Administrador</span>
    </div>
    <nav class="sidebar-nav">
        <a href="<?php echo $base; ?>panel_administrador.php" class="nav-item <?php echo ($pagina_activa ?? '') === 'inicio' ? 'activo' : ''; ?>"><?php echo $icon_home; ?><span>Inicio</span></a>
        <a href="<?php echo $base; ?>admin/mi_perfil.php" class="nav-item <?php echo ($pagina_activa ?? '') === 'mi_perfil' ? 'activo' : ''; ?>"><?php echo $icon_user; ?><span>Mi perfil</span></a>
        <a href="<?php echo $base; ?>admin/buscar_negocios.php" class="nav-item <?php echo ($pagina_activa ?? '') === 'buscar_negocios' ? 'activo' : ''; ?>"><?php echo $icon_search; ?><span>Buscar negocios</span></a>
        <a href="<?php echo $base; ?>admin/modificar_usuarios.php" class="nav-item <?php echo ($pagina_activa ?? '') === 'modificar_usuarios' ? 'activo' : ''; ?>"><?php echo $icon_users; ?><span>Modificar usuarios</span></a>
        <a href="<?php echo $base; ?>admin/buscar_usuarios.php" class="nav-item <?php echo ($pagina_activa ?? '') === 'buscar_usuarios' ? 'activo' : ''; ?>"><?php echo $icon_search; ?><span>Buscar usuarios</span></a>
        <a href="<?php echo $base; ?>admin/abc_negocios.php" class="nav-item <?php echo ($pagina_activa ?? '') === 'abc_negocios' ? 'activo' : ''; ?>"><?php echo $icon_briefcase; ?><span>ABC Negocios</span></a>
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
