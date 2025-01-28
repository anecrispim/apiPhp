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

function saveMonsters($filePath, $monsters) {
    file_put_contents($filePath, json_encode($monsters, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['name'], $input['size'], $input['type'], $input['alignment'], $input['actions'])) {
        http_response_code(400);
        echo json_encode(["error" => "Missing required fields: name, size, type, alignment, actions"]);
        exit;
    }

    $newMonster = [
        "id" => uniqid(),
        "name" => $input['name'],
        "size" => $input['size'],
        "type" => $input['type'],
        "alignment" => $input['alignment'],
        "actions" => $input['actions']
    ];

    $monsters = loadMonsters($jsonFile);

    $monsters[] = $newMonster;

    saveMonsters($jsonFile, $monsters);

    http_response_code(201);
    echo json_encode($newMonster);
} else {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed. Use POST."]);
}
