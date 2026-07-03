<?php
session_start();

// If already logged in, go to dashboard
if (isset($_SESSION['logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Your username and password — change these!
    if ($username === 'samuel' && $password === 'samuel123') {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Wrong username or password. Try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    .login-wrap {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-card {
      background: #1a1a1a;
      border: 1.5px solid #2e2e2e;
      border-radius: 16px;
      padding: 48px 40px;
      width: 100%;
      max-width: 400px;
    }
    .login-logo {
      width: 48px;
      height: 48px;
      background: #c8f542;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      font-weight: 800;
      color: #0f0f0f;
      margin-bottom: 24px;
    }
    .login-title {
      font-family: 'Syne', sans-serif;
      font-size: 28px;
      font-weight: 800;
      color: #f0ede6;
      margin-bottom: 6px;
    }
    .login-sub {
      color: #6b6b6b;
      font-size: 14px;
      margin-bottom: 32px;
    }
    .field { margin-bottom: 16px; }
    .field label {
      display: block;
      font-size: 13px;
      color: #6b6b6b;
      margin-bottom: 6px;
    }
    .field input {
      width: 100%;
      background: #222;
      border: 1.5px solid #2e2e2e;
      color: #f0ede6;
      font-family: 'DM Sans', sans-serif;
      font-size: 15px;
      padding: 12px 16px;
      border-radius: 10px;
      outline: none;
      box-sizing: border-box;
      transition: border-color 0.2s;
    }
    .field input:focus { border-color: #c8f542; }
    .login-btn {
      width: 100%;
      background: #c8f542;
      color: #0f0f0f;
      border: none;
      font-family: 'Syne', sans-serif;
      font-weight: 700;
      font-size: 16px;
      padding: 14px;
      border-radius: 10px;
      cursor: pointer;
      margin-top: 8px;
      transition: background 0.15s;
    }
    .login-btn:hover { background: #a3cc2e; }
    .error {
      background: rgba(255,77,77,0.1);
      border: 1px solid rgba(255,77,77,0.3);
      color: #ff4d4d;
      padding: 10px 14px;
      border-radius: 8px;
      font-size: 13px;
      margin-bottom: 16px;
    }
  </style>
</head>
<body>
  <div class="login-wrap">
    <div class="login-card">
      <div class="login-logo">✓</div>
      <div class="login-title">Welcome back</div>
      <div class="login-sub">Log in to access your tasks</div>

      <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="field">
          <label>Username</label>
          <input type="text" name="username" placeholder="Enter username" required/>
        </div>
        <div class="field">
          <label>Password</label>
          <input type="password" name="password" placeholder="Enter password" required/>
        </div>
        <button type="submit" class="login-btn">Log in</button>
      </form>
    </div>
  </div>
</body>
</html>