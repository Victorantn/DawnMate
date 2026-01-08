<?php
$ch = curl_init("http://192.168.4.1:8080/json.htm?type=devices&rid=16");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
curl_close($ch);

$reponse = json_decode($output);

if (isset($reponse->result[0])) {
    $temp = $reponse->result[0]->Temp ?? "N/A";
    $hum = $reponse->result[0]->Humidity ?? "N/A";
    echo "Température : $temp °C<br>";
    echo "Humidité : $hum %";
} else {
    echo "Erreur : capteur non trouvé ou données invalides.";
}
?>