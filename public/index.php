<?php

require_once __DIR__ . '/../config/bootstrap.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
if (file_exists(dirname(__DIR__).'/.env')) {
    $dotenv->load();
}

try {
    $pdo = \App\Core\Database::getInstance();
    echo "Connexion à la base de données réussie.<br>";
} catch (Exception $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}