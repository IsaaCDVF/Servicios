# Guía paso a paso: Desplegar el Sistema de Servicios en un dominio o hosting

Esta guía te lleva de forma ordenada desde tu proyecto local hasta tener el sistema funcionando al 100% en un hosting (incluyendo base de datos y todas las funciones).

---

## Requisitos previos

- **Hosting** con:
  - PHP 7.4 o superior (recomendado 8.x)
  - MySQL o MariaDB
  - Soporte para sesiones de PHP
- **Dominio** apuntando al hosting (o subdominio).
- **Datos de acceso** que te dé el proveedor:
  - FTP / SFTP o administrador de archivos (ej. cPanel → Administrador de archivos)
  - Usuario y contraseña de **base de datos**
  - Nombre de la base de datos (a veces con prefijo, ej. `usuario_servicios`)

---

## Paso 1: Contratar / configurar hosting y base de datos

1. Contrata un plan que incluya PHP y MySQL (cualquier hosting compartido tipo cPanel suele servir).
2. En el panel del hosting (cPanel, Plesk, etc.):
   - Crea una **base de datos** (nombre ej. `servicios` o el que te asignen).
   - Crea un **usuario de MySQL** con contraseña segura.
   - Asigna ese usuario a la base de datos con **todos los privilegios**.
3. Anota en un lugar seguro:
   - Nombre del servidor MySQL (suele ser `localhost`).
   - Nombre de la base de datos.
   - Usuario de la base de datos.
   - Contraseña del usuario.
   - Puerto (normalmente `3306`).

---

## Paso 2: Importar la base de datos en el hosting

1. Entra al **phpMyAdmin** (o la herramienta de MySQL que ofrezca tu hosting):
   - En cPanel: sección “Bases de datos” → “phpMyAdmin”.
2. Selecciona la base de datos que creaste (ej. `servicios`).
3. Ve a la pestaña **“Importar”** / **“Import”**.
4. Elige el archivo:
   - En tu proyecto: **`sql/schema_completo.sql`**
5. Asegúrate de que el juego de caracteres sea **utf8mb4** (o UTF-8).
6. Pulsa **“Continuar”** / **“Import”**.
7. Si todo va bien, verás las tablas:
   - `nivel`
   - `usuario`
   - `negocios`
   Y un usuario administrador por defecto (ver Paso 3).

**Si el hosting no permite crear la base de datos desde el script** (solo la tabla): crea tú la base de datos desde el panel y luego importa solo el contenido del archivo, o abre `schema_completo.sql`, borra la línea `CREATE DATABASE...` y la línea `USE servicios;` y en phpMyAdmin selecciona primero tu base de datos y después importa el resto del script.

---

## Paso 3: Usuario administrador por defecto

El script **`sql/schema_completo.sql`** crea un usuario administrador de ejemplo:

- **Email:** `admin@tudominio.com`
- **Contraseña:** `Cambiar123`

**Qué hacer:**

1. Tras el primer acceso, ve a **Mi perfil** (como administrador) y **cambia el email y la contraseña** por los reales.
2. Si quieres usar otro email desde el inicio, antes de importar edita el archivo `sql/schema_completo.sql`, busca la línea del `INSERT INTO usuario` y cambia el email y la contraseña (luego vuelve a importar o ejecuta solo ese `INSERT` en phpMyAdmin).

---

## Paso 4: Configurar la conexión a la base de datos en el servidor

1. En tu proyecto, en la carpeta **`config`**:
   - Hay un archivo de ejemplo: **`connect_db.ejemplo.php`**.
   - Copia su contenido o crea **`connect_db.php`** en el servidor (si no lo subes desde tu PC).
2. Abre **`config/connect_db.php`** y pon los datos **reales** de tu hosting:

```php
<?php
class Conectar {
    public static function conexion(){
        $servidor = "localhost";        // Lo que te indique el hosting (casi siempre localhost)
        $usuario = "tu_usuario_bd";     // Usuario MySQL del hosting
        $pass = "tu_contraseña_bd";    // Contraseña de ese usuario
        $bd = "servicios";              // Nombre de la base de datos (con prefijo si lo tiene)
        $puerto = 3306;

        $link = new MySQLi($servidor, $usuario, $pass, $bd, $puerto);
        $link->set_charset("utf8");

        if (mysqli_connect_error()) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        return $link;
    }
}
```

3. Sustituye:
   - `tu_usuario_bd` → usuario de MySQL.
   - `tu_contraseña_bd` → contraseña de MySQL.
   - `servicios` → nombre exacto de la base de datos en el hosting (con prefijo si aplica).
4. Guarda el archivo.

---

## Paso 5: Subir los archivos del proyecto al hosting

1. Conéctate por **FTP/SFTP** (FileZilla, WinSCP, etc.) o usa el **Administrador de archivos** del panel (cPanel, etc.).
2. Entra en la carpeta donde se sirve la web:
   - Suele ser: **`public_html`** (o **`www`**, **`httpdocs`**, según el panel).
   - Para un subdominio puede ser algo como **`public_html/servicios`** o la carpeta que te indiquen.
3. Sube **toda** la estructura del proyecto, por ejemplo:

```
public_html/   (o la carpeta que corresponda)
├── index.php
├── panel_usuario.php
├── panel_administrador.php
├── .htaccess
├── assets/
│   ├── estilos.css
│   └── login.css
├── auth/
│   ├── login.php
│   └── logout.php
├── config/
│   ├── connect_db.php    ← con datos del hosting
│   ├── connect_db.ejemplo.php
│   └── BD.php
├── includes/
│   ├── menu_usuario.php
│   ├── menu_admin.php
│   └── session.php
├── usuario/
│   ├── mi_perfil.php
│   ├── buscar_negocios.php
│   ├── modificar_usuarios.php
│   ├── buscar_usuarios.php
│   └── abc_negocios.php
├── admin/
│   ├── mi_perfil.php
│   ├── buscar_negocios.php
│   ├── modificar_usuarios.php
│   ├── buscar_usuarios.php
│   └── abc_negocios.php
└── sql/
    ├── schema_completo.sql
    └── negocios.sql
```

4. **Importante:**  
   - Asegúrate de subir **`config/connect_db.php`** ya editado con los datos del hosting (Paso 4).  
   - No hace falta subir la carpeta **`sql`** para que el sitio funcione, pero no pasa nada si la subes (el `.htaccess` intenta impedir que se acceda por URL).

---

## Paso 6: Permisos (si el hosting lo requiere)

En la mayoría de hostings compartidos no hace falta tocar permisos. Si algo falla:

- Carpetas: **755**
- Archivos `.php` y `.css`: **644**
- No des permisos 777 a carpetas con datos sensibles si no es estrictamente necesario.

---

## Paso 7: Probar que todo funciona

1. **Dominio:** Abre en el navegador la URL de tu sitio (ej. `https://tudominio.com` o `https://tudominio.com/servicios` si está en subcarpeta).
2. Deberías ver la **pantalla de login**.
3. Inicia sesión con el administrador por defecto (o el que hayas configurado en el Paso 3).
4. Comprueba:
   - Panel de administrador.
   - Mi perfil (cambiar datos y contraseña).
   - Buscar negocios.
   - Modificar usuarios, buscar usuarios, ABC negocios.
5. Cierra sesión y entra con un usuario de nivel “usuario” (si ya creaste uno) y revisa:
   - Mi perfil.
   - Buscar negocios.

Si algo no carga (páginas en blanco, errores), sigue el Paso 8.

---

## Paso 8: Errores frecuentes y qué revisar

| Problema | Qué revisar |
|----------|-------------|
| Página en blanco | Activa temporalmente errores de PHP en el hosting o revisa el registro de errores del panel. Revisa que `connect_db.php` tenga bien usuario, contraseña y nombre de BD. |
| “Conexión fallida” | Datos en `config/connect_db.php`: servidor, usuario, contraseña, nombre de BD y puerto. Que el usuario tenga privilegios sobre esa base de datos. |
| “No se encontraron negocios” / errores en ABC | Que hayas importado `schema_completo.sql` y existan las tablas `nivel`, `usuario` y `negocios`. |
| No redirige bien (404 o enlaces rotos) | Que la URL base sea la correcta (dominio o subcarpeta). Si está en una subcarpeta (ej. `/servicios/`), los enlaces relativos ya deberían funcionar; si usas otra estructura, puede que haya que ajustar rutas. |
| Sesión no se mantiene | En el hosting, que las sesiones de PHP estén habilitadas y que no se esté limpiando la cookie de sesión (por ejemplo por políticas de cookies del dominio). |
| Imágenes del login / menú no cargan | Las imágenes usan URLs de Unsplash; hace falta conexión a internet desde el servidor. Si el hosting bloquea salida a internet, las imágenes no se verán (el resto del sistema sí puede funcionar). |

---

## Paso 9: Seguridad recomendada después del despliegue

1. **Cambiar** el usuario y contraseña del administrador por defecto (Paso 3).
2. **No dejar** contraseñas fáciles en la base de datos; si más adelante implementas `password_hash()` en el registro y en el login, úsalo también para este usuario.
3. Mantener **`config/connect_db.php`** fuera del acceso público (el `.htaccess` incluido intenta denegar el acceso a la carpeta `config/` por URL).
4. Hacer **copias de seguridad** periódicas de la base de datos desde el panel del hosting (phpMyAdmin → Exportar).
5. Si el hosting ofrece **HTTPS**, actívalo para el dominio (certificado SSL).

---

## Resumen rápido

1. Crear base de datos y usuario MySQL en el hosting.  
2. Importar **`sql/schema_completo.sql`** en esa base de datos.  
3. Editar **`config/connect_db.php`** con servidor, usuario, contraseña y nombre de BD.  
4. Subir todos los archivos del proyecto a la carpeta pública (ej. `public_html`).  
5. Probar login, paneles y todas las funciones.  
6. Cambiar contraseña del administrador y revisar seguridad y backups.

Si en algún paso concreto tu panel o hosting se ve distinto (por ejemplo otro nombre de carpeta o de base de datos), dime qué ves y te indico los ajustes exactos para tu caso.
