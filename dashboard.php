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
$today = date("Y-m-d");

// Fetch today's count
$stmt = $pdo->prepare("SELECT `count` FROM ram_counts WHERE user_id = ? AND count_date = ?");
$stmt->execute([$user_id, $today]);
$row = $stmt->fetch();
$existingCount = $row ? $row["count"] : 0;

// Total count of all users for today
$stmtTotal = $pdo->prepare("SELECT SUM(`count`) as total FROM ram_counts");
$stmtTotal->execute();
$totalCount = $stmtTotal->fetchColumn();
if (!$totalCount) $totalCount = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        body {
  position: relative;
  background: url('ram2.jpg') no-repeat center center fixed;
  background-size: cover;
}

body::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(255, 255, 255, 0.7); /* White overlay 70% opacity */
  z-index: -1;
}
.bg {
  background: url('ram2.jpg') no-repeat center center fixed;
  background-size: cover;
  opacity: 0.3; /* kam zyada kar sakte ho */
  position: fixed;
  inset: 0;
  z-index: -1;
}
#nameList {
  max-height: 250px;   /* adjust based on your item height */
  overflow-y: auto;    /* adds vertical scroll bar */
}
    </style>
  <meta charset="UTF-8">
  <title>Ram Counter Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light"  >
      <div class="bg"></div>

<div class="card shadow p-4" style="width:70%;margin:0px auto;">
  <div class="dashboard-header">
    <h5><?= htmlspecialchars($username) ?>’s Count: <span id="count"><?= htmlspecialchars($existingCount) ?></span></h5>
    <h5>Total Users Count: <span id="allCount"><?= htmlspecialchars($totalCount) ?></span></h5>
  </div>
  <hr>
  <h4 class="mb-4 text-center">Welcome to Ram Counter</h4>
  <form id="ramForm">
    <div class="mb-3">
      <label for="nameInput" class="form-label">Enter Name</label>
      <input type="text" id="nameInput" class="form-control" placeholder="Type 'ram' only">
    </div>
    <div class="d-flex gap-2">
      <button id="submitBtn" type="submit" class="btn btn-primary w-50">Submit</button>
      <button id="clearBtn" type="button" class="btn btn-danger w-50">Clear</button>
    </div>
  </form>
  <div class="d-flex justify-content-end p-3">
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
  <ul id="nameList" class="list-group mt-3"></ul>
</div>

<script>
const csrfToken = "<?= $csrf_token ?>";

$(document).ready(function() {

   // Function to handle submit
   function submitName() {
       let name = $("#nameInput").val().trim().toLowerCase();

       if(name === "") {
           alert("Field cannot be empty!");
           return;
       }

       if(name === "ram") {
           $("#submitBtn").prop("disabled", true);

           $.post("save_count.php", 
               { action: "increment", csrf_token: csrfToken }, 
               function(data) {
                   console.log("Server Response:", data);
                   if(data.status === "success") {
                       $("#count").text(data.userCount);
                       $("#allCount").text(data.totalCount);
                       $("#nameList").append('<li class="list-group-item">राम</li>');
                   } else {
                       alert(data.message);
                   }
                   $("#nameInput").val("").focus();
                   $("#submitBtn").prop("disabled", false);
               },
               "json"
           ).fail(function(xhr, status, error) {
               console.error("AJAX Error:", status, error);
               console.log("Response Text:", xhr.responseText);
               alert("Something went wrong. Check console.");
               $("#submitBtn").prop("disabled", false);
           });
       } else {
           alert("Only 'ram' is allowed!");
       }
   }

   // ✅ Handle form submit (Submit button + Enter key)
   $("#ramForm").on("submit", function(e) {
       e.preventDefault();
       submitName();
   });

   // Clear button
   $("#clearBtn").on("click", function(e) {
        e.preventDefault();
        $("#ramForm")[0].reset();  // resets all inputs in the form
});
});
</script>
</body>
</html>
