<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cin = $_GET["cin"];
$stmt = $conn->prepare("DELETE FROM log WHERE cin = ?");
$stmt->bind_param("s", $cin);
$stmt->execute();
$stmt->close();
$conn->close();

header("location:fetch.php");
?>