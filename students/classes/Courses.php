<?php
class Course
{
    private $conn;

    public function __construct()
    {
        // Include database connection
        include '../config/dbcon.php';
        $this->conn = $conn;
    }

    // Method to fetch all lessons
    public function fetchAllLessons()
    {
        $query = "SELECT LessonID, LessonChapter, LessonTitle, FileLocation, Category FROM tbllesson";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            return false; // Return false on failure
        }

        $lessons = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $lessons[] = $row;
        }

        return $lessons; // Return the array of lessons
    }

    // Method to create courses
    // Method to create lessons
    public function createLesson($lessonChapter, $lessonTitle, $category, $file)
    {
        // Ensure that the inputs are not empty
        if (empty($lessonChapter) || empty($lessonTitle) || empty($category) || empty($file['name'])) {
            return "All fields must be filled.";
        }

        // Determine the upload directory based on category
        $uploadDir = ($category === 'video') ? '../content/video/' : '../content/doc/';

        // Check if the upload directory exists, create it if not
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Handle file upload
        $fileName = basename($file['name']);
        $filePath = $uploadDir . $fileName;

        // Check for any upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return "Error uploading file: " . $this->getUploadError($file['error']);
        }

        // Move uploaded file to the designated directory
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            // Prepare SQL query to insert the lesson data into the tbllesson table
            $query = "INSERT INTO tbllesson (LessonChapter, LessonTitle, FileLocation, Category) 
                  VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($this->conn, $query);

            if ($stmt === false) {
                return "Error preparing statement: " . mysqli_error($this->conn);
            }

            mysqli_stmt_bind_param($stmt, 'ssss', $lessonChapter, $lessonTitle, $filePath, $category);

            if (mysqli_stmt_execute($stmt)) {
                return "Lesson created successfully!";
            } else {
                return "Error executing statement: " . mysqli_stmt_error($stmt);
            }
        } else {
            return "Error moving uploaded file.";
        }
    }

    // Helper method to get a human-readable error message for upload errors
    private function getUploadError($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
            case UPLOAD_ERR_FORM_SIZE:
                return "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
            case UPLOAD_ERR_PARTIAL:
                return "The uploaded file was only partially uploaded.";
            case UPLOAD_ERR_NO_FILE:
                return "No file was uploaded.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Missing a temporary folder.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Failed to write file to disk.";
            case UPLOAD_ERR_EXTENSION:
                return "File upload stopped by a PHP extension.";
            default:
                return "Unknown upload error.";
        }
    }


    // Fetch lesson by ID to pre-fill form fields
    public function fetchLessonByID($lessonID)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tbllesson WHERE LessonID = ?");
        $stmt->bind_param("i", $lessonID);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc(); // Return lesson as an associative array
        } else {
            throw new Exception("Failed to fetch lesson: " . $this->conn->error);
        }
    }

    // Update lesson method
    public function updateLesson($lessonID, $lessonChapter, $lessonTitle, $category, $file)
    {
        // Initialize query components
        $fileQuery = "";

        // Check if a new file is uploaded
        if ($file['size'] > 0) {
            // Handle file upload
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $targetFile);

            // Append the file update query
            $fileQuery = ", LessonFile = ?";
        }

        // Prepare the SQL update statement
        $sql = "UPDATE tbllesson 
                SET LessonChapter = ?, LessonTitle = ?, Category = ?" . $fileQuery . " 
                WHERE LessonID = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $this->conn->error);
        }

        // Bind parameters
        if ($fileQuery) {
            $stmt->bind_param("ssssi", $lessonChapter, $lessonTitle, $category, $targetFile, $lessonID);
        } else {
            $stmt->bind_param("sssi", $lessonChapter, $lessonTitle, $category, $lessonID);
        }

        // Execute the statement
        if ($stmt->execute()) {
            return "Lesson updated successfully!";
        } else {
            throw new Exception("Failed to update lesson: " . $stmt->error);
        }
    }

    // Method to delete a lesson by its ID
    public function deleteLesson($lessonID)
    {
        // Prepare the SQL delete statement
        $stmt = $this->conn->prepare("DELETE FROM tbllesson WHERE LessonID = ?");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Bind the lessonID parameter
        $stmt->bind_param("i", $lessonID);

        // Execute the query
        if ($stmt->execute()) {
            return true; // Lesson successfully deleted
        } else {
            throw new Exception("Error deleting lesson: " . $stmt->error);
        }
    }

    public function fetchAllVideos()
    {
        // Prepare the SQL select statement for videos
        $stmt = $this->conn->prepare("SELECT * FROM tbllesson WHERE Category = ?");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Set the category parameter to 'video'
        $category = 'video';
        $stmt->bind_param("s", $category);

        // Execute the query
        if ($stmt->execute()) {
            // Fetch the result
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC); // Return all video lessons as an associative array
            } else {
                return []; // Return an empty array if no video lessons are found
            }
        } else {
            throw new Exception("Error fetching video lessons: " . $stmt->error);
        }
    }

    public function fetchAllDocuments()
    {
        // Prepare the SQL select statement for videos
        $stmt = $this->conn->prepare("SELECT * FROM tbllesson WHERE Category = ?");

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->conn->error);
        }

        // Set the category parameter to 'video'
        $category = 'doc';
        $stmt->bind_param("s", $category);

        // Execute the query
        if ($stmt->execute()) {
            // Fetch the result
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return $result->fetch_all(MYSQLI_ASSOC); // Return all video lessons as an associative array
            } else {
                return []; // Return an empty array if no video lessons are found
            }
        } else {
            throw new Exception("Error fetching Documents lessons: " . $stmt->error);
        }
    }

    public function getLessonDetails($lessonID)
    {
        $stmt = $this->conn->prepare("SELECT LessonChapter, LessonTitle, Category FROM tbllesson WHERE LessonID = ?");
        $stmt->bind_param("i", $lessonID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Fetch lesson details as an associative array
    }
}
