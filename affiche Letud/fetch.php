<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../Affiche Note/ajout.css">
	<title>Liste des Étudiants</title>
</head>

<body>
	<div class="container" style="width: 800px; margin-top: 100px;">
		<h3 align="center">Liste des étudiants</h3>
		<br>
		<div class="row">
			<table id="example" class="display" style="width:100%">
				<thead>
					<tr>
						<th>CIN</th>
						<th>Mot de passe</th>
						<th>Modifier</th>
						<th>Supprimer</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = "SELECT * FROM log";
					$result = $conn->query($query);
					
					while($row = $result->fetch_assoc()) {
					?>
					<tr>
						<td><?php echo htmlspecialchars($row["cin"]); ?></td>
						<td><?php echo htmlspecialchars($row["mp"]); ?></td>
						<td><a href="edit.php?cin=<?php echo $row['cin']; ?>" class="btn btn-info">Modifier</a></td>
						<td><a href="delete.php?cin=<?php echo $row['cin']; ?>" class="btn btn-danger" 
							   onClick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant?')">Supprimer</a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
