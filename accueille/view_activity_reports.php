<?php
require_once 'CourseManager.php';
$courseManager = new CourseManager();
$reports = $courseManager->getAllActivityReports();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports d'Activités</title>
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
        <h2>Rapports d'Activités des Clubs</h2>
        <table>
            <thead>
                <tr>
                    <th>CIN</th>
                    <th>Club</th>
                    <th>Activité</th>
                    <th>Type</th>
                    <th>Objectif</th>
                    <th>Public Cible</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Destination</th>
                    <th>Salle</th>
                    <th>Participants (G/F)</th>
                    <th>Matériel Utilisé</th>
                    <th>Évaluation</th>
                    <th>État</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?php echo htmlspecialchars($report['cin']); ?></td>
                    <td><?php echo htmlspecialchars($report['Nom_club']); ?></td>
                    <td><?php echo htmlspecialchars($report['Nom_activite']); ?></td>
                    <td><?php echo htmlspecialchars($report['Type_activite']); ?></td>
                    <td class="details" title="<?php echo htmlspecialchars($report['Objectif_activite']); ?>">
                        <?php echo htmlspecialchars($report['Objectif_activite']); ?>
                    </td>
                    <td><?php echo htmlspecialchars($report['Public_cible']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($report['Date_et_heur_prevues_Debut_activite'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($report['Date_et_heur_prevues_Fin_activite'])); ?></td>
                    <td><?php echo htmlspecialchars($report['Destination']); ?></td>
                    <td><?php echo htmlspecialchars($report['Salle_ou_espace_demande']); ?></td>
                    <td><?php echo htmlspecialchars($report['Nombre_de_ participant_garcon']) . ' / ' . 
                              htmlspecialchars($report['Nombre_de_participant_fille']); ?></td>
                    <td class="details" title="<?php echo htmlspecialchars($report['Materiel_utilise']); ?>">
                        <?php echo htmlspecialchars($report['Materiel_utilise']); ?>
                    </td>
                    <td class="details" title="<?php echo htmlspecialchars($report['Apressiation_Evaluation_activite']); ?>">
                        <?php echo htmlspecialchars($report['Apressiation_Evaluation_activite']); ?>
                    </td>
                    <td>
                        <span class="status-badge status-<?php echo strtolower($report['statu']); ?>">
                            <?php 
                            switch($report['statu']) {
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
                                    echo htmlspecialchars($report['statu']);
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