<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "issat");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get and sanitize input
$nom = mysqli_real_escape_string($conn, $_POST['T1']); // nom
$cin = mysqli_real_escape_string($conn, $_POST['T2']); // cin
$prenom = mysqli_real_escape_string($conn, $_POST['T3']); // prenom
$email = mysqli_real_escape_string($conn, $_POST['T4']); // email
$grade = mysqli_real_escape_string($conn, $_POST['T5']); // grade
$mdp = mysqli_real_escape_string($conn, $_POST['T6']); // mdp

// Validate required fields
if (empty($nom) || empty($cin) || empty($prenom) || empty($email) || empty($grade) || empty($mdp)) {
    die("Tous les champs sont obligatoires");
}

// Check if professor already exists
$check_query = "SELECT * FROM prof WHERE cin = ?";
$stmt = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt, "s", $cin);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    die("Cet enseignant existe déjà");
}

// Insert new professor
$insert_query = "INSERT INTO prof (nom, cin, prenom, email, grade, mdp) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $insert_query);
mysqli_stmt_bind_param($stmt, "ssssss", $nom, $cin, $prenom, $email, $grade, $mdp);

if (mysqli_stmt_execute($stmt)) {
    header("Location: ../affiche%20Lens/fetch.php");
    exit();
} else {
    echo "Erreur lors de l'ajout de l'enseignant: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>