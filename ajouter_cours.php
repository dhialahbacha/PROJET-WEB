<?php
class CourseManager {
    private $conn;
    private $uploadDir = "uploads/courses/";

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

    public function addCourse($title, $description, $file) {
        $fileName = $this->uploadFile($file);
        if ($fileName) {
            $stmt = $this->conn->prepare("INSERT INTO courses (title, description, file_path, upload_date) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $title, $description, $fileName);
            return $stmt->execute();
        }
        return false;
    }

    private function uploadFile($file) {
        $targetFile = $this->uploadDir . basename($file["name"]);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Check if file is a valid document
        $allowedTypes = array("pdf", "doc", "docx", "ppt", "pptx");
        if (!in_array($fileType, $allowedTypes)) {
            throw new Exception("Seuls les fichiers PDF, DOC, DOCX, PPT et PPTX sont autorisés.");
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
    <title>Ajouter un Cours</title>
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
        <h2>Ajouter un Nouveau Cours</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $courseManager = new CourseManager();
                if ($courseManager->addCourse(
                    $_POST['title'],
                    $_POST['description'],
                    $_FILES['courseFile']
                )) {
                    echo "<div class='success'>Cours ajouté avec succès!</div>";
                } else {
                    echo "<div class='error'>Erreur lors de l'ajout du cours.</div>";
                }
            } catch (Exception $e) {
                echo "<div class='error'>" . $e->getMessage() . "</div>";
            }
        }
        ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Titre du Cours:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="courseFile">Fichier du Cours (PDF, DOC, DOCX, PPT, PPTX):</label>
                <input type="file" id="courseFile" name="courseFile" required>
            </div>
            <button type="submit" class="btn">Ajouter le Cours</button>
        </form>
    </div>
</body>
</html> 