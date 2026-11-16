<?php
// Incluimos el archivo de configuración con las credenciales
require_once __DIR__ . '/config.php';

try {
    // Definimos el DSN (Data Source Name) especificando el host, el nombre de la BD y el charset
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    
    // Creamos la instancia de PDO
    $conexion = new PDO($dsn, DB_USER, DB_PASS);
    
    // Configuramos el modo de error de PDO para que lance excepciones ante fallos
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Opcional: configurar el modo de recuperación por defecto como objetos o arrays asociativos
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // (Opcional para pruebas) Descomenta la siguiente línea temporalmente para verificar el éxito:
    // echo "¡Conexión establecida con éxito a la base de datos " . DB_NAME . "!";

} catch (PDOException $e) {
    // Si falla la conexión, capturamos la excepción y detenemos la ejecución mostrando el error
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>