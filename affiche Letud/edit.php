<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['update'])) {
    $cin = $_POST['cin'];
    $mp = $_POST['mp'];
    
    $stmt = $conn->prepare("UPDATE log SET mp = ? WHERE cin = ?");
    $stmt->bind_param("ss", $mp, $cin);
    $stmt->execute();
    $stmt->close();
    
    header("Location: fetch.php");
    exit();
}

// Get student data
$cin = $_GET['cin'];
$stmt = $conn->prepare("SELECT * FROM log WHERE cin = ?");
$stmt->bind_param("s", $cin);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$cin = $row['cin'];
$mp = $row['mp'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Modifier Étudiant</title>
	<link rel="stylesheet" href="../Affiche Note/ajout.css">
</head>

<body>
	<div class="container" style="width: 800px; margin-top: 100px;">
		<div class="row">
			<h3>Modifier l'étudiant</h3>
			<hr>
			<div class="col-sm-6"> 
	
	<form action="" method="post" name="form1">
		<div class="form-group">
			<label>CIN</label>
			<input type="text" name="cin" class="form-control" value="<?php echo $cin; ?>" readonly>
		</div>
		<div class="form-group">
			<label>Mot de passe</label>
			<input type="text" name="mp" class="form-control" value="<?php echo $mp; ?>" required>
		</div>
		<div class="form-group">
			<input type="submit" value="Mettre à jour" class="btn btn-primary btn-block" name="update">
		</div>
	</form>

</div>
</div>
</div>
</body>
</html>


