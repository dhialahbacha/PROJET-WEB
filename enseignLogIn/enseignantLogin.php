<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Database {
    private $pdo;
    
    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=issat", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public function getConnection() {
        return $this->pdo;
    }
}

class Teacher {
    private $db;
    
    public function __construct(Database $db) {
        $this->db = $db;
    }
    
    public function login($cin, $password) {
        try {
            $stmt = $this->db->getConnection()->prepare("SELECT * FROM prof WHERE cin = :cin AND mdp = :password");
            $stmt->bindParam(':cin', $cin);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch(PDOException $e) {
            die("Login failed: " . $e->getMessage());
        }
    }
}

// Process login if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database();
    $teacher = new Teacher($db);
    
    $cin = filter_input(INPUT_POST, 'T1', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'T2', FILTER_SANITIZE_STRING);
    
    if ($teacher->login($cin, $password)) {
        session_start();
        $_SESSION['prof_cin'] = $cin;
        header("Location: ../enseignant_dashboard.html");
        exit();
    } else {
        echo "<script>alert('Identifiants incorrects!'); window.location.href='enseignantLogin.html';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Connexion Enseignant</title>
</head>
<body style="text-align: center">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Your form fields here -->
    </form>
</body>
</html>