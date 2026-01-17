<?php
$host = "localhost";
$dbname = "u382104307_naamjap_mantr";
$user = "u382104307_sandeepsvimmca";
$pass = "Sandeep@1187";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4", 
        $user, 
        $pass, 
        $options
    );
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
