<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['cin'])) {
    $cin = $_GET['cin'];
    
    $stmt = $conn->prepare("UPDATE `rapport_activite_club` SET statu = 'valide' WHERE cin = ?");
    $stmt->bind_param("s", $cin);
    
    if ($stmt->execute()) {
        echo "<script>alert('Rapport validé avec succès!'); window.location.href='rapports_clubs.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de la validation du rapport!'); window.location.href='rapports_clubs.php';</script>";
    }
    
    $stmt->close();
} else {
    header("Location: rapports_clubs.php");
}

$conn->close();
?> 