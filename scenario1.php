<?php
// CONFIGURATION
$domoticz_ip = "http://192.168.4.1:8080"; // Adresse de Domoticz
$idx_volets = 1;         // IDX de la prise des volets
$idx_chauffe_eau = 2;    // IDX de la prise du chauffe-eau
$idx_cafe = 2;           // IDX de la machine à café (change si besoin)
$idx_mouvement = 21;     // IDX du capteur de mouvement
$timeout_max = 300;      // 5 minutes (en secondes)

// Fonctions
function activerPrise($idx) {
    global $domoticz_ip;
    file_get_contents("$domoticz_ip/json.htm?type=command&param=switchlight&idx=$idx&switchcmd=On");
    echo "Prise $idx activée.\n";
}

function estMouvementDetecte($idx) {
    global $domoticz_ip;
    $json = file_get_contents("$domoticz_ip/json.htm?type=devices&rid=$idx");
    $data = json_decode($json, true);
    return isset($data['result'][0]['Status']) && $data['result'][0]['Status'] == "On";
}

// ETAPE 1
activerPrise($idx_volets);       // Ouvre les volets
activerPrise($idx_chauffe_eau);  // Lance le chauffe-eau

// Attente capteur mouvement ou 5 minutes
$start_time = time();
$mouvement_detecte = false;

echo "Attente d’un mouvement ou 5 minutes...\n";

while ((time() - $start_time) < $timeout_max) {
    if (estMouvementDetecte($idx_mouvement)) {
        $mouvement_detecte = true;
        echo "Mouvement détecté !\n";
        break;
    }
    sleep(5); // vérifie toutes les 5 secondes
}

if (!$mouvement_detecte) {
    echo "5 minutes écoulées. Passage à l’étape 2.\n";
}

// ETAPE 2
activerPrise($idx_cafe); // Lance la machine à café
echo "Machine à café lancée.\n";
?>


