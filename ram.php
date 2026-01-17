<?php
session_start();

// if session is not set, redirect to login.php
if (!isset($_SESSION['username']) || $_SESSION['username'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 
  <meta charset="UTF-8">
  <title>Ram Counter</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light" style="background: url('ram2.jpg') no-repeat center center fixed; 
             background-size: cover;">

<div class="container mt-5">
  <div class="card shadow p-4" style="width:70%;margin:0px auto;">
    <h3 class="mb-4 text-center">Ram Name Counter</h3>
    
    <div class="mb-3">
      <label for="nameInput" class="form-label">Enter Name</label>
      <input type="text" id="nameInput" class="form-control" placeholder="Type 'ram' only">
    </div>
    
    <div class="d-flex gap-2">
      <button id="submitBtn" class="btn btn-primary">Submit</button>
      <button id="clearBtn" class="btn btn-danger">Clear</button>
    </div>
    
    <hr>
    
    <h5>Total Count: <span id="count">0</span></h5>
    <ul id="nameList" class="list-group mt-3"></ul>
  </div>
</div>

 <script>
$(document).ready(function() {
  let count = 0;

  function addName() {
    let name = $("#nameInput").val().trim().toLowerCase();

    if(name === "") {
      alert("Field cannot be empty!");
      return;
    }

    if(name === "ram") {
      count++;
      $("#count").text(count);
      $("#nameList").append('<li class="list-group-item">राम</li>');
      $("#nameInput").val("").focus(); // clear and refocus
    } else {
      alert("Only 'ram' is allowed!");
    }
  }

  // On submit button click
  $("#submitBtn").click(function() {
    addName();
  });

  // On Enter key press inside input
  $("#nameInput").keypress(function(e) {
    if(e.which === 13) { // 13 = Enter key
      e.preventDefault(); // stop form submit / newline
      addName();
    }
  });

  // On clear button click
  $("#clearBtn").click(function() {
    count = 0;
    $("#count").text(count);
    $("#nameList").empty();
    $("#nameInput").val("").focus();
  });
});
</script>


</body>
</html>
