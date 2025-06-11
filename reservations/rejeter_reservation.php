<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['cin'])) {
    $cin = $_GET['cin'];
    
    $stmt = $conn->prepare("UPDATE `demande_de_reservation_activite_association` SET statu = 'rejete' WHERE cin = ?");
    $stmt->bind_param("s", $cin);
    
    if ($stmt->execute()) {
        echo "<script>alert('Réservation rejetée!'); window.location.href='demandes_reservation.php';</script>";
    } else {
        echo "<script>alert('Erreur lors du rejet de la réservation!'); window.location.href='demandes_reservation.php';</script>";
    }
    
    $stmt->close();
} else {
    header("Location: demandes_reservation.php");
}

$conn->close();
?> 