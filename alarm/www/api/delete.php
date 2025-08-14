<?php
header('Content-Type: application/json');

$alarmsFile = '../data/alarms.json';
$id = isset($_GET['id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['id']) : '';

if (empty($id) || !file_exists($alarmsFile)) {
    echo json_encode(array('success' => false));
    exit;
}

$alarms = json_decode(file_get_contents($alarmsFile), true);
if (!is_array($alarms)) {
    echo json_encode(array('success' => false));
    exit;
}

$filtered = array();
foreach ($alarms as $a) {
    if ($a['id'] !== $id) {
        $filtered[] = $a;
    }
}

$result = file_put_contents($alarmsFile, json_encode(array_values($filtered)));
if ($result !== false) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false));
}