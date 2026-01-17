 <?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require "db.php";

header('Content-Type: application/json');

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

if (!isset($pdo)) {
    echo json_encode(["status" => "error", "message" => "Database connection not available"]);
    exit;
}

// CSRF check
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(["status" => "error", "message" => "Invalid CSRF token"]);
    exit;
}

$user_id = $_SESSION["user_id"];
$today = date("Y-m-d");
$action = $_POST["action"] ?? "";

// Increment action
if ($action === "increment") {
    // Rate limiting: max 5 per sec
    $stmt = $pdo->prepare("SELECT created_at FROM ram_activity_log 
                           WHERE user_id = ? 
                           AND created_at >= DATE_SUB(NOW(), INTERVAL 1 SECOND)");
    $stmt->execute([$user_id]);
    $recent = $stmt->fetchAll();

    if (count($recent) >= 5) {
        echo json_encode(["status" => "error", "message" => "Too many attempts! Slow down."]);
        exit;
    }

    // Insert into activity log
    $pdo->prepare("INSERT INTO ram_activity_log (user_id, created_at) VALUES (?, NOW())")
        ->execute([$user_id]);

    // Update user count
    $stmt = $pdo->prepare("SELECT id, `count` FROM ram_counts WHERE user_id = ? AND count_date = ?");
    $stmt->execute([$user_id, $today]);
    $row = $stmt->fetch();

    if ($row) {
        $newCount = $row["count"] + 1;
        $pdo->prepare("UPDATE ram_counts SET `count` = ? WHERE id = ?")
            ->execute([$newCount, $row["id"]]);
    } else {
        $pdo->prepare("INSERT INTO ram_counts (user_id, `count`, count_date) VALUES (?, 1, ?)")
            ->execute([$user_id, $today]);
        $newCount = 1;
    }

    // Get total count today
    $stmtTotal = $pdo->prepare("SELECT SUM(`count`) FROM ram_counts");
    $stmtTotal->execute();
    $totalCount = $stmtTotal->fetchColumn() ?: 0;

echo json_encode([
    "status" => "success",
    "userCount" => (int)$newCount,
    "totalCount" => (int)$totalCount
]);

    exit;
}

  

// Invalid action
echo json_encode(["status" => "error", "message" => "Invalid action"]);
exit;
