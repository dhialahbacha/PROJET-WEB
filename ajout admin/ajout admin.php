<?php
// Start session if needed
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "issat");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get and sanitize input
$a = mysqli_real_escape_string($conn, $_POST['T1']); // cin
$b = mysqli_real_escape_string($conn, $_POST['T2']); // nom
$c = mysqli_real_escape_string($conn, $_POST['T3']); // prenom
$d = mysqli_real_escape_string($conn, $_POST['T4']); // mdp
$e = mysqli_real_escape_string($conn, $_POST['T5']); // role

// Validate required fields
if (empty($a) || empty($b) || empty($c) || empty($d) || empty($e)) {
    die("Tous les champs sont obligatoires");
}

// Check if admin already exists
$check_query = "SELECT * FROM madmin WHERE cin = ?";
$stmt = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt, "s", $a);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    die("Cet administrateur existe déjà");
}

// Insert new admin with plain text password
$insert_query = "INSERT INTO madmin (cin, nom, prenom, mdp, role) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $insert_query);
mysqli_stmt_bind_param($stmt, "sssss", $a, $b, $c, $d, $e);

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../affiche%20Ladmin/fetch.php");
    exit();
} else {
    echo "Erreur lors de l'ajout de l'administrateur: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>