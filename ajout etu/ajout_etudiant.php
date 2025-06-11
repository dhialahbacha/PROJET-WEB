<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cin = $_POST['T1'];
    $mp = $_POST['T6'];

    // Check if CIN already exists
    $check = $conn->prepare("SELECT cin FROM log WHERE cin = ?");
    $check->bind_param("s", $cin);
    $check->execute();
    $result = $check->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Ce CIN existe déjà!'); window.location.href='ajout_etudiant.html';</script>";
        exit();
    }

    // Insert new student
    $stmt = $conn->prepare("INSERT INTO log (cin, mp) VALUES (?, ?)");
    $stmt->bind_param("ss", $cin, $mp);
    
    if ($stmt->execute()) {
        echo "<script>alert('Étudiant ajouté avec succès!'); window.location.href='ajout_etudiant.html';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'ajout de l\'étudiant!'); window.location.href='ajout_etudiant.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?> 