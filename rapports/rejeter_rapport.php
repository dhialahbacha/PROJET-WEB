<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['cin'])) {
    $cin = $_GET['cin'];
    
    $stmt = $conn->prepare("UPDATE `rapport_activite_club` SET statu = 'rejete' WHERE cin = ?");
    $stmt->bind_param("s", $cin);
    
    if ($stmt->execute()) {
        echo "<script>alert('Rapport rejeté!'); window.location.href='rapports_clubs.php';</script>";
    } else {
        echo "<script>alert('Erreur lors du rejet du rapport!'); window.location.href='rapports_clubs.php';</script>";
    }
    
    $stmt->close();
} else {
    header("Location: rapports_clubs.php");
}

$conn->close();
?> 