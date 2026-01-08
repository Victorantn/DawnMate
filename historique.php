<?php
$host = 'localhost:3306';
$dbname = 'mabase';
$username = 'phpmyadmin';
$password = 'tp';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_scenario = $_POST['id_scenario'] ?? 1;
    $date = $_POST['date_execution'] ?? date('Y-m-d H:i:s');

    $stmt = $pdo->prepare("INSERT INTO Historique (id_scenario, date_execution, statut_execution) VALUES (?, ?, ?)");
    $stmt->execute([$id_scenario, $date, 'Planifié']);
    echo "Inséré";
    exit;
}

$historique = $pdo->query("
    SELECT 
        h.id_historique,
        s.nom_scenario,
        h.date_execution
    FROM Historique h
    JOIN Scenario s ON h.id_scenario = s.id_scenario
    ORDER BY h.date_execution DESC")->fetchAll(PDO::FETCH_ASSOC);

date_default_timezone_set('Europe/Paris');
$now = new DateTime();

foreach ($historique as &$entry) {
    $execTime = new DateTime($entry['date_execution']);
    $entry['statut_execution'] = ($execTime < $now) ? 'Réussi' : 'Planifié';
}

header('Content-Type: application/json');
echo json_encode($historique);
?>