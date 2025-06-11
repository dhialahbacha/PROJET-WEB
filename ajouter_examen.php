<?php
class ExamManager {
    private $conn;
    private $uploadDir = "uploads/exams/";

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "issat");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
        // Create upload directory if it doesn't exist
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function addExam($title, $description, $date, $duration, $file) {
        $fileName = $this->uploadFile($file);
        if ($fileName) {
            $stmt = $this->conn->prepare("INSERT INTO exams (title, description, exam_date, duration, file_path, upload_date) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("sssis", $title, $description, $date, $duration, $fileName);
            return $stmt->execute();
        }
        return false;
    }

    private function uploadFile($file) {
        $targetFile = $this->uploadDir . basename($file["name"]);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Check if file is a valid document
        $allowedTypes = array("pdf", "doc", "docx");
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("Seuls les fichiers PDF, DOC et DOCX sont autorisés.");
        }

        // Check file size (5MB max)
        if ($file["size"] > 5000000) {
            throw new Exception("Le fichier est trop volumineux. Taille maximale: 5MB");
        }

        // Generate unique filename
        $newFileName = uniqid() . "." . $fileType;
        $targetFile = $this->uploadDir . $newFileName;

        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return $newFileName;
        }
        return false;
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
    <title>Ajouter un Examen</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea {
            width: 100%;
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
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 1rem;
        }
        .success {
            color: green;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Ajouter un Nouvel Examen</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $examManager = new ExamManager();
                if ($examManager->addExam(
                    $_POST['title'],
                    $_POST['description'],
                    $_POST['exam_date'],
                    $_POST['duration'],
                    $_FILES['examFile']
                )) {
                    echo "<div class='success'>Examen ajouté avec succès!</div>";
                } else {
                    echo "<div class='error'>Erreur lors de l'ajout de l'examen.</div>";
                }
            } catch (Exception $e) {
                echo "<div class='error'>" . $e->getMessage() . "</div>";
            }
        }
        ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Titre de l'Examen:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="exam_date">Date de l'Examen:</label>
                <input type="date" id="exam_date" name="exam_date" required>
            </div>
            <div class="form-group">
                <label for="duration">Durée (en minutes):</label>
                <input type="number" id="duration" name="duration" min="1" required>
            </div>
            <div class="form-group">
                <label for="examFile">Fichier de l'Examen (PDF, DOC, DOCX):</label>
                <input type="file" id="examFile" name="examFile" required>
            </div>
            <button type="submit" class="btn">Ajouter l'Examen</button>
        </form>
    </div>
</body>
</html> 