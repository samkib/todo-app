<?php
session_start();

// If not logged in, send back to login
if (!isset($_SESSION['logged_in'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Load tasks to show stats
$tasksFile = 'tasks.json';
$tasks = [];
if (file_exists($tasksFile)) {
    $tasks = json_decode(file_get_contents($tasksFile), true) ?? [];
}

$total = count($tasks);
$done  = count(array_filter($tasks, fn($t) => $t['done']));
$pending = $total - $done;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    .dash-wrap {
      max-width: 620px;
      margin: 0 auto;
      padding: 60px 16px;
    }
    .dash-header {
      margin-bottom: 40px;
    }
    .dash-greeting {
      font-family: 'Syne', sans-serif;
      font-size: 32px;
      font-weight: 800;
      color: #f0ede6;
      margin-bottom: 6px;
    }
    .dash-greeting span { color: #c8f542; }
    .dash-sub {
      color: #6b6b6b;
      font-size: 14px;
    }
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px;
      margin-bottom: 32px;
    }
    .stat-card {
      background: #1a1a1a;
      border: 1.5px solid #2e2e2e;
      border-radius: 14px;
      padding: 20px;
      text-align: center;
    }
    .stat-number {
      font-family: 'Syne', sans-serif;
      font-size: 36px;
      font-weight: 800;
      color: #c8f542;
      line-height: 1;
      margin-bottom: 6px;
    }
    .stat-label {
      font-size: 12px;
      color: #6b6b6b;
    }
    .dash-btn {
      display: block;
      width: 100%;
      background: #c8f542;
      color: #0f0f0f;
      border: none;
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 16px;
      padding: 16px;
      border-radius: 12px;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
      margin-bottom: 12px;
      transition: background 0.15s;
      box-sizing: border-box;
    }
    .dash-btn:hover { background: #a3cc2e; }
    .dash-btn.outline {
      background: transparent;
      border: 1.5px solid #2e2e2e;
      color: #6b6b6b;
    }
    .dash-btn.outline:hover {
      border-color: #ff4d4d;
      color: #ff4d4d;
    }
  </style>
</head>
<body>
  <div class="dash-wrap">

    <div class="dash-header">
      <div class="dash-greeting">
        Hello, <span><?= htmlspecialchars(ucfirst($username)) ?></span> 👋
      </div>
      <div class="dash-sub">Here's your task summary for today</div>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-number"><?= $total ?></div>
        <div class="stat-label">Total tasks</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?= $done ?></div>
        <div class="stat-label">Completed</div>
      </div>
      <div class="stat-card">
        <div class="stat-number"><?= $pending ?></div>
        <div class="stat-label">Pending</div>
      </div>
    </div>

    <a href="index.php" class="dash-btn">Go to My Tasks</a>
    <a href="logout.php" class="dash-btn outline">Log out</a>

  </div>
</body>
</html>