<?php
header('Content-Type: application/json');

$alarmsFile = '../data/alarms.json';
$alarms = array();

if (file_exists($alarmsFile)) {
    $json = file_get_contents($alarmsFile);
    $decoded = json_decode($json, true);
    $alarms = is_array($decoded) ? $decoded : array();
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$time = isset($_POST['time']) ? $_POST['time'] : '';
$days = isset($_POST['days']) && is_array($_POST['days']) ? $_POST['days'] : array();
$validTime = preg_match('/^\d{2}:\d{2}$/', $time);
$validDays = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
$days = array_values(array_unique(array_intersect($days, $validDays)));

if ($name !== '' && $validTime && !empty($days)) {
    $id = uniqid();
    $audioFile = 'alarm.mp3';

    if (isset($_FILES['audio']) && $_FILES['audio']['error'] === 0) {
        $ext = strtolower(pathinfo($_FILES['audio']['name'], PATHINFO_EXTENSION));
        $allowed = array('mp3', 'wav', 'ogg');
        if (in_array($ext, $allowed)) {
            $fileName = 'alarm_' . $id . '.' . $ext;
            $uploadPath = '../sounds/' . $fileName;
            if (move_uploaded_file($_FILES['audio']['tmp_name'], $uploadPath)) {
                $audioFile = $fileName;
            }
        }
    }

    $alarms[] = array(
        'id' => $id,
        'name' => $name,
        'time' => $time,
        'days' => $days,
        'audio' => $audioFile
    );

    $result = file_put_contents($alarmsFile, json_encode($alarms));
    if ($result !== false) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'error' => 'Gagal simpan.'));
    }
} else {
    echo json_encode(array('success' => false, 'error' => 'Data tidak valid.'));
}