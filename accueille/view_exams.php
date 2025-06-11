<?php
require_once 'CourseManager.php';
$courseManager = new CourseManager();
$exams = $courseManager->getAllExams();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Examens</title>
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
        .past {
            background-color: #f8d7da;
        }
        .upcoming {
            background-color: #d4edda;
        }
        .current {
            background-color: #fff3cd;
        }
        .download-link {
            color: #007bff;
            text-decoration: none;
        }
        .download-link:hover {
            text-decoration: underline;
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
        <h2>Liste des Examens</h2>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Durée (minutes)</th>
                    <th>Fichier</th>
                    <th>Date d'ajout</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exams as $exam): 
                    $examDate = new DateTime($exam['exam_date']);
                    $now = new DateTime();
                    $class = '';
                    
                    if ($examDate < $now) {
                        $class = 'past';
                    } elseif ($examDate->format('Y-m-d') === $now->format('Y-m-d')) {
                        $class = 'current';
                    } else {
                        $class = 'upcoming';
                    }
                ?>
                <tr class="<?php echo $class; ?>">
                    <td><?php echo htmlspecialchars($exam['title']); ?></td>
                    <td><?php echo htmlspecialchars($exam['description']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($exam['exam_date'])); ?></td>
                    <td><?php echo htmlspecialchars($exam['duration']); ?></td>
                    <td>
                        <a href="<?php echo htmlspecialchars($exam['file_path']); ?>" class="download-link" download>
                            Télécharger
                        </a>
                    </td>
                    <td><?php echo date('d/m/Y H:i', strtotime($exam['upload_date'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html> 