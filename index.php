<?php
$tasksFile = 'tasks.json';
$tasks = [];
if (file_exists($tasksFile)) {
    $tasks = json_decode(file_get_contents($tasksFile), true) ?? [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My To-Do List</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>

  <div class="page">

    <header>
      <div class="header-top">
        <span class="logo">✓</span>
        <h1>Today's Tasks</h1>
      </div>
      <p class="subtitle">Stay focused. Get it done.</p>
    </header>

    <form id="addForm" class="add-form">
      <input
        type="text"
        id="taskInput"
        placeholder="What needs to be done?"
        autocomplete="off"
        maxlength="120"
      />
      <button type="submit">Add</button>
    </form>

    <div class="stats">
      <span id="totalCount">0 tasks</span>
      <span id="doneCount">0 done</span>
      <div class="progress-bar"><div id="progressFill" class="progress-fill"></div></div>
    </div>

    <ul class="task-list" id="taskList">
      <?php foreach ($tasks as $task): ?>
        <?php if (!empty($task['text'])): ?>
        <li class="task-item <?= $task['done'] ? 'done' : '' ?>" data-id="<?= htmlspecialchars($task['id']) ?>">
          <button class="check-btn" onclick="toggleTask('<?= htmlspecialchars($task['id']) ?>')">
            <span class="checkmark"><?= $task['done'] ? '✓' : '' ?></span>
          </button>
          <span class="task-text"><?= htmlspecialchars($task['text']) ?></span>
          <button class="delete-btn" onclick="deleteTask('<?= htmlspecialchars($task['id']) ?>')">✕</button>
        </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>

    <div class="empty-state" id="emptyState">
      <span>🎉</span>
      <p>No tasks yet — you're all clear!</p>
    </div>

    <div class="footer-actions">
      <button class="clear-btn" onclick="clearDone()">Clear completed</button>
    </div>

  </div>

  <script src="app.js"></script>
</body>
</html>