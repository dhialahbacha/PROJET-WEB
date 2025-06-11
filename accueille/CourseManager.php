<?php
class CourseManager {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "issat");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getAllCourses() {
        $query = "SELECT * FROM courses ORDER BY title";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllExams() {
        $query = "SELECT * FROM exams ORDER BY exam_date DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllReservations() {
        $query = "SELECT * FROM demande_de_reservation_activite_association ORDER BY Date_et_heur_prevues_Debut_activite DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllActivityReports() {
        $query = "SELECT * FROM rapport_activite_club ORDER BY Date_et_heur_prevues_Debut_activite DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?> 