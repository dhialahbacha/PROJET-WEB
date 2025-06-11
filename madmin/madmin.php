<?php
// Universal connection start
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "issat";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Universal connection end

// Sanitize inputs
$uname = mysqli_real_escape_string($conn, $_POST['T1']);
$password = mysqli_real_escape_string($conn, $_POST['T2']);

// Prepare statement
$stmt = mysqli_prepare($conn, "SELECT * FROM madmin WHERE cin = ? AND mdp = ? AND role = 'boss'");
mysqli_stmt_bind_param($stmt, "ss", $uname, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    header("Location: ../madmin/adminacc.html");
    exit();
} else {
    echo 'Vous êtes non autorisés';
}

// Close connections
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>