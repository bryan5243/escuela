<?php
function conectarBaseDeDatos()
{
    $host = 'sfo1.clusters.zeabur.com';
    $port = '31201'; // Puerto por defecto de MySQL
    $dbname = 'zeabur'; // Nombre de la base de datos MySQL
    $user = 'root'; // Nombre de usuario de MySQL
    $password = '3481jMx56boW2LZK7Th9qAQGcaDpVu0e'; // Contraseña de MySQL

    // Conexión a la base de datos
    try {
        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);
        // Configuración para manejar errores y excepciones de PDO
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit(); // Si hay un error, termina el script
    }
    return $pdo;
}
?>