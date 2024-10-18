<?php
include_once './classes/Users.php';

$user = new Users();

if (isset($_GET['id'])) {
    $studentID = $_GET['id'];

    try {
        if ($user->deleteStudent($studentID)) {
            // Display success alert and redirect
            echo "<script>
                    alert('Student deleted successfully!');
                    window.location.href = 'manage_students.php';
                  </script>";
        }
    } catch (Exception $e) {
        // Display error alert
        echo "<script>
                alert('Error: " . addslashes($e->getMessage()) . "');
                window.location.href = 'manage_students.php';
              </script>";
    }
} else {
    // Display error alert for no ID provided
    echo "<script>
            alert('No student ID provided!');
            window.location.href = 'manage_students.php';
          </script>";
}
