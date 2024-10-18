<?php
class Assessment
{
    private $conn;

    public function __construct()
    {
        // Include database connection
        include '../config/dbcon.php';
        $this->conn = $conn;
    }


    // Method to fetch all assessments from the tblscore table
    public function fetchAllAssessments()
    {
        $stmt = $this->conn->prepare("SELECT LessonID, ExerciseID, StudentID, NoItems, Answer, Score, Submitted FROM tblscore");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC); // Return all results as an associative array
    }
}
