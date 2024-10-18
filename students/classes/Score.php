<?php
class Score
{
    private $conn;

    public function __construct()
    {
        // Include the database connection file
        include '../config/dbcon.php';
        $this->conn = $conn;
    }

    // Fetch all scores
    public function fetchAllScores()
    {
        $stmt = $this->conn->prepare("SELECT * FROM tblscore");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("Error fetching scores: " . $stmt->error);
        }
    }

    // Add a new score
    public function addScore($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO tblscore (StudentID, QuestionID, Score) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("iii", $data['StudentID'], $data['QuestionID'], $data['Score']);

        if ($stmt->execute()) {
            return true; // Score successfully added
        } else {
            throw new Exception("Error adding score: " . $stmt->error);
        }
    }

    // Insert a score for a specific student and exercise
    public function insertScore($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO tblscore (ExerciseID, LessonID, StudentID, Score) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("iiii", $data['ExerciseID'], $data['LessonID'], $data['StudentID'], $data['Score']);

        if ($stmt->execute()) {
            return true; // Score successfully inserted
        } else {
            throw new Exception("Error inserting score: " . $stmt->error);
        }
    }

    // Edit an existing score
    public function editScore($scoreID, $data)
    {
        $stmt = $this->conn->prepare("UPDATE tblscore SET StudentID = ?, QuestionID = ?, Score = ? WHERE ScoreID = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("iiii", $data['StudentID'], $data['QuestionID'], $data['Score'], $scoreID);

        if ($stmt->execute()) {
            return true; // Score successfully updated
        } else {
            throw new Exception("Error updating score: " . $stmt->error);
        }
    }

    // Delete a score
    public function deleteScore($scoreID)
    {
        $stmt = $this->conn->prepare("DELETE FROM tblscore WHERE ScoreID = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $scoreID);

        if ($stmt->execute()) {
            return true; // Score successfully deleted
        } else {
            throw new Exception("Error deleting score: " . $stmt->error);
        }
    }

    // Fetch a student's score for a specific lesson
    public function fetchStudentScore($studentID, $lessonID)
    {
        $stmt = $this->conn->prepare("SELECT Score, NoItems FROM tblscore WHERE StudentID = ? AND LessonID = ? LIMIT 1");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $studentID, $lessonID);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc(); // Return score data as associative array
        } else {
            throw new Exception("Error fetching student score: " . $stmt->error);
        }
    }
}
