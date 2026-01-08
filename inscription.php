<?php
// Connexion à la BD
$host = 'localhost:3306';
$dbname = 'mabase';
$username = 'phpmyadmin';
$password = 'tp'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifie que le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $identifiant = $_POST['identifiant'] ?? '';
    $mdp = $_POST['mdp'] ?? '';
    $mdp_confirm = $_POST['mdp_confirm'] ?? '';

    // Vérifie si tous les champs sont remplis
    if (empty($prenom) || empty($nom) || empty($identifiant) || empty($mdp) || empty($mdp_confirm)) {
        echo "Veuillez remplir tous les champs.";
        exit();
    }

    // Vérifie si les mots de passe correspondent
    if ($mdp !== $mdp_confirm) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }

    // Vérifie si l'identifiant est déjà utilisé
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE identifiantU = ?");
    $stmt->execute([$identifiant]);

    if ($stmt->fetch()) {
        echo "Cet identifiant est déjà utilisé.";
        exit();
    }


    // Insertion dans la BD
    $insert = $pdo->prepare("INSERT INTO Utilisateur (prenomU, nomU, identifiantU, mdpU) VALUES (?, ?, ?, ?)");
    $insert->execute([$prenom, $nom, $identifiant, $mdp]);

    // Redirection vers la page de connexion
    header('Location: loginU.html');
    exit();
} else {
    echo "Méthode non autorisée.";
    exit();
}
?>
