<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$body  = file_get_contents('php://input');
$tasks = json_decode($body, true);

if (!is_array($tasks)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit;
}

$clean = [];
foreach ($tasks as $task) {
    if (!isset($task['id'], $task['text'])) continue;
    $clean[] = [
        'id'   => preg_replace('/[^a-z0-9_]/', '', $task['id']),
        'text' => htmlspecialchars(strip_tags(trim($task['text'])), ENT_QUOTES, 'UTF-8'),
        'done' => !empty($task['done']) ? true : false
    ];
}

$file   = __DIR__ . '/tasks.json';
$result = file_put_contents($file, json_encode($clean, JSON_PRETTY_PRINT));

if ($result === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Could not write file']);
    exit;
}

echo json_encode(['success' => true, 'saved' => count($clean)]);
?>
```

---

## File 5 — `tasks.json`
Click `tasks.json`, type this exactly, press `Ctrl + S`:
```
[]
```

---

## Final step — open your browser and go to:
```
http://localhost/todo-app/