<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=ecfbackend;charset=utf8', 'root'); // Connexion à la DB avec mot de passe // Nom DB > ecf
    $pdo->exec('SET NAMES "UTF8"'); // Pour que tous les échanges avec la DB se fasse en table de caractères UTF8
} 

catch(PDOException $e) {
    echo 'Erreur(s) : '. $e->getMessage();
    die();
}