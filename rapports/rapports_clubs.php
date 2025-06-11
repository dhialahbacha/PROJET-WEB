<?php
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports d'Activités des Clubs</title>
    <link rel="stylesheet" href="../accueille/acceuil.css">
    <style>
        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
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
            margin: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .status-attent {
            color: #ffc107;
        }
        .status-valide {
            color: #28a745;
        }
        .status-rejete {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="barre">
        <div class="leftdiv"></div>
        <div class="centerdiv"><a href="../madmin/adminacc.html">Retour</a></div>
        <div class="rightdiv"></div>
    </div>

    <div class="container">
        <h2>Rapports d'Activités des Clubs</h2>
        <table>
            <thead>
                <tr>
                    <th>CIN</th>
                    <th>Nom du Club</th>
                    <th>Nom de l'Activité</th>
                    <th>Type d'Activité</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Destination</th>
                    <th>Participants</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM `rapport_activite_club` ORDER BY Date_et_heur_prevues_Debut_activite DESC";
                $result = $conn->query($query);

                while($row = $result->fetch_assoc()) {
                    $statusClass = 'status-' . strtolower($row['statu']);
                    $totalParticipants = $row['Nombre_de_ participant_garcon'] + $row['Nombre_de_participant_fille'];
                    
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['cin']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Nom_club']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Nom_activite']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Type_activite']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Date_et_heur_prevues_Debut_activite']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Date_et_heur_prevues_Fin_activite']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Destination']) . "</td>";
                    echo "<td>" . $totalParticipants . " (G: " . $row['Nombre_de_ participant_garcon'] . 
                         ", F: " . $row['Nombre_de_participant_fille'] . ")</td>";
                    echo "<td class='$statusClass'>" . htmlspecialchars($row['statu']) . "</td>";
                    echo "<td>
                            <a href='voir_rapport.php?cin=" . $row['cin'] . "' class='btn'>Voir</a>
                            <a href='valider_rapport.php?cin=" . $row['cin'] . "' class='btn'>Valider</a>
                            <a href='rejeter_rapport.php?cin=" . $row['cin'] . "' class='btn'>Rejeter</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html> 