<?php
class Exercise
{
    private $conn;

    public function __construct()
    {
        // Include database connection
        include '../config/dbcon.php';
        $this->conn = $conn; // Assuming $conn is a PDO instance
    }

    // Create exercise
    public function createExercise($lessonID, $question, $choiceA, $choiceB, $choiceC, $choiceD, $answer)
    {
        // Prepare SQL statement
        $stmt = $this->conn->prepare("INSERT INTO tblexercise (LessonID, Question, ChoiceA, ChoiceB, ChoiceC, ChoiceD, Answer) VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Check for preparation error
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters
        $stmt->bindParam(1, $lessonID, PDO::PARAM_INT);
        $stmt->bindParam(2, $question, PDO::PARAM_STR);
        $stmt->bindParam(3, $choiceA, PDO::PARAM_STR);
        $stmt->bindParam(4, $choiceB, PDO::PARAM_STR);
        $stmt->bindParam(5, $choiceC, PDO::PARAM_STR);
        $stmt->bindParam(6, $choiceD, PDO::PARAM_STR);
        $stmt->bindParam(7, $answer, PDO::PARAM_STR);

        // Execute the statement
        if ($stmt->execute()) {
            return "Exercise created successfully!";
        } else {
            throw new Exception("Error creating exercise: " . $stmt->error);
        }
    }

    // Fetch all exercises with lesson names
    public function fetchAllExercises()
    {
        $query = "
        SELECT 
            e.ExerciseID, 
            e.LessonID, 
            e.Question, 
            e.ChoiceA, 
            e.ChoiceB, 
            e.ChoiceC, 
            e.ChoiceD, 
            e.Answer, 
            e.ExercisesDate, 
            l.LessonTitle, 
            l.LessonChapter
        FROM 
            tblexercise e 
        JOIN 
            tbllesson l ON e.LessonID = l.LessonID
    ";

        // Execute the query
        $result = $this->conn->query($query);

        // Check for query error
        if (!$result) {
            throw new Exception("Query failed: " . $this->conn->error);
        }

        // Fetch all rows as an associative array
        $exercises = [];
        while ($row = $result->fetch_assoc()) {
            $exercises[] = $row;
        }

        return $exercises; // Return the array of exercises
    }


    // Fetch exercise by ID
    public function fetchExerciseByID($exerciseID)
    {
        // Prepare the SQL statement
        $stmt = $this->conn->prepare("SELECT * FROM tblexercise WHERE ExerciseID = ?");

        // Check if the preparation failed
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters
        $stmt->bind_param("i", $exerciseID); // Using bind_param for mysqli

        // Execute the query
        if (!$stmt->execute()) {
            throw new Exception("Query execution failed: " . $stmt->error);
        }

        // Fetch the exercise data
        $result = $stmt->get_result(); // Use get_result to fetch the result set
        return $result->fetch_assoc() ?: null; // Return exercise data or null if not found
    }



    // Update exercise
    public function updateExercise($exerciseID, $lessonID, $question, $choiceA, $choiceB, $choiceC, $choiceD, $answer)
    {
        // Prepare SQL statement with positional placeholders for mysqli
        $stmt = $this->conn->prepare("UPDATE tblexercise SET 
            LessonID = ?, 
            Question = ?, 
            ChoiceA = ?, 
            ChoiceB = ?, 
            ChoiceC = ?, 
            ChoiceD = ?, 
            Answer = ? 
        WHERE ExerciseID = ?");

        // Check if the statement was prepared successfully
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind parameters to the statement (we assume LessonID and ExerciseID are integers, others are strings)
        $stmt->bind_param("issssssi", $lessonID, $question, $choiceA, $choiceB, $choiceC, $choiceD, $answer, $exerciseID);

        // Execute the statement
        if ($stmt->execute()) {
            return "Exercise updated successfully!";
        } else {
            throw new Exception("Failed to update exercise: " . $stmt->error);
        }
    }


    // Method to delete an exercise by its ID
    public function deleteExercise($exerciseID)
    {
        // Prepare the SQL delete statement
        $stmt = $this->conn->prepare("DELETE FROM tblexercise WHERE ExerciseID = ?");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind the exerciseID parameter
        $stmt->bind_param("i", $exerciseID);

        // Execute the statement
        if ($stmt->execute()) {
            return true; // Exercise deleted successfully
        } else {
            throw new Exception("Error deleting exercise: " . $stmt->error);
        }
    }
}
