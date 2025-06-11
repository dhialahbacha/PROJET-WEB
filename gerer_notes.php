<?php
class GradeManager {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "issat");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getStudents() {
        $query = "SELECT cin FROM log";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function saveGrades($studentCin, $grades) {
        $stmt = $this->conn->prepare("INSERT INTO note (cin, nom_matyer1, Ds1, examen1, nom_matyer2, Ds2, examen2, 
                                    nom_matyer3, Ds3, examen3, nom_matyer4, Ds4, examen4) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                                    ON DUPLICATE KEY UPDATE 
                                    nom_matyer1 = VALUES(nom_matyer1),
                                    Ds1 = VALUES(Ds1),
                                    examen1 = VALUES(examen1),
                                    nom_matyer2 = VALUES(nom_matyer2),
                                    Ds2 = VALUES(Ds2),
                                    examen2 = VALUES(examen2),
                                    nom_matyer3 = VALUES(nom_matyer3),
                                    Ds3 = VALUES(Ds3),
                                    examen3 = VALUES(examen3),
                                    nom_matyer4 = VALUES(nom_matyer4),
                                    Ds4 = VALUES(Ds4),
                                    examen4 = VALUES(examen4)");
        
        $stmt->bind_param("ssddsssdddddd", 
            $studentCin,
            $grades['matiere1'],
            $grades['ds1'],
            $grades['examen1'],
            $grades['matiere2'],
            $grades['ds2'],
            $grades['examen2'],
            $grades['matiere3'],
            $grades['ds3'],
            $grades['examen3'],
            $grades['matiere4'],
            $grades['ds4'],
            $grades['examen4']
        );
        return $stmt->execute();
    }

    public function getExistingGrades() {
        $query = "SELECT * FROM note";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Notes</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .grades-form {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 0.75rem;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
        }
        input[type="text"],
        input[type="number"] {
            width: 100px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 1rem;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .success {
            color: green;
            margin-bottom: 1rem;
        }
        .error {
            color: red;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gestion des Notes</h2>
        <?php
        $gradeManager = new GradeManager();
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $success = true;
            foreach ($_POST['grades'] as $cin => $grades) {
                if (!$gradeManager->saveGrades($cin, $grades)) {
                    $success = false;
                }
            }
            if ($success) {
                echo "<div class='success'>Notes enregistrées avec succès!</div>";
            } else {
                echo "<div class='error'>Erreur lors de l'enregistrement des notes.</div>";
            }
        }

        $students = $gradeManager->getStudents();
        $existingGrades = $gradeManager->getExistingGrades();
        $gradesMap = [];
        foreach ($existingGrades as $grade) {
            $gradesMap[$grade['cin']] = $grade;
        }
        ?>

        <div class="grades-form">
            <form method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>CIN</th>
                            <th>Matière 1</th>
                            <th>DS 1</th>
                            <th>Examen 1</th>
                            <th>Matière 2</th>
                            <th>DS 2</th>
                            <th>Examen 2</th>
                            <th>Matière 3</th>
                            <th>DS 3</th>
                            <th>Examen 3</th>
                            <th>Matière 4</th>
                            <th>DS 4</th>
                            <th>Examen 4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['cin']); ?></td>
                            <?php
                            $existingGrade = isset($gradesMap[$student['cin']]) ? $gradesMap[$student['cin']] : null;
                            for ($i = 1; $i <= 4; $i++) {
                                echo "<td><input type='text' name='grades[{$student['cin']}][matiere{$i}]' value='" . 
                                    ($existingGrade ? htmlspecialchars($existingGrade["nom_matyer{$i}"]) : '') . 
                                    "' required></td>";
                                echo "<td><input type='number' name='grades[{$student['cin']}][ds{$i}]' min='0' max='20' step='0.01' value='" . 
                                    ($existingGrade ? htmlspecialchars($existingGrade["Ds{$i}"]) : '0') . 
                                    "' required></td>";
                                echo "<td><input type='number' name='grades[{$student['cin']}][examen{$i}]' min='0' max='20' step='0.01' value='" . 
                                    ($existingGrade ? htmlspecialchars($existingGrade["examen{$i}"]) : '0') . 
                                    "' required></td>";
                            }
                            ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn">Enregistrer les Notes</button>
            </form>
        </div>
    </div>
</body>
</html> 