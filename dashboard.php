<?php
session_start();
require "db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$username = ucfirst($username);
$today = date("Y-m-d");

// Fetch today's count
$stmt = $pdo->prepare("SELECT `count` FROM ram_counts WHERE user_id = ? AND count_date = ?");
$stmt->execute([$user_id, $today]);
$row = $stmt->fetch();
$existingCount = $row ? $row["count"] : 0;

// Total count of  users 
$stmtUserTotal = $pdo->prepare("
    SELECT COALESCE(SUM(`count`), 0) 
    FROM ram_counts 
    WHERE user_id = ?
");
$stmtUserTotal->execute([$user_id]);
$totalCount  = $stmtUserTotal->fetchColumn();

 

// Total count of login users using join with user table
$stmtLoginUserCount = $pdo->prepare("SELECT COUNT(DISTINCT u.id) as total FROM users u INNER JOIN ram_counts rc ON u.id = rc.user_id");
$stmtLoginUserCount->execute();
$loginUserCount = $stmtLoginUserCount->fetchColumn();
if (!$loginUserCount) $loginUserCount = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ram Counter Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            position: relative;
            background: url('ram2.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            padding: 15px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.7);
            z-index: -1;
        }

        .dashboard-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 20px 0;
        }

        .header-section {
            background: linear-gradient(135deg, #f94b4b 0%, #f5576c 100%);
            color: white;
            padding: 20px 15px;
            border-radius: 15px 15px 0 0;
            margin-bottom: 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .header-section h2 {
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            font-weight: 700;
            text-align: center;
            margin: 0;
            flex: 1;
            min-width: 200px;
        }

        .header-logout {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid white;
            color: white;
            padding: 8px 16px;
            font-size: clamp(0.85rem, 2.5vw, 0.95rem);
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            min-height: 38px;
            display: flex;
            align-items: center;
        }

        .header-logout:hover {
            background: white;
            color: #f5576c;
            transform: translateY(-2px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 0;
            margin-top:20px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }



        .stat-card h6 {
            font-size: clamp(0.85rem, 2.5vw, 1rem);
            color: #666;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .stat-card .count-number {
            font-size: clamp(1.75rem, 6vw, 2.5rem);
            font-weight: 700;
            color: #ea6d66;
        }

        .main-card {
            background: white;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 25px 15px;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            margin-top:25px;
        }

        .welcome-title {
            font-size: clamp(1.25rem, 4vw, 2rem);
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-weight: 600;
            color:#ea6d66;
        }

        .form-section {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: clamp(0.9rem, 2.5vw, 1rem);
        }

        .thumb-button {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            color: white;
            font-size: 60px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(245, 87, 108, 0.3);
            display: block;
            margin: 40px auto;
        }

        .thumb-button:hover:not(:disabled) {
            transform: scale(1.1);
            box-shadow: 0 12px 35px rgba(245, 87, 108, 0.5);
        }

        .thumb-button:active:not(:disabled) {
            transform: scale(0.95);
        }

        .thumb-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            font-size: clamp(0.95rem, 2.5vw, 1rem);
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        .button-group {
            display: none;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }

        .btn {
            padding: 12px 20px;
            font-size: clamp(0.95rem, 2.5vw, 1.05rem);
            font-weight: 600;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 45px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
        }

        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn-danger {
            background: #ff6b6b;
            color: white;
            text-decoration: none;
        }

        .btn-danger:hover:not(:disabled) {
            background: #ee5a52;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
            color: white;
            text-decoration: none;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .logout-section {
            display: none;
            justify-content: center;
            margin: 25px 0 15px 0;
        }

        .btn-logout {
            width: 100%;
            max-width: 200px;
            display: inline-block;
            text-align: center;
        }

        .flying-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            margin-top: 30px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            min-height: 200px;
        }

        @keyframes flyUp {
            0% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateY(-300px) scale(0.5);
            }
        }

        .flying-ram {
            position: fixed;
            font-size: 40px;
            font-weight: bold;
            pointer-events: none;
            animation: flyUp 1.5s ease-out forwards;
            color: #e74427ff;
        }

        @media (max-width: 576px) {
            body {
                padding: 10px;
            }

            .main-card {
                padding: 20px 12px;
                border-radius: 12px;
                margin-top:25px;
            }

            .header-section {
                padding: 20px 12px;
                border-radius: 12px 12px 0 0;
            }

            .stats-grid {
                gap: 10px;
                grid-template-columns: 1fr 1fr;
            }

            .stat-card {
                padding: 15px;
            }

            .button-group {
                gap: 10px;
            }

            .btn {
                min-height: 44px;
                padding: 10px 15px;
            }
        }

        @media (max-width: 400px) {
            .header-section h2 {
                font-size: 1.3rem;
            }

            .welcome-title {
                font-size: 1.1rem;
            }
        }

        @media (min-width: 768px) {
            .dashboard-container {
                padding: 40px 20px;
            }

            .main-card {
                max-width: 700px;
                margin-top:25px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="header-section">
            <h2>🕉️ Ram Counter</h2>
            <a href="logout.php" class="header-logout">Logout</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <h6><?= htmlspecialchars($username) ?> Count</h6>
                <div class="count-number" id="count"><?= htmlspecialchars($existingCount) ?></div>
            </div>
            <div class="stat-card">
                <h6><?= htmlspecialchars($username) ?> Total Count</h6>
                <div class="count-number" id="allCount"><?= htmlspecialchars($totalCount) ?></div>
            </div>
        </div>

        <div class="main-card">
            <h4 class="welcome-title">Welcome <?= htmlspecialchars($username) ?></h4>

            <button id="thumbBtn" class="thumb-button" title="Click to add count">👍</button>

            <div class="button-group">
                <button id="submitBtn" type="submit" form="ramForm" class="btn btn-primary">Submit</button>
                <button id="clearBtn" type="button" class="btn btn-danger">Clear</button>
            </div>

            <div class="logout-section">
                <a href="logout.php" class="btn btn-danger btn-logout">Logout</a>
            </div>
        </div>
    </div>

    <div id="animationContainer"></div>

<script>
const csrfToken = "<?= $csrf_token ?>";

$(document).ready(function() {

   // Function to create flying animation
   function createFlyingRam(x, y) {
       const flyingElement = document.createElement('div');
       flyingElement.classList.add('flying-ram');
       flyingElement.textContent = 'राम';
       flyingElement.style.left = x + 'px';
       flyingElement.style.top = y + 'px';
       
       document.getElementById('animationContainer').appendChild(flyingElement);
       
       // Remove element after animation completes
       setTimeout(() => {
           flyingElement.remove();
       }, 1500);
   }

   // Function to handle thumb button click
   function increaseCount() {
       $("#thumbBtn").prop("disabled", true);

       // Get button position for animation
       const btnRect = document.getElementById('thumbBtn').getBoundingClientRect();
       const startX = btnRect.left + btnRect.width / 2;
       const startY = btnRect.top + btnRect.height / 2;
       
       // Create flying animation
       createFlyingRam(startX, startY);

       $.post("save_count.php", 
           { action: "increment", csrf_token: csrfToken }, 
           function(data) {
               console.log("Server Response:", data);
               if(data.status === "success") {
                   $("#count").text(data.userCount);
                   $("#allCount").text(data.userTotalCount);
               }
               $("#thumbBtn").prop("disabled", false);
           },
           "json"
       ).fail(function(xhr, status, error) {
           console.error("AJAX Error:", status, error);
           $("#thumbBtn").prop("disabled", false);
       });
   }

   // ✅ Handle thumb button click
   $("#thumbBtn").on("click", function(e) {
       e.preventDefault();
       increaseCount();
   });
});
</script>
</body>
</html>
