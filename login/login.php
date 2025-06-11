<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Database connection using PDO
    $pdo = new PDO("mysql:host=localhost;dbname=issat", "root", "");
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get and sanitize inputs
    $cin = filter_input(INPUT_POST, 'T1', FILTER_SANITIZE_STRING);
    $mp = filter_input(INPUT_POST, 'T2', FILTER_SANITIZE_STRING);
    
    // Prepare statement
    $stmt = $pdo->prepare("SELECT cin, mp FROM log WHERE cin = :cin AND mp = :mp");
    $stmt->bindParam(':cin', $cin);
    $stmt->bindParam(':mp', $mp);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        header("Location: ../accueille/acceuil.html");
        exit();
    } else {
        echo "Invalid credentials or account doesn't exist";
    }
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>