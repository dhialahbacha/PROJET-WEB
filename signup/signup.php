<?php
// Start session and enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = mysqli_connect("localhost", "root", "", "issat");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$a = mysqli_real_escape_string($conn, $_POST['T1']);
$b = mysqli_real_escape_string($conn, $_POST['T2']);
$c = mysqli_real_escape_string($conn, $_POST['T3']);
$d = mysqli_real_escape_string($conn, $_POST['T4']);

// Check if CIN exists
$check_query = "SELECT * FROM sign WHERE cin = ?";
$stmt = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt, "s", $b);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo 'Vous avez déjà fait l\'inscription';
} else {
    // Insert into sign table
    $insert_sign = "INSERT INTO sign (nom, cin, email, mp) VALUES (?, ?, ?, ?)";
    $stmt1 = mysqli_prepare($conn, $insert_sign);
    mysqli_stmt_bind_param($stmt1, "ssss", $a, $b, $c, $d);
    
    // Insert into log table
    $insert_log = "INSERT INTO log (cin, mp) VALUES (?, ?)";
    $stmt2 = mysqli_prepare($conn, $insert_log);
    mysqli_stmt_bind_param($stmt2, "ss", $b, $d);

    if (mysqli_stmt_execute($stmt1) && mysqli_stmt_execute($stmt2)) {
        header("Location: ../accueille/acceuil.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close connections
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>



