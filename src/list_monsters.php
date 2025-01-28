<?php
header("Content-Type: application/json");

$jsonFile = 'monsters.json';

function loadMonsters($filePath) {
    if (!file_exists($filePath)) {
        return [];
    }

    $jsonContent = file_get_contents($filePath);
    return json_decode($jsonContent, true) ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $monsters = loadMonsters($jsonFile);

    echo json_encode($monsters, JSON_PRETTY_PRINT);
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed. Use GET."]);
}
