<?php
require_once 'CourseManager.php';
$courseManager = new CourseManager();
$reservations = $courseManager->getAllReservations();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Réservation</title>
    <link rel="stylesheet" href="acceuil.css">
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
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .details {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <div class="barre">
        <div class="leftdiv"></div>
        <div class="centerdiv"><a href="acceuil.html">Retour</a></div>
        <div class="rightdiv"></div>
    </div>

    <div class="container">
        <h2>Demandes de Réservation d'Activités</h2>
        <table>
            <thead>
                <tr>
                    <th>CIN</th>
                    <th>Association</th>
                    <th>Activité</th>
                    <th>Type</th>
                    <th>Objectif</th>
                    <th>Public Cible</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Destination</th>
                    <th>Salle</th>
                    <th>Matériel</th>
                    <th>Autres Besoins</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($reservation['cin']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['Nom_association']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['Nom_activite']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['Type_activite']); ?></td>
                    <td class="details" title="<?php echo htmlspecialchars($reservation['Objectif_activite']); ?>">
                        <?php echo htmlspecialchars($reservation['Objectif_activite']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($reservation['Public_cible']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($reservation['Date_et_heur_prevues_Debut_activite'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($reservation['Date_et_heur_prevues_Fin_activite'])); ?></td>
                    <td><?php echo htmlspecialchars($reservation['Destination']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['Salle_ou_espace_demande']); ?></td>
                    <td class="details" title="<?php echo htmlspecialchars($reservation['Materiel_demande']); ?>">
                        <?php echo htmlspecialchars($reservation['Materiel_demande']); ?>
                    </td>
                    <td class="details" title="<?php echo htmlspecialchars($reservation['Autre_besoins']); ?>">
                        <?php echo htmlspecialchars($reservation['Autre_besoins']); ?>
                    </td>
                    <td>
                        <span class="status-badge status-<?php echo strtolower($reservation['statu']); ?>">
                            <?php 
                            switch($reservation['statu']) {
                                case 'attent':
                                    echo 'En attente';
                                    break;
                                case 'approuve':
                                    echo 'Approuvé';
                                    break;
                                case 'rejete':
                                    echo 'Rejeté';
                                    break;
                                default:
                                    echo htmlspecialchars($reservation['statu']);
                            }
                            ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 