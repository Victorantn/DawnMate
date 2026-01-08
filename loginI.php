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

// Vérifie que les champs ont été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = $_POST['pseudo'] ?? '';
    $mdp = $_POST['pwd'] ?? '';

    if (empty($identifiant) || empty($mdp)) {
        header('Location: loginI.html');
        exit();
    }

    // Recherche de l'utilisateur par identifiant
    $stmt = $pdo->prepare("SELECT * FROM Installateur WHERE identifiant = ?");
    $stmt->execute([$identifiant]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérifie le mot de passe
        if ($mdp == $user['mdp']) {
            // Connexion réussie, redirige vers la page des scenariios
            header('Location: scenarioU.html');
            exit();
        } else {
            // Mauvais mot de passe
            header('Location: loginI.html');
            exit();
        }
    } else {
        // Identifiant inexistant -> rediriger vers la page inscription
        header('Location: loginI.html');
        exit();
    }
} else {
    header('Location: loginI.html');
    exit();
}
?>
