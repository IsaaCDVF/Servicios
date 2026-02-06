# Cómo subir el proyecto a GitHub

Sigue estos pasos para publicar el Sistema de Servicios en un repositorio de GitHub. Así podrás tener copia en la nube, compartir el código y desplegarlo desde ahí si quieres.

---

## Importante: archivos que no se suben

El archivo **`.gitignore`** hace que **no se suba** `config/connect_db.php` (donde están usuario y contraseña de la base de datos). En el repositorio solo quedará el ejemplo `connect_db.ejemplo.php`. Quien clone el proyecto tendrá que crear su propio `connect_db.php` a partir del ejemplo.

---

## Paso 1: Instalar Git (si no lo tienes)

1. Entra en: **https://git-scm.com/downloads**
2. Descarga Git para Windows y instálalo (opciones por defecto suelen ir bien).
3. Abre una terminal (PowerShell o CMD) y comprueba:
   ```bash
   git --version
   ```
   Deberías ver algo como `git version 2.x.x`.

---

## Paso 2: Crear una cuenta y un repositorio en GitHub

1. Si no tienes cuenta: **https://github.com** → “Sign up”.
2. Inicia sesión y haz clic en **“New”** (o “New repository”).
3. Rellena:
   - **Repository name:** por ejemplo `Servicios` o `sistema-servicios`.
   - **Description:** (opcional) “Sistema de login y paneles Usuario/Administrador”.
   - **Public** o **Private**, como prefieras.
   - No marques “Add a README”, “.gitignore” ni “License” (el proyecto ya tiene su propio `.gitignore`).
4. Pulsa **“Create repository”**.
5. En la página del repositorio verás una URL, algo como:
   ```text
   https://github.com/TU_USUARIO/Servicios.git
   ```
   Cópiala; la usarás en el Paso 5.

---

## Paso 3: Abrir la terminal en la carpeta del proyecto

En la carpeta donde está el proyecto (por ejemplo `C:\xampp\htdocs\Servicios`):

- **En Cursor/VS Code:** menú **Terminal** → **New Terminal** (o `` Ctrl+` ``).  
  Si la terminal no está en esa carpeta, escribe:
  ```bash
  cd C:\xampp\htdocs\Servicios
  ```
- **En Windows:** puedes abrir PowerShell o CMD, ir a esa carpeta con `cd` y ejecutar los comandos desde ahí.

---

## Paso 4: Inicializar Git y hacer el primer commit

Ejecuta estos comandos **uno tras otro** en la carpeta del proyecto:

```bash
git init
```

```bash
git add .
```

(El punto añade todos los archivos; los que están en `.gitignore`, como `connect_db.php`, no se incluyen.)

```bash
git status
```

(Comprueba que no aparezca `config/connect_db.php` en la lista de archivos a subir.)

```bash
git commit -m "Primer commit: Sistema de Servicios con login y paneles"
```

Con esto ya tienes el primer commit en tu máquina.

---

## Paso 5: Conectar con GitHub y subir el código

Sustituye `TU_USUARIO` y `Servicios` por tu usuario de GitHub y el nombre del repositorio.

```bash
git remote add origin https://github.com/TU_USUARIO/Servicios.git
```

```bash
git branch -M main
```

```bash
git push -u origin main
```

Te pedirá **usuario y contraseña**. En GitHub ya no se usa la contraseña de la cuenta para `git push`; hay que usar un **Personal Access Token (PAT)**:

1. En GitHub: **Settings** (de tu perfil) → **Developer settings** → **Personal access tokens** → **Tokens (classic)**.
2. **Generate new token (classic)**.
3. Ponle un nombre (ej. “Servicios”) y marca el permiso **repo**.
4. Genera el token y **cópialo** (solo se muestra una vez).
5. Cuando `git push` pida contraseña, **pega el token** (no tu contraseña de GitHub).

Si todo va bien, verás el código en la página del repositorio en GitHub.

---

## Resumen rápido de comandos

```bash
cd C:\xampp\htdocs\Servicios
git init
git add .
git commit -m "Primer commit: Sistema de Servicios"
git remote add origin https://github.com/TU_USUARIO/Servicios.git
git branch -M main
git push -u origin main
```

(Sustituye la URL por la de tu repositorio.)

---

## Después del primer push: cambios futuros

Cuando cambies algo en el proyecto y quieras subirlo:

```bash
git add .
git commit -m "Descripción breve del cambio"
git push
```

---

## Si ya tienes Git configurado en Cursor

Si usas la integración de Git de Cursor/VS Code:

1. **Source Control** (icono de ramas o `Ctrl+Shift+G`).
2. **Initialize Repository** si es la primera vez (equivale a `git init`).
3. Escribe el mensaje del commit y haz clic en ✓ para hacer commit.
4. En “Publish to GitHub” o en la sección “Remote” añade la URL del repositorio y haz push.

Los pasos de crear el repo en GitHub y no subir `connect_db.php` (usando el `.gitignore`) siguen siendo los mismos.

---

## Comprobar que no se sube la configuración

En la página del repositorio en GitHub, entra en la carpeta **`config`**. Debes ver:

- `BD.php`
- `connect_db.ejemplo.php`

y **no** debe aparecer **`connect_db.php`**. Si apareciera, quitaría las credenciales del ejemplo en el repo y tendrías que rotar la contraseña de la base de datos por seguridad.
