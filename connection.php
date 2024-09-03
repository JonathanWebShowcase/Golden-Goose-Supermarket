<?php 
    $host = '127.0.0.1';
    $db   = 'newgoldengoose';
    $user = 'root';
    $pass = '';

    $dsn = "mysql:host=$host;dbname=$db;";
    try {
        $pdo = new PDO($dsn, $user, $pass);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
?>