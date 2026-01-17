 <?php
session_start();
require "db.php";

$error = "";

// Agar csrf token session me nahi hai to generate kar do
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ✅ CSRF check
    if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
        $error = "Invalid request. Please try again.";
    } else {
        $username = trim($_POST["username"]);
        $password = $_POST["password"];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            // Regenerate session ID (security against fixation attacks)
            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            // ✅ Login ke baad naya CSRF token generate karo
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Ram Counter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .login-container {
      max-width: 400px;
      margin: 80px auto;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-primary {
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="card p-4">
      <h3 class="text-center mb-4">🔒 Login</h3>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <!-- ✅ Hidden CSRF field -->
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" id="username" name="username" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
      </form>

      <div class="text-center mt-3">
        <a href="register.php">Create an account</a>
      </div>
    </div>
  </div>
</body>
</html>
