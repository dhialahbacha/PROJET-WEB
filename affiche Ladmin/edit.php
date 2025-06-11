<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "issat");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the admin ID from URL
$id = mysqli_real_escape_string($conn, $_GET["id"]);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $nom = mysqli_real_escape_string($conn, $_POST["nom"]);
    $prenom = mysqli_real_escape_string($conn, $_POST["prenom"]);
    $mdp = mysqli_real_escape_string($conn, $_POST["mdp"]);
    $role = mysqli_real_escape_string($conn, $_POST["role"]);
    
    
    // Update the record
    $stmt = $conn->prepare("UPDATE madmin SET nom=?, prenom=?, mdp=?, role=? WHERE cin=?");
    $stmt->bind_param("sssss", $nom, $prenom, $mdp, $role, $id);
    
    if ($stmt->execute()) {
        header("Location: fetch.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Get current admin data
$stmt = $conn->prepare("SELECT * FROM madmin WHERE cin = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier Administrateur</title>
    <link rel="stylesheet" type="text/css" href="../Affiche Note/ajout.css">
    <style>
        .form-container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Modifier Administrateur</h2>
        <form method="POST">
            <div class="form-group">
                <label>CIN:</label>
                <input type="text" value="<?php echo htmlspecialchars($admin['cin']); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Nom:</label>
                <input type="text" name="nom" value="<?php echo htmlspecialchars($admin['nom']); ?>" required>
            </div>
            <div class="form-group">
                <label>Prénom:</label>
                <input type="text" name="prenom" value="<?php echo htmlspecialchars($admin['prenom']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nouveau mot de passe:</label>
                <input type="password" name="mdp" placeholder="Laissez vide pour ne pas changer">
            </div>
            <div class="form-group">
                <label>Role:</label>
                <input type="text" name="role" value="<?php echo htmlspecialchars($admin['role']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            <a href="fetch.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html> 