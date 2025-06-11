<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Liste des Administrateurs</title>
	<link rel="stylesheet" type="text/css" href="../Affiche Note/ajout.css">
	<style>
		.btn {
			display: inline-block;
			padding: 8px 16px;
			text-decoration: none;
			border-radius: 4px;
			margin: 2px;
		}
		.btn-info {
			background-color: #17a2b8;
			color: white;
		}
		.btn-danger {
			background-color: #dc3545;
			color: white;
		}
	</style>
</head>

<body>
	<div class="container" style="width: 800px; margin-top: 100px;">
		<h3 align="center">Liste des Administrateurs</h3>
		<br>
		<div class="row">
			<table id="example" class="display" style="width:100%">
				<thead>
					<tr>
						<th>CIN</th>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Mot de passe</th>
						<th>Role</th>
						<th>Modifier</th>
						<th>Supprimer</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$query = "SELECT * FROM madmin";
					$result = $conn->query($query);

					while($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td>" . htmlspecialchars($row["cin"]) . "</td>";
						echo "<td>" . htmlspecialchars($row["nom"]) . "</td>";
						echo "<td>" . htmlspecialchars($row["prenom"]) . "</td>";
						echo "<td>" . htmlspecialchars($row["mdp"]) . "</td>";
						echo "<td>" . htmlspecialchars($row["role"]) . "</td>";
						echo "<td><a href='edit.php?id=" . $row['cin'] . "' class='btn btn-info'>Modifier</a></td>";
						echo "<td><a href='delete.php?id=" . $row['cin'] . "' class='btn btn-danger' 
							  onClick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet administrateur?\")'>Supprimer</a></td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>