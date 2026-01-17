 <?php
require "db.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        try {
            $stmt->execute([$username, $hashedPassword]);
            $success = "Registration successful! You can now <a href='login.php'>login</a>.";
        } catch (PDOException $e) {
            if ($e->getCode() === "23000") { // duplicate entry
                $error = "Username already taken.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Ram Counter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .register-container {
      max-width: 400px;
      margin: 80px auto;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-success {
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="card p-4">
      <h3 class="text-center mb-4">📝 Register</h3>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" id="username" name="username" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="confirm_password" class="form-label">Confirm Password</label>
          <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Register</button>
      </form>

      <div class="text-center mt-3">
        <a href="login.php">Already have an account? Login</a>
      </div>
    </div>
  </div>
</body>
</html>
