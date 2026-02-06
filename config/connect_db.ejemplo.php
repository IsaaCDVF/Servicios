<?php
/**
 * Ejemplo de configuración para producción.
 * Copia este archivo como connect_db.php y rellena los datos que te dé tu hosting.
 */
class Conectar {
    public static function conexion(){
        $servidor = "localhost";           // Suele ser "localhost" en hosting compartido
        $usuario = "tu_usuario_bd";        // Usuario de MySQL que te asigna el hosting
        $pass = "tu_contraseña_bd";        // Contraseña de ese usuario
        $bd = "servicios";                 // Nombre de la base de datos (a veces con prefijo, ej: usuario_servicios)
        $puerto = 3306;                    // 3306 es lo habitual; algunos hostings usan otro

        $link = new MySQLi($servidor, $usuario, $pass, $bd, $puerto);
        $link->set_charset("utf8");

        if (mysqli_connect_error()) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        return $link;
    }
}
