<?php
class StudentQuestion
{
    private $conn;

    public function __construct()
    {
        // Include the database connection file
        include '../config/dbcon.php';
        $this->conn = $conn;
    }

    // Fetch all student questions
    public function fetchAllQuestions()
    {
        $stmt = $this->conn->prepare("SELECT * FROM tblstudentquestions");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("Error fetching questions: " . $stmt->error);
        }
    }

    // Add a new student question
    public function addQuestion($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO tblstudentquestions (QuestionText, AnswerOptions, CorrectAnswer) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sss", $data['QuestionText'], $data['AnswerOptions'], $data['CorrectAnswer']);

        if ($stmt->execute()) {
            return true; // Question successfully added
        } else {
            throw new Exception("Error adding question: " . $stmt->error);
        }
    }

    // Insert student answers into tblstudentquestion
    public function insertStudentQuestion($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO tblstudentquestion (ExerciseID, LessonID, StudentID, Question, CA, CB, CC, CD, QA) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "iiissssss",
            $data['ExerciseID'],
            $data['LessonID'],
            $data['StudentID'],
            $data['Question'],
            $data['CA'],
            $data['CB'],
            $data['CC'],
            $data['CD'],
            $data['QA']
        );

        if ($stmt->execute()) {
            return true; // Student question successfully added
        } else {
            throw new Exception("Error inserting student question: " . $stmt->error);
        }
    }

    // Edit an existing student question
    public function editQuestion($questionID, $data)
    {
        $stmt = $this->conn->prepare("UPDATE tblstudentquestions SET QuestionText = ?, AnswerOptions = ?, CorrectAnswer = ? WHERE QuestionID = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("sssi", $data['QuestionText'], $data['AnswerOptions'], $data['CorrectAnswer'], $questionID);

        if ($stmt->execute()) {
            return true; // Question successfully updated
        } else {
            throw new Exception("Error updating question: " . $stmt->error);
        }
    }

    // Delete a student question
    public function deleteQuestion($questionID)
    {
        $stmt = $this->conn->prepare("DELETE FROM tblstudentquestions WHERE QuestionID = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $questionID);

        if ($stmt->execute()) {
            return true; // Question successfully deleted
        } else {
            throw new Exception("Error deleting question: " . $stmt->error);
        }
    }

    // Fetch student's answer for a specific question
    public function fetchStudentAnswer($studentID, $questionID)
    {
        $stmt = $this->conn->prepare("SELECT Answer FROM tblscore WHERE StudentID = ? AND ExerciseID = ?");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ii", $studentID, $questionID);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc(); // Return answer as an associative array
        } else {
            throw new Exception("Error fetching student answer: " . $stmt->error);
        }
    }
}
