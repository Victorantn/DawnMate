<?php
$nom = $_POST['scenario'] ?? null;
$heure = $_POST['heure'] ?? null;

if (!$nom || !$heure) exit;

$map = [
    'semaine' => '/var/www/html/DawnMate/DawnMate/scenario1.php',
    'weekend' => '/var/www/html/DawnMate/DawnMate/scenario1.php',
    'vacances' => '/var/www/html/DawnMate/DawnMate/scenario1.php'
];

if (!array_key_exists($nom, $map)) exit;

$chemin_script = $map[$nom];
$commande = "php $chemin_script";

// Préparer la date
$now = new DateTime();
$heureObj = DateTime::createFromFormat('H:i', $heure);
if (!$heureObj) exit;

$heureObj->setDate($now->format('Y'), $now->format('m'), $now->format('d'));
if ($heureObj < $now) $heureObj->modify('+1 day');

$timestamp = $heureObj->format('H:i d M Y');

// Planification silencieuse
exec("echo '$commande' | at '$timestamp' > /dev/null 2>&1 &");
?>
