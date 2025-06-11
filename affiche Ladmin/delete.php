<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize the CIN
$id = mysqli_real_escape_string($conn, $_GET["id"]);

// Prepare and execute the delete query
$stmt = $conn->prepare("DELETE FROM madmin WHERE cin = ?");
$stmt->bind_param("s", $id);

if ($stmt->execute()) {
    header("Location: fetch.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

// Close connection
$stmt->close();
$conn->close();
?>