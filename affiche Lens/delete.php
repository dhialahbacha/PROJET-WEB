<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_GET["id"])) {
    $id = $_GET["id"];
    
    $stmt = $conn->prepare("DELETE FROM prof WHERE cin = ?");
    $stmt->bind_param("s", $id);
    
    if($stmt->execute()) {
        header("location: fetch.php");
        exit();
    } else {
        echo "Erreur lors de la suppression: " . $conn->error;
    }
    
    $stmt->close();
} else {
    header("location: fetch.php");
    exit();
}

$conn->close();
?>