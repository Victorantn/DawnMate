<?php
date_default_timezone_set('Europe/Paris');
echo json_encode([
    'time' => date('H:i'),
    'date' => strftime('%A %e %B')
]);
?>