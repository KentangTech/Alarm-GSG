<?php
header('Content-Type: application/json');

$alarmsFile = '../data/alarms.json';
$alarms = array();

if (file_exists($alarmsFile)) {
    $json = file_get_contents($alarmsFile);
    $decoded = json_decode($json, true);
    $alarms = is_array($decoded) ? $decoded : array();
}

echo json_encode($alarms);