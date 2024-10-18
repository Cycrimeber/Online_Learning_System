<?php
// Include the Exercise class and the DB connection
include_once 'classes/Exercise.php';

if (isset($_GET['id'])) {
    $exerciseID = $_GET['id'];

    // Create an instance of the Exercise class
    $exercise = new Exercise();

    try {
        // Call the delete method
        $result = $exercise->deleteExercise($exerciseID);

        // If deletion was successful, redirect or display a success message
        if ($result) {
            header('Location: manage_exercises.php?message=Exercise deleted successfully!');
            exit();
        }
    } catch (Exception $e) {
        // Handle errors, like exercise not found
        echo "Error: " . $e->getMessage();
    }
}
