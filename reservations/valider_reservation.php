<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['cin'])) {
    $cin = $_GET['cin'];
    
    $stmt = $conn->prepare("UPDATE `demande_de_reservation_activite_association` SET statu = 'valide' WHERE cin = ?");
    $stmt->bind_param("s", $cin);
    
    if ($stmt->execute()) {
        echo "<script>alert('Réservation validée avec succès!'); window.location.href='demandes_reservation.php';</script>";
    } else {
        echo "<script>alert('Erreur lors de la validation de la réservation!'); window.location.href='demandes_reservation.php';</script>";
    }
    
    $stmt->close();
} else {
    header("Location: demandes_reservation.php");
}

$conn->close();
?> 