<?php

    $host = 'monorail.proxy.rlwy.net';
    $port = '54739'; // Puerto por defecto de MySQL
    $dbname = 'arias'; // Nombre de la base de datos MySQL
    $user = 'root'; // Nombre de usuario de MySQL
    $password = 'dC6A24GC53FG2E1-B5BFh3fF511GFgGD'; // Contraseña de MySQL

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
?>