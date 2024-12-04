<?php
// Définir les informations de connexion à la base de données
$servername = "localhost"; // Nom du serveur (généralement localhost)
$username = "root"; // Nom d'utilisateur de la base de données
$password = ""; // Mot de passe de l'utilisateur de la base de données
$dbname = "SiteRestaurant"; // Nom de la base de données

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier si la connexion a échoué
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Si la connexion réussit, la variable $conn peut être utilisée dans d'autres fichiers PHP
// Vous pouvez inclure ce fichier dans vos autres pages pour y accéder
