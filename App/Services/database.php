<?php

function getDatabaseConnection() {
    $host = 'localhost'; // Remplacez par l'hôte de votre base de données
    $dbname = 'nom_de_votre_base'; // Remplacez par le nom de votre base de données
    $username = 'root'; // Remplacez par votre nom d'utilisateur
    $password = ''; // Remplacez par votre mot de passe

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}