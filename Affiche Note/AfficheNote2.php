<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get CIN from POST
$cin = isset($_POST['cin']) ? $_POST['cin'] : '';
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="ajout.css">
	<title>Afficher la note</title>
	<style>
		.container {
			width: 800px;
			margin-top: 100px;
			background: white;
			padding: 20px;
			border-radius: 8px;
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		}
		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}
		th, td {
			padding: 12px;
			text-align: left;
			border: 1px solid #ddd;
		}
		th {
			background-color: #f8f9fa;
		}
		.btn {
			display: inline-block;
			padding: 10px 20px;
			background-color: #007bff;
			color: white;
			text-decoration: none;
			border-radius: 4px;
			margin-top: 20px;
		}
		.btn:hover {
			background-color: #0056b3;
		}
		.average {
			font-weight: bold;
			color: #28a745;
		}
	</style>
</head>

<body>
	<div class="container">
		<h3 align="center">Liste de notes</h3>
		<br>
		<div class="row">
			<table id="example" class="display" style="width:100%">
				<thead>
					<tr>
						<th>Matière</th>
						<th>DS</th>
						<th>Examen</th>
						<th>Moyenne</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if (!empty($cin)) {
						$stmt = $conn->prepare("SELECT * FROM note WHERE cin = ?");
						$stmt->bind_param("s", $cin);
						$stmt->execute();
						$result = $stmt->get_result();

						if ($row = $result->fetch_assoc()) {
							// Matière 1
							echo "<tr>";
							echo "<td>" . htmlspecialchars($row["nom_matyer1"]) . "</td>";
							echo "<td>" . htmlspecialchars($row["Ds1"]) . "</td>";
							echo "<td>" . htmlspecialchars($row["examen1"]) . "</td>";
							$moyenne1 = ($row["Ds1"] * 0.3) + ($row["examen1"] * 0.7);
							echo "<td class='average'>" . number_format($moyenne1, 2) . "</td>";
							echo "</tr>";

							// Matière 2
							echo "<tr>";
							echo "<td>" . htmlspecialchars($row["nom_matyer2"]) . "</td>";
							echo "<td>" . htmlspecialchars($row["Ds2"]) . "</td>";
							echo "<td>" . htmlspecialchars($row["examen2"]) . "</td>";
							$moyenne2 = ($row["Ds2"] * 0.3) + ($row["examen2"] * 0.7);
							echo "<td class='average'>" . number_format($moyenne2, 2) . "</td>";
							echo "</tr>";

							// Matière 3
							echo "<tr>";
							echo "<td>" . htmlspecialchars($row["nom_matyer3"]) . "</td>";
							echo "<td>" . htmlspecialchars($row["Ds3"]) . "</td>";
							echo "<td>" . htmlspecialchars($row["examen3"]) . "</td>";
							$moyenne3 = ($row["Ds3"] * 0.3) + ($row["examen3"] * 0.7);
							echo "<td class='average'>" . number_format($moyenne3, 2) . "</td>";
							echo "</tr>";

							// Matière 4
							echo "<tr>";
							echo "<td>" . htmlspecialchars($row["nom_matyer4"]) . "</td>";
							echo "<td>" . htmlspecialchars($row["Ds4"]) . "</td>";
							echo "<td>" . htmlspecialchars($row["examen4"]) . "</td>";
							$moyenne4 = ($row["Ds4"] * 0.3) + ($row["examen4"] * 0.7);
							echo "<td class='average'>" . number_format($moyenne4, 2) . "</td>";
							echo "</tr>";
						} else {
							echo "<tr><td colspan='4' style='text-align: center;'>Aucune note trouvée pour ce CIN</td></tr>";
						}
						$stmt->close();
					} else {
						echo "<tr><td colspan='4' style='text-align: center;'>Veuillez entrer un CIN</td></tr>";
					}
					?>
				</tbody>
			</table>
			<a class='btn' href="AfficheNote1.html">Retour</a>
		</div>
	</div>
</body>
</html>