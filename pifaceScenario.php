<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['scenario'])) {
    $scenario = $_POST['scenario'];

    switch ($scenario) {
        case 'semaine':
            system('sudo /home/pi/piface/libpifacecad/pifacecad clear');
            system('sudo /home/pi/piface/libpifacecad/pifacecad backlight off');

            system('/home/pi/piface/libpifacecad/pifacecad open');
            system('/home/pi/piface/libpifacecad/pifacecad write "Reveil Semaine"');
            system('/home/pi/piface/libpifacecad/pifacecad backlight on');
            break;
        
        case 'weekend':
            system('sudo /home/pi/piface/libpifacecad/pifacecad clear');
            system('sudo /home/pi/piface/libpifacecad/pifacecad backlight off');
            
            system('/home/pi/piface/libpifacecad/pifacecad open');
            system('/home/pi/piface/libpifacecad/pifacecad write "Reveil Week-End"');
            system('/home/pi/piface/libpifacecad/pifacecad backlight on');
            break;
        
        case 'vacances':
            system('sudo /home/pi/piface/libpifacecad/pifacecad clear');
            system('sudo /home/pi/piface/libpifacecad/pifacecad backlight off');
            
            system('/home/pi/piface/libpifacecad/pifacecad open');
            system('/home/pi/piface/libpifacecad/pifacecad write "Reveil Vacances"');
            system('/home/pi/piface/libpifacecad/pifacecad backlight on');
            break;

        default:
            http_response_code(400);
            echo 'Scénario invalide.';
            exit;
    }
    
    echo 'OK';
} else {
    http_response_code(405);
    echo 'Méthode non autorisée.';
}
?>
