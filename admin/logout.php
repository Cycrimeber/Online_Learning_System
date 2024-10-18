<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page or home page
    header("Location: ../index.php"); // Change this to your desired redirect page
    exit();
} else {
    // If the user is not logged in, redirect to login page
    header("Location: ../index.php"); // Change this to your desired redirect page
    exit();
}
