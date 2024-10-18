<?php
// Include the necessary files, like the Lesson class and the database connection
include_once 'classes/Courses.php';

if (isset($_GET['id'])) {
    $lessonID = $_GET['id'];

    // Create an instance of the Lesson class
    $lesson = new Course();

    try {
        // Call the delete method
        $result = $lesson->deleteLesson($lessonID);

        // If deletion is successful, redirect or display a success message
        if ($result) {
            header('Location: manage_courses.php?message=Lesson deleted successfully!');
            exit();
        }
    } catch (Exception $e) {
        // Handle errors, like lesson not found or failed to delete
        echo "Error: " . $e->getMessage();
    }
}
