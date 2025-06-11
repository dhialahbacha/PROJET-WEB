<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $grade = $_POST['grade'];
    $mdp = $_POST['mdp'];
    
    $stmt = $conn->prepare("UPDATE prof SET nom=?, prenom=?, email=?, grade=?, mdp=? WHERE cin=?");
    $stmt->bind_param("ssssss", $name, $lastname, $email, $grade, $mdp, $id);
    
    if($stmt->execute()) {
        header("Location: fetch.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour: " . $conn->error;
    }
    $stmt->close();
}

// Get teacher data
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM prof WHERE cin = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$id = $row['cin'];
$name = $row['nom'];
$lastname = $row['prenom'];
$email = $row['email'];
$grade = $row['grade'];
$mdp = $row['mdp'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Modifier Enseignant</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container" style="width: 800px; margin-top: 100px;">
		<div class="row">
    <h3>modifier l'enseignant</h3>
    <hr>
			<div class="col-sm-6"> 
	
	<form action="" method="post" name="form1">
		<div class="form-group">
				
				<input type="hidden" name="id" class="form-control" value="<?php echo htmlspecialchars($id); ?>">
			
		</div>
		<div class="form-group">
				<label>nom</label>
				<input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
		</div>
		<div class="form-group">
				<label>prenom</label>
				<input type="text" name="lastname" class="form-control" value="<?php echo htmlspecialchars($lastname); ?>" required>
		</div>
			   <div class="form-group">
				<label>email</label>
				<input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" required>
			</div>
			<div class="form-group">
				<label>Grade</label>
				<input type="text" name="grade" class="form-control" value="<?php echo htmlspecialchars($grade); ?>" required>
			  </div>
			 <div class="form-group">
				<label>mot de passe</label>
				<input type="text" name="mdp" class="form-control" value="<?php echo htmlspecialchars($mdp); ?>" required>
			  </div>
				<div class="form-group">
				<input type="submit" value="Mettre à jour" class="btn btn-primary btn-block" name="update">
			
		
	</form>

</div>
</div>
</div>
</body>
</html>

